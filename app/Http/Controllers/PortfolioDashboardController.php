<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\DashboardAccessRequest;
use App\Models\PortfolioSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class PortfolioDashboardController extends Controller
{
    public function edit(): View
    {
        $portfolio = PortfolioSetting::singleton();

        $accessRequests = collect();
        $contactMessages = collect();
        if (request()->user()?->isAdmin()) {
            $accessRequests = DashboardAccessRequest::query()
                ->latest()
                ->limit(20)
                ->get();

            if (Schema::hasTable('contact_messages')) {
                $contactMessages = ContactMessage::query()
                    ->latest()
                    ->limit(20)
                    ->get();
            }
        }

        return view('portfolio.dashboard', compact('portfolio', 'accessRequests', 'contactMessages'));
    }

    public function update(Request $request): RedirectResponse
    {
        $socialInputs = $request->input('socials', []);
        if (! is_array($socialInputs)) {
            $socialInputs = [];
        }

        $normalizedSocials = [];
        foreach ($socialInputs as $row) {
            if (! is_array($row)) {
                continue;
            }

            $row['url'] = $this->normalizeUrlInput($row['url'] ?? null);
            $normalizedSocials[] = $row;
        }

        $request->merge([
            'socials' => $normalizedSocials,
        ]);

        $validated = $request->validate([
            'site_title' => ['required', 'string', 'max:255'],
            'person_name' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string'],
            'hero_subtitle' => ['required', 'string'],
            'availability' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'avatar_url' => ['nullable', 'url'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'popup_message' => ['nullable', 'string', 'max:255'],
            'badges' => ['nullable', 'array'],
            'badges.*' => ['nullable', 'string', 'max:255'],
            'graph_points' => ['nullable', 'array'],
            'graph_points.*' => ['nullable', 'numeric'],
            'stats' => ['nullable', 'array'],
            'stats.*.label' => ['nullable', 'string', 'max:255'],
            'stats.*.value' => ['nullable', 'string', 'max:255'],
            'about_cards' => ['nullable', 'array'],
            'about_cards.*.title' => ['nullable', 'string', 'max:255'],
            'about_cards.*.description' => ['nullable', 'string'],
            'about_cards.*.tags_text' => ['nullable', 'string', 'max:1000'],
            'projects' => ['nullable', 'array'],
            'projects.*.title' => ['nullable', 'string', 'max:255'],
            'projects.*.description' => ['nullable', 'string'],
            'projects.*.image_url' => ['nullable', 'url'],
            'projects.*.live_url' => ['nullable', 'url'],
            'projects.*.code_url' => ['nullable', 'url'],
            'projects.*.tags_text' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'array'],
            'skills.*.name' => ['nullable', 'string', 'max:255'],
            'skills.*.icon' => ['nullable', 'url'],
            'experiences' => ['nullable', 'array'],
            'experiences.*.title' => ['nullable', 'string', 'max:255'],
            'experiences.*.period' => ['nullable', 'string', 'max:255'],
            'experiences.*.description' => ['nullable', 'string'],
            'socials' => ['nullable', 'array'],
            'socials.*.platform' => ['nullable', 'string', 'max:255'],
            'socials.*.url' => ['nullable', 'url'],
            'socials.*.handle' => ['nullable', 'string', 'max:255'],
            'upcoming_projects' => ['nullable', 'array'],
            'upcoming_projects.*.title' => ['nullable', 'string', 'max:255'],
            'upcoming_projects.*.eta' => ['nullable', 'string', 'max:255'],
            'upcoming_projects.*.details' => ['nullable', 'string'],
            'updates_feed' => ['nullable', 'array'],
            'updates_feed.*.title' => ['nullable', 'string', 'max:255'],
            'updates_feed.*.date' => ['nullable', 'string', 'max:255'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $validated['badges'] = $this->normalizeSimpleList($request->input('badges', []));
        $validated['graph_points'] = $this->normalizeNumberList($request->input('graph_points', []));
        $validated['stats'] = $this->normalizeRows($request->input('stats', []), ['label', 'value']);
        $validated['about_cards'] = $this->normalizeRowsWithTags($request->input('about_cards', []), ['title', 'description']);
        $validated['projects'] = $this->normalizeRowsWithTags($request->input('projects', []), ['title', 'description', 'image_url', 'live_url', 'code_url']);
        $validated['skills'] = $this->normalizeRows($request->input('skills', []), ['name', 'icon']);
        $validated['experiences'] = $this->normalizeRows($request->input('experiences', []), ['title', 'period', 'description']);
        $validated['socials'] = $this->normalizeRows($request->input('socials', []), ['platform', 'url', 'handle']);
        $validated['upcoming_projects'] = $this->normalizeRows($request->input('upcoming_projects', []), ['title', 'eta', 'details']);
        $validated['updates_feed'] = $this->normalizeRows($request->input('updates_feed', []), ['title', 'date']);

        if (! $request->user()?->isAdmin()) {
            unset($validated['admin_notes']);
        }

        $portfolio = PortfolioSetting::singleton();
        $portfolio->update($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Portfolio content updated successfully.');
    }

    /**
     * @param array<int, mixed> $values
     * @return array<int, string>
     */
    private function normalizeSimpleList(array $values): array
    {
        return array_values(array_filter(array_map(function ($item) {
            return trim((string) $item);
        }, $values), fn ($item) => $item !== ''));
    }

    /**
     * @param array<int, mixed> $values
     * @return array<int, int|float>
     */
    private function normalizeNumberList(array $values): array
    {
        return array_values(array_filter(array_map(function ($item) {
            if ($item === '' || $item === null) {
                return null;
            }

            return is_numeric($item) ? $item + 0 : null;
        }, $values), fn ($item) => $item !== null));
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @param array<int, string> $fields
     * @return array<int, array<string, string>>
     */
    private function normalizeRows(array $rows, array $fields): array
    {
        $normalized = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $mapped = [];
            $hasAny = false;

            foreach ($fields as $field) {
                $value = trim((string) ($row[$field] ?? ''));
                $mapped[$field] = $value;
                $hasAny = $hasAny || $value !== '';
            }

            if ($hasAny) {
                $normalized[] = $mapped;
            }
        }

        return $normalized;
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @param array<int, string> $fields
     * @return array<int, array<string, mixed>>
     */
    private function normalizeRowsWithTags(array $rows, array $fields): array
    {
        $normalized = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $mapped = [];
            $hasAny = false;

            foreach ($fields as $field) {
                $value = trim((string) ($row[$field] ?? ''));
                $mapped[$field] = $value;
                $hasAny = $hasAny || $value !== '';
            }

            $tagsText = trim((string) ($row['tags_text'] ?? ''));
            $tags = array_values(array_filter(array_map('trim', explode(',', $tagsText)), fn ($tag) => $tag !== ''));
            $mapped['tags'] = $tags;

            if ($hasAny || ! empty($tags)) {
                $normalized[] = $mapped;
            }
        }

        return $normalized;
    }

    private function normalizeUrlInput(mixed $value): ?string
    {
        $url = trim((string) $value);

        if ($url === '') {
            return null;
        }

        if (! preg_match('/^[a-z][a-z0-9+\-.]*:\/\//i', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }
}
