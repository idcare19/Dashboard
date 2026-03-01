<?php

namespace Tests\Feature;

use App\Models\PortfolioSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioDynamicTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_page_renders_dynamic_content(): void
    {
        PortfolioSetting::create([
            'site_title' => 'Portfolio • Dynamic Test',
            'person_name' => 'Dynamic Name',
            'hero_title' => 'Build dynamic things.',
            'hero_subtitle' => 'Subtitle from database',
            'badges' => ['One', 'Two'],
            'stats' => [['label' => 'Projects', 'value' => '10']],
            'about_cards' => [['title' => 'About A', 'description' => 'Desc', 'tags' => ['Tag']]],
            'projects' => [['title' => 'Project A', 'description' => 'Desc', 'image_url' => '', 'live_url' => '', 'code_url' => '', 'tags' => ['Laravel']]],
            'skills' => [['name' => 'PHP', 'icon' => '']],
            'experiences' => [['title' => 'Freelancer', 'period' => '2026', 'description' => 'Doing things']],
            'socials' => [['platform' => 'GitHub', 'url' => 'https://github.com/example', 'handle' => '@example']],
        ]);

        $response = $this->get(route('portfolio'));

        $response->assertOk();
        $response->assertSee('Dynamic Name');
        $response->assertSee('Project A');
        $response->assertSee('PHP');
    }

    public function test_dashboard_update_persists_portfolio_content(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user);

        $this->get(route('dashboard'));

        $payload = [
            'site_title' => 'Portfolio • Updated',
            'person_name' => 'Abhishek Updated',
            'hero_title' => 'Updated hero title',
            'hero_subtitle' => 'Updated subtitle',
            'availability' => 'Available now',
            'location' => 'India',
            'avatar_url' => 'https://example.com/avatar.jpg',
            'contact_email' => 'updated@example.com',
            'popup_message' => 'Work in progress',
            'badges' => ['Available now', 'Remote'],
            'stats' => [
                ['label' => 'Projects', 'value' => '12'],
                ['label' => 'Experience', 'value' => '2y'],
            ],
            'about_cards' => [
                ['title' => 'Who', 'description' => 'About me', 'tags_text' => 'A, B'],
            ],
            'projects' => [
                ['title' => 'Proj', 'description' => 'Desc', 'image_url' => 'https://example.com/image.jpg', 'live_url' => 'https://example.com/live', 'code_url' => 'https://example.com/code', 'tags_text' => 'Laravel'],
            ],
            'skills' => [
                ['name' => 'Laravel', 'icon' => ''],
            ],
            'experiences' => [
                ['title' => 'Dev', 'period' => '2026', 'description' => 'Experience'],
            ],
            'socials' => [
                ['platform' => 'GitHub', 'url' => 'https://github.com/idcare19', 'handle' => '@idcare19'],
            ],
            'graph_points' => [10, 20, 30],
            'upcoming_projects' => [
                ['title' => 'Upcoming A', 'eta' => 'Q2', 'details' => 'Details'],
            ],
            'updates_feed' => [
                ['title' => 'Updated something', 'date' => '2026-03-01'],
            ],
            'admin_notes' => 'Sensitive admin note',
        ];

        $response = $this->put(route('dashboard.update'), $payload);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('portfolio_settings', [
            'site_title' => 'Portfolio • Updated',
            'person_name' => 'Abhishek Updated',
            'contact_email' => 'updated@example.com',
        ]);
    }

    public function test_contact_form_submission_is_saved(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Hello from contact form',
        ]);

        $response->assertRedirect(route('portfolio') . '#contact');
        $response->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Hello from contact form',
        ]);
    }

    public function test_dashboard_update_accepts_social_url_without_scheme(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user);

        $response = $this->put(route('dashboard.update'), [
            'site_title' => 'Portfolio • URL fix',
            'person_name' => 'Abhishek',
            'hero_title' => 'Hero title',
            'hero_subtitle' => 'Hero subtitle',
            'socials' => [
                [
                    'platform' => 'GitHub',
                    'url' => 'github.com/idcare19',
                    'handle' => '@idcare19',
                ],
            ],
        ]);

        $response->assertRedirect(route('dashboard'));

        $portfolio = PortfolioSetting::first();
        if ($portfolio === null) {
            throw new \RuntimeException('Portfolio row was not saved.');
        }

        if (($portfolio->socials[0]['url'] ?? null) !== 'https://github.com/idcare19') {
            throw new \RuntimeException('Social URL was not normalized correctly.');
        }
    }
}
