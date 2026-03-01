@extends('layouts.app')

@section('title', 'Portfolio Dashboard')

@section('content')
    <style>
        .editor-chip {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font-size: .78rem;
            border-radius: 999px;
            padding: .3rem .7rem;
            border: 1px solid rgba(147, 170, 255, .32);
            background: rgba(120, 142, 255, .12);
            color: #dbe5ff;
        }

        .editor-section {
            background: rgba(8, 17, 36, .45);
            border: 1px solid rgba(145, 167, 255, .2);
            border-radius: 14px;
            padding: .9rem;
        }

        .editor-sticky-bar {
            position: sticky;
            bottom: .75rem;
            z-index: 10;
        }
    </style>

    <section class="glass p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <div>
                <h1 class="h3 mb-1">Portfolio Dashboard</h1>
                <p class="text-muted-x mb-0">Modern editor mode — updates are reflected in live preview instantly ⚡</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="editor-chip" id="editor-state-chip">✅ All changes saved</span>
                <a href="{{ route('portfolio') }}" class="btn btn-outline-light" target="_blank">Preview Portfolio</a>
            </div>
        </div>

        @php
            $badgeRows = old('badges', $portfolio->badges ?? ['']);
            $statRows = old('stats', $portfolio->stats ?? [['label' => '', 'value' => '']]);
            $aboutRows = old('about_cards', collect($portfolio->about_cards ?? [])->map(fn ($row) => [
                'title' => $row['title'] ?? '',
                'description' => $row['description'] ?? '',
                'tags_text' => implode(', ', $row['tags'] ?? []),
            ])->toArray());
            $aboutRows = count($aboutRows) ? $aboutRows : [['title' => '', 'description' => '', 'tags_text' => '']];

            $projectRows = old('projects', collect($portfolio->projects ?? [])->map(fn ($row) => [
                'title' => $row['title'] ?? '',
                'description' => $row['description'] ?? '',
                'image_url' => $row['image_url'] ?? '',
                'live_url' => $row['live_url'] ?? '',
                'code_url' => $row['code_url'] ?? '',
                'tags_text' => implode(', ', $row['tags'] ?? []),
            ])->toArray());
            $projectRows = count($projectRows) ? $projectRows : [['title' => '', 'description' => '', 'image_url' => '', 'live_url' => '', 'code_url' => '', 'tags_text' => '']];

            $skillRows = old('skills', $portfolio->skills ?? [['name' => '', 'icon' => '']]);
            $experienceRows = old('experiences', $portfolio->experiences ?? [['title' => '', 'period' => '', 'description' => '']]);
            $socialRows = old('socials', $portfolio->socials ?? [['platform' => '', 'url' => '', 'handle' => '']]);
            $graphRows = old('graph_points', $portfolio->graph_points ?? [12, 18, 15, 26, 31, 28, 34]);
            if (! is_array($graphRows) || count($graphRows) === 0) {
                $graphRows = [12, 18, 15, 26, 31, 28, 34];
            }
            $upcomingRows = old('upcoming_projects', $portfolio->upcoming_projects ?? [['title' => '', 'eta' => '', 'details' => '']]);
            $updateRows = old('updates_feed', $portfolio->updates_feed ?? [['title' => '', 'date' => '']]);
        @endphp

        <div class="row g-3 mb-3">
            <div class="col-12 col-xl-7">
                <div class="glass p-3 h-100 border border-primary-subtle">
                    <div class="small text-uppercase text-muted-x mb-2">Live Content Snapshot</div>
                    <h2 class="h4 mb-1" id="preview-site-title">{{ old('site_title', $portfolio->site_title) }}</h2>
                    <p class="mb-1"><strong id="preview-person-name">{{ old('person_name', $portfolio->person_name) }}</strong></p>
                    <p class="mb-2 text-info" id="preview-hero-title">{{ old('hero_title', $portfolio->hero_title) }}</p>
                    <p class="small text-muted-x mb-3" id="preview-hero-subtitle">{{ old('hero_subtitle', $portfolio->hero_subtitle) }}</p>

                    <div class="d-flex flex-wrap gap-2 mb-3" id="preview-badges-wrap">
                        @foreach ($badgeRows as $badge)
                            @if (filled($badge))
                                <span class="badge text-bg-secondary">{{ $badge }}</span>
                            @endif
                        @endforeach
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6 col-md-3">
                            <div class="border rounded p-2 text-center">
                                <div class="fw-bold" id="preview-project-count">{{ collect($projectRows)->filter(fn ($row) => filled($row['title'] ?? null))->count() }}</div>
                                <div class="small text-muted-x">Projects</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="border rounded p-2 text-center">
                                <div class="fw-bold" id="preview-skill-count">{{ collect($skillRows)->filter(fn ($row) => filled($row['name'] ?? null))->count() }}</div>
                                <div class="small text-muted-x">Skills</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="border rounded p-2 text-center">
                                <div class="fw-bold" id="preview-social-count">{{ collect($socialRows)->filter(fn ($row) => filled($row['platform'] ?? null))->count() }}</div>
                                <div class="small text-muted-x">Socials</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="border rounded p-2 text-center">
                                <div class="fw-bold" id="preview-update-count">{{ collect($updateRows)->filter(fn ($row) => filled($row['title'] ?? null))->count() }}</div>
                                <div class="small text-muted-x">Updates</div>
                            </div>
                        </div>
                    </div>

                    <div class="small text-muted-x">Primary contact:</div>
                    <div id="preview-contact-email">{{ old('contact_email', $portfolio->contact_email) ?: 'Not set yet' }}</div>
                </div>
            </div>
            <div class="col-12 col-xl-5">
                <div class="glass p-3 h-100">
                    <div class="small text-uppercase text-muted-x mb-2">Quick Tips</div>
                    <ul class="mb-0 text-muted-x small">
                        <li>Add/remove rows with the section buttons.</li>
                        <li>Social URLs can be pasted without https (auto-fixed server-side).</li>
                        <li>Leave Live/Code URL empty to show “under development” popup in portfolio.</li>
                        <li>Use concise update titles so mobile cards stay clean.</li>
                    </ul>
                </div>
            </div>
        </div>

        <form action="{{ route('dashboard.update') }}" method="POST" class="row g-3" id="dashboard-editor-form">
            @csrf
            @method('PUT')

            <div class="col-12 col-md-6">
                <label class="form-label">Site Title</label>
                <input type="text" name="site_title" class="form-control" value="{{ old('site_title', $portfolio->site_title) }}" data-preview-target="preview-site-title" required>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">Person Name</label>
                <input type="text" name="person_name" class="form-control" value="{{ old('person_name', $portfolio->person_name) }}" data-preview-target="preview-person-name" required>
            </div>

            <div class="col-12">
                <label class="form-label">Hero Title</label>
                <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $portfolio->hero_title) }}" data-preview-target="preview-hero-title" required>
            </div>

            <div class="col-12">
                <label class="form-label">Hero Subtitle</label>
                <textarea name="hero_subtitle" class="form-control" rows="2" data-preview-target="preview-hero-subtitle" required>{{ old('hero_subtitle', $portfolio->hero_subtitle) }}</textarea>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Availability</label>
                <input type="text" name="availability" class="form-control" value="{{ old('availability', $portfolio->availability) }}">
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $portfolio->location) }}">
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $portfolio->contact_email) }}" data-preview-target="preview-contact-email">
            </div>

            <div class="col-12 col-md-8">
                <label class="form-label">Avatar URL</label>
                <input type="url" name="avatar_url" class="form-control" value="{{ old('avatar_url', $portfolio->avatar_url) }}">
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Popup Message</label>
                <input type="text" name="popup_message" class="form-control" value="{{ old('popup_message', $portfolio->popup_message) }}">
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Badges</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="badgeRows">+ Add Badge</button>
                </div>
                <div id="badgeRows" class="d-grid gap-2">
                    @foreach ($badgeRows as $badge)
                        <div class="d-flex gap-2 repeater-row">
                            <input type="text" name="badges[]" class="form-control" value="{{ $badge }}" placeholder="Badge text">
                            <button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Stats</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="statRows">+ Add Stat</button>
                </div>
                <div id="statRows" class="d-grid gap-2">
                    @foreach ($statRows as $row)
                        <div class="row g-2 align-items-center repeater-row">
                            <div class="col-12 col-md-5"><input type="text" name="stats[][label]" class="form-control" placeholder="Label" value="{{ $row['label'] ?? '' }}"></div>
                            <div class="col-10 col-md-5"><input type="text" name="stats[][value]" class="form-control" placeholder="Value" value="{{ $row['value'] ?? '' }}"></div>
                            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">About Cards</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="aboutRows">+ Add Card</button>
                </div>
                <div id="aboutRows" class="d-grid gap-2">
                    @foreach ($aboutRows as $row)
                        <div class="glass p-2 repeater-row">
                            <div class="row g-2">
                                <div class="col-12 col-md-4"><input type="text" name="about_cards[][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}"></div>
                                <div class="col-12 col-md-8"><input type="text" name="about_cards[][tags_text]" class="form-control" placeholder="Tags (comma separated)" value="{{ $row['tags_text'] ?? '' }}"></div>
                                <div class="col-12"><textarea name="about_cards[][description]" class="form-control" rows="2" placeholder="Description">{{ $row['description'] ?? '' }}</textarea></div>
                                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Projects</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="projectRows">+ Add Project</button>
                </div>
                <div id="projectRows" class="d-grid gap-2">
                    @foreach ($projectRows as $row)
                        <div class="glass p-2 repeater-row">
                            <div class="row g-2">
                                <div class="col-12 col-md-6"><input type="text" name="projects[][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}"></div>
                                <div class="col-12 col-md-6"><input type="text" name="projects[][tags_text]" class="form-control" placeholder="Tags (comma separated)" value="{{ $row['tags_text'] ?? '' }}"></div>
                                <div class="col-12"><textarea name="projects[][description]" class="form-control" rows="2" placeholder="Description">{{ $row['description'] ?? '' }}</textarea></div>
                                <div class="col-12 col-md-4"><input type="url" name="projects[][image_url]" class="form-control" placeholder="Image URL" value="{{ $row['image_url'] ?? '' }}"></div>
                                <div class="col-12 col-md-4"><input type="url" name="projects[][live_url]" class="form-control" placeholder="Live URL" value="{{ $row['live_url'] ?? '' }}"></div>
                                <div class="col-12 col-md-4"><input type="url" name="projects[][code_url]" class="form-control" placeholder="Code URL" value="{{ $row['code_url'] ?? '' }}"></div>
                                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Skills</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="skillRows">+ Add Skill</button>
                </div>
                <div id="skillRows" class="d-grid gap-2">
                    @foreach ($skillRows as $row)
                        <div class="row g-2 align-items-center repeater-row">
                            <div class="col-12 col-md-4"><input type="text" name="skills[][name]" class="form-control" placeholder="Skill name" value="{{ $row['name'] ?? '' }}"></div>
                            <div class="col-10 col-md-6"><input type="url" name="skills[][icon]" class="form-control" placeholder="Icon URL" value="{{ $row['icon'] ?? '' }}"></div>
                            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Experience Timeline</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="experienceRows">+ Add Experience</button>
                </div>
                <div id="experienceRows" class="d-grid gap-2">
                    @foreach ($experienceRows as $row)
                        <div class="glass p-2 repeater-row">
                            <div class="row g-2">
                                <div class="col-12 col-md-6"><input type="text" name="experiences[][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}"></div>
                                <div class="col-12 col-md-6"><input type="text" name="experiences[][period]" class="form-control" placeholder="Period" value="{{ $row['period'] ?? '' }}"></div>
                                <div class="col-12"><textarea name="experiences[][description]" class="form-control" rows="2" placeholder="Description">{{ $row['description'] ?? '' }}</textarea></div>
                                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Social Links</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="socialRows">+ Add Social</button>
                </div>
                <div id="socialRows" class="d-grid gap-2">
                    @foreach ($socialRows as $row)
                        <div class="row g-2 align-items-center repeater-row">
                            <div class="col-12 col-md-3"><input type="text" name="socials[][platform]" class="form-control" placeholder="Platform" value="{{ $row['platform'] ?? '' }}"></div>
                            <div class="col-12 col-md-5"><input type="url" name="socials[][url]" class="form-control" placeholder="URL" value="{{ $row['url'] ?? '' }}"></div>
                            <div class="col-10 col-md-3"><input type="text" name="socials[][handle]" class="form-control" placeholder="Handle" value="{{ $row['handle'] ?? '' }}"></div>
                            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Graph Points</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="graphRows">+ Add Point</button>
                </div>
                <div id="graphRows" class="d-grid gap-2">
                    @foreach ($graphRows as $point)
                        <div class="d-flex gap-2 repeater-row">
                            <input type="number" step="any" name="graph_points[]" class="form-control" value="{{ $point }}" placeholder="Point value">
                            <button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Upcoming Projects</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="upcomingRows">+ Add Upcoming</button>
                </div>
                <div id="upcomingRows" class="d-grid gap-2">
                    @foreach ($upcomingRows as $row)
                        <div class="glass p-2 repeater-row">
                            <div class="row g-2">
                                <div class="col-12 col-md-6"><input type="text" name="upcoming_projects[][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}"></div>
                                <div class="col-12 col-md-6"><input type="text" name="upcoming_projects[][eta]" class="form-control" placeholder="ETA" value="{{ $row['eta'] ?? '' }}"></div>
                                <div class="col-12"><textarea name="upcoming_projects[][details]" class="form-control" rows="2" placeholder="Details">{{ $row['details'] ?? '' }}</textarea></div>
                                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            <div class="col-12">
                <div class="editor-section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Updates Feed</label>
                    <button type="button" class="btn btn-sm btn-outline-light" data-add-row="updateRows">+ Add Update</button>
                </div>
                <div id="updateRows" class="d-grid gap-2">
                    @foreach ($updateRows as $row)
                        <div class="row g-2 align-items-center repeater-row">
                            <div class="col-12 col-md-7"><input type="text" name="updates_feed[][title]" class="form-control" placeholder="Update title" value="{{ $row['title'] ?? '' }}"></div>
                            <div class="col-10 col-md-3"><input type="text" name="updates_feed[][date]" class="form-control" placeholder="Date" value="{{ $row['date'] ?? '' }}"></div>
                            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            @if (auth()->user()?->isAdmin())
                <div class="col-12">
                    <label class="form-label">Admin Notes (Admin only)</label>
                    <textarea name="admin_notes" class="form-control" rows="4">{{ old('admin_notes', $portfolio->admin_notes) }}</textarea>
                </div>
            @endif

            <div class="col-12 editor-sticky-bar">
                <div class="glass p-2 p-md-3 d-flex gap-2 flex-wrap justify-content-between align-items-center">
                    <span class="text-muted-x small">Tip: Use this bar while scrolling long forms.</span>
                    <div class="d-flex gap-2">
                        @if (auth()->user()?->isAdmin())
                            <a href="{{ route('users.index') }}" class="btn btn-outline-light">Manage Users</a>
                        @endif
                        <button type="submit" class="btn btn-primary" id="dashboard-save-btn">Save All Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    @if (auth()->user()?->isAdmin())
        <section class="glass p-3 p-md-4 mt-3">
            <h2 class="h4 mb-3">Temporary Access Requests (1-hour keys)</h2>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle mb-0 table-glass">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Expires</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (($accessRequests ?? collect()) as $accessRequest)
                            <tr>
                                <td>{{ $accessRequest->email }}</td>
                                <td class="text-muted-x">{{ $accessRequest->message ?: '-' }}</td>
                                <td>
                                    <span class="badge {{ $accessRequest->status === 'approved' ? 'text-bg-success' : ($accessRequest->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">
                                        {{ ucfirst($accessRequest->status) }}
                                    </span>
                                </td>
                                <td>{{ $accessRequest->access_key_expires_at?->format('M d, Y H:i') ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <form method="POST" action="{{ route('access.approve', $accessRequest) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-outline-success" type="submit">Approve</button>
                                        </form>

                                        <form method="POST" action="{{ route('access.reject', $accessRequest) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted-x">No access requests yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="glass p-3 p-md-4 mt-3">
            <h2 class="h4 mb-3">Contact Messages</h2>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle mb-0 table-glass">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (($contactMessages ?? collect()) as $contactMessage)
                            <tr>
                                <td>{{ $contactMessage->name }}</td>
                                <td>
                                    <a class="link-info" href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
                                </td>
                                <td class="text-muted-x" style="max-width: 420px; white-space: pre-wrap;">{{ $contactMessage->message }}</td>
                                <td>{{ $contactMessage->created_at?->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted-x">No contact messages yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endif

    <template id="tpl-badgeRows">
        <div class="d-flex gap-2 repeater-row">
            <input type="text" name="badges[]" class="form-control" placeholder="Badge text">
            <button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button>
        </div>
    </template>

    <template id="tpl-statRows">
        <div class="row g-2 align-items-center repeater-row">
            <div class="col-12 col-md-5"><input type="text" name="stats[][label]" class="form-control" placeholder="Label"></div>
            <div class="col-10 col-md-5"><input type="text" name="stats[][value]" class="form-control" placeholder="Value"></div>
            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
        </div>
    </template>

    <template id="tpl-aboutRows">
        <div class="glass p-2 repeater-row">
            <div class="row g-2">
                <div class="col-12 col-md-4"><input type="text" name="about_cards[][title]" class="form-control" placeholder="Title"></div>
                <div class="col-12 col-md-8"><input type="text" name="about_cards[][tags_text]" class="form-control" placeholder="Tags (comma separated)"></div>
                <div class="col-12"><textarea name="about_cards[][description]" class="form-control" rows="2" placeholder="Description"></textarea></div>
                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
            </div>
        </div>
    </template>

    <template id="tpl-projectRows">
        <div class="glass p-2 repeater-row">
            <div class="row g-2">
                <div class="col-12 col-md-6"><input type="text" name="projects[][title]" class="form-control" placeholder="Title"></div>
                <div class="col-12 col-md-6"><input type="text" name="projects[][tags_text]" class="form-control" placeholder="Tags (comma separated)"></div>
                <div class="col-12"><textarea name="projects[][description]" class="form-control" rows="2" placeholder="Description"></textarea></div>
                <div class="col-12 col-md-4"><input type="url" name="projects[][image_url]" class="form-control" placeholder="Image URL"></div>
                <div class="col-12 col-md-4"><input type="url" name="projects[][live_url]" class="form-control" placeholder="Live URL"></div>
                <div class="col-12 col-md-4"><input type="url" name="projects[][code_url]" class="form-control" placeholder="Code URL"></div>
                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
            </div>
        </div>
    </template>

    <template id="tpl-skillRows">
        <div class="row g-2 align-items-center repeater-row">
            <div class="col-12 col-md-4"><input type="text" name="skills[][name]" class="form-control" placeholder="Skill name"></div>
            <div class="col-10 col-md-6"><input type="url" name="skills[][icon]" class="form-control" placeholder="Icon URL"></div>
            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
        </div>
    </template>

    <template id="tpl-experienceRows">
        <div class="glass p-2 repeater-row">
            <div class="row g-2">
                <div class="col-12 col-md-6"><input type="text" name="experiences[][title]" class="form-control" placeholder="Title"></div>
                <div class="col-12 col-md-6"><input type="text" name="experiences[][period]" class="form-control" placeholder="Period"></div>
                <div class="col-12"><textarea name="experiences[][description]" class="form-control" rows="2" placeholder="Description"></textarea></div>
                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
            </div>
        </div>
    </template>

    <template id="tpl-socialRows">
        <div class="row g-2 align-items-center repeater-row">
            <div class="col-12 col-md-3"><input type="text" name="socials[][platform]" class="form-control" placeholder="Platform"></div>
            <div class="col-12 col-md-5"><input type="url" name="socials[][url]" class="form-control" placeholder="URL"></div>
            <div class="col-10 col-md-3"><input type="text" name="socials[][handle]" class="form-control" placeholder="Handle"></div>
            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
        </div>
    </template>

    <template id="tpl-graphRows">
        <div class="d-flex gap-2 repeater-row">
            <input type="number" step="any" name="graph_points[]" class="form-control" placeholder="Point value">
            <button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button>
        </div>
    </template>

    <template id="tpl-upcomingRows">
        <div class="glass p-2 repeater-row">
            <div class="row g-2">
                <div class="col-12 col-md-6"><input type="text" name="upcoming_projects[][title]" class="form-control" placeholder="Title"></div>
                <div class="col-12 col-md-6"><input type="text" name="upcoming_projects[][eta]" class="form-control" placeholder="ETA"></div>
                <div class="col-12"><textarea name="upcoming_projects[][details]" class="form-control" rows="2" placeholder="Details"></textarea></div>
                <div class="col-12 text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-row>Remove</button></div>
            </div>
        </div>
    </template>

    <template id="tpl-updateRows">
        <div class="row g-2 align-items-center repeater-row">
            <div class="col-12 col-md-7"><input type="text" name="updates_feed[][title]" class="form-control" placeholder="Update title"></div>
            <div class="col-10 col-md-3"><input type="text" name="updates_feed[][date]" class="form-control" placeholder="Date"></div>
            <div class="col-2 text-end"><button type="button" class="btn btn-outline-danger" data-remove-row>&times;</button></div>
        </div>
    </template>

    <script>
        (function () {
            const form = document.getElementById('dashboard-editor-form');
            if (!form) {
                return;
            }

            const stateChip = document.getElementById('editor-state-chip');
            const saveButton = document.getElementById('dashboard-save-btn');

            const setDirtyState = (isDirty) => {
                if (!stateChip) {
                    return;
                }

                stateChip.textContent = isDirty ? '🟡 Unsaved changes' : '✅ All changes saved';
                stateChip.style.background = isDirty ? 'rgba(255, 193, 7, .15)' : 'rgba(120, 142, 255, .12)';
                stateChip.style.borderColor = isDirty ? 'rgba(255, 193, 7, .32)' : 'rgba(147, 170, 255, .32)';
            };

            const setText = (id, value, fallback = 'Not set yet') => {
                const el = document.getElementById(id);
                if (!el) {
                    return;
                }
                const trimmed = (value || '').toString().trim();
                el.textContent = trimmed || fallback;
            };

            const updateBadgesPreview = () => {
                const wrap = document.getElementById('preview-badges-wrap');
                if (!wrap) {
                    return;
                }

                const badges = Array.from(form.querySelectorAll('input[name="badges[]"]'))
                    .map((input) => input.value.trim())
                    .filter(Boolean)
                    .slice(0, 8);

                wrap.innerHTML = badges.length
                    ? badges.map((badge) => `<span class="badge text-bg-secondary">${badge.replace(/</g, '&lt;')}</span>`).join('')
                    : '<span class="text-muted-x small">No badges added yet.</span>';
            };

            const countRows = (selector, id) => {
                const total = Array.from(form.querySelectorAll(selector)).filter((input) => input.value.trim() !== '').length;
                const el = document.getElementById(id);
                if (el) {
                    el.textContent = String(total);
                }
            };

            const refreshPreviewCounts = () => {
                countRows('input[name="projects[][title]"]', 'preview-project-count');
                countRows('input[name="skills[][name]"]', 'preview-skill-count');
                countRows('input[name="socials[][platform]"]', 'preview-social-count');
                countRows('input[name="updates_feed[][title]"]', 'preview-update-count');
            };

            const bindInputMirror = (input) => {
                const targetId = input.getAttribute('data-preview-target');
                if (!targetId) {
                    return;
                }

                input.addEventListener('input', () => {
                    setText(targetId, input.value, targetId === 'preview-contact-email' ? 'Not set yet' : '');
                });
            };

            form.querySelectorAll('[data-preview-target]').forEach(bindInputMirror);

            document.addEventListener('click', function (e) {
                const addButton = e.target.closest('[data-add-row]');
                if (addButton) {
                    const targetId = addButton.getAttribute('data-add-row');
                    const container = document.getElementById(targetId);
                    const template = document.getElementById('tpl-' + targetId);
                    if (container && template) {
                        container.insertAdjacentHTML('beforeend', template.innerHTML.trim());
                    }

                    refreshPreviewCounts();
                    updateBadgesPreview();
                    return;
                }

                const removeButton = e.target.closest('[data-remove-row]');
                if (removeButton) {
                    const row = removeButton.closest('.repeater-row');
                    if (row) {
                        row.remove();
                    }

                    refreshPreviewCounts();
                    updateBadgesPreview();
                }
            });

            form.addEventListener('input', function (e) {
                const target = e.target;
                if (!(target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement)) {
                    return;
                }

                if (target.name === 'badges[]') {
                    updateBadgesPreview();
                }

                if (target.name === 'projects[][title]' || target.name === 'skills[][name]' || target.name === 'socials[][platform]' || target.name === 'updates_feed[][title]') {
                    refreshPreviewCounts();
                }

                setDirtyState(true);
            });

            form.addEventListener('submit', () => {
                if (saveButton) {
                    saveButton.disabled = true;
                    saveButton.textContent = 'Saving...';
                }
                setDirtyState(false);
            });

            updateBadgesPreview();
            refreshPreviewCounts();
            setText('preview-site-title', form.querySelector('input[name="site_title"]')?.value || '', 'Untitled Site');
            setText('preview-person-name', form.querySelector('input[name="person_name"]')?.value || '', 'Your Name');
            setText('preview-hero-title', form.querySelector('input[name="hero_title"]')?.value || '', 'Hero Title');
            setText('preview-hero-subtitle', form.querySelector('textarea[name="hero_subtitle"]')?.value || '', 'Hero subtitle will appear here');
            setText('preview-contact-email', form.querySelector('input[name="contact_email"]')?.value || '', 'Not set yet');
            setDirtyState(false);
        })();
    </script>
@endsection
