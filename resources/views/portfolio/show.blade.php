<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $portfolio->site_title }}</title>
    <meta name="description" content="Dynamic portfolio of {{ $portfolio->person_name }}." />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --bg: #070b14;
            --bg-soft: #0f1728;
            --card: linear-gradient(160deg, rgba(17, 25, 44, .9), rgba(10, 17, 33, .92));
            --text: #e8eefb;
            --muted: #9dadcd;
            --brand: #7b8dff;
            --brand-2: #4ee0c2;
            --line: rgba(166, 186, 255, .22);
            --radius: 20px;
            --shadow: 0 18px 45px rgba(3, 8, 20, .45);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--text);
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, system-ui, sans-serif;
            background:
                radial-gradient(1000px 600px at 100% -5%, rgba(123, 141, 255, .22), transparent 55%),
                radial-gradient(900px 640px at -10% 12%, rgba(78, 224, 194, .18), transparent 60%),
                linear-gradient(180deg, #070b14 0%, #070d18 100%);
        }

        .grain::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: radial-gradient(rgba(255, 255, 255, .03) 1px, transparent 1px);
            background-size: 3px 3px;
            opacity: .25;
            z-index: 0;
        }

        .app-wrap {
            position: relative;
            z-index: 1;
        }

        .section-pad {
            padding: 4.5rem 0;
        }

        .text-muted-x {
            color: var(--muted) !important;
        }

        .glass {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            backdrop-filter: blur(8px);
        }

        .section-title {
            font-size: clamp(1.4rem, 2vw, 2rem);
            font-weight: 700;
            margin: 0;
        }

        .section-kicker {
            letter-spacing: .08em;
            text-transform: uppercase;
            font-size: .74rem;
            color: #aebcf6;
            font-weight: 600;
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .navbar-blur {
            background: rgba(8, 13, 25, .74);
            border-bottom: 1px solid rgba(141, 164, 255, .2);
            backdrop-filter: blur(12px);
        }

        .navbar .nav-link {
            color: #dce4fb;
            opacity: .9;
            border-radius: 999px;
            padding: .5rem .95rem !important;
            transition: all .2s ease;
        }

        .navbar .nav-link:hover {
            background: rgba(123, 141, 255, .16);
            color: #fff;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            box-shadow: 0 0 0 6px rgba(123, 141, 255, .17);
        }

        .hero-shell {
            padding: clamp(1.2rem, 2.6vw, 2.2rem);
        }

        .hero-title {
            font-size: clamp(2rem, 4.5vw, 3.4rem);
            line-height: 1.06;
            font-weight: 800;
            margin: 0 0 .85rem;
        }

        .gradient-text {
            background: linear-gradient(92deg, #8ea0ff, #78f0d5);
            -webkit-background-clip: text;
            color: transparent;
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            border: none;
            color: #09132a;
            font-weight: 700;
            border-radius: 12px;
            padding-inline: 1rem;
        }

        .btn-ghost {
            border: 1px solid var(--line);
            color: #dbe4fb;
            border-radius: 12px;
        }

        .btn-ghost:hover {
            border-color: #8ca2ff;
            color: #fff;
            background: rgba(123, 141, 255, .12);
        }

        .hero-avatar {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--line);
            aspect-ratio: 4/4;
            background: #0a1120;
        }

        .stat-box {
            border-radius: 14px;
            border: 1px solid rgba(166, 186, 255, .18);
            background: rgba(10, 17, 34, .8);
            text-align: center;
            padding: .75rem;
        }

        .project-filter-chip,
        .chip {
            border: 1px solid rgba(141, 164, 255, .3);
            background: rgba(123, 141, 255, .12);
            color: #dbe6ff;
            border-radius: 999px;
            padding: .35rem .75rem;
            font-size: .78rem;
        }

        .project-filter-chip {
            cursor: pointer;
            transition: .2s ease;
        }

        .project-filter-chip:hover,
        .project-filter-chip.active {
            color: #071125;
            border-color: transparent;
            background: linear-gradient(140deg, var(--brand), var(--brand-2));
        }

        .project-hidden {
            display: none !important;
        }

        .card-hover,
        .skill-hover,
        .social-hover {
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .card-hover:hover,
        .skill-hover:hover,
        .social-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 45px rgba(4, 9, 20, .48);
            border-color: rgba(154, 178, 255, .4);
        }

        .project-media {
            aspect-ratio: 16/9;
            border-radius: 16px;
            border: 1px solid rgba(166, 186, 255, .25);
            background-size: cover;
            background-position: center;
            background-color: #091223;
        }

        .timeline {
            position: relative;
            padding-left: 1rem;
        }

        .timeline::before {
            content: "";
            position: absolute;
            left: .35rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(149, 172, 255, .24);
        }

        .timeline-item {
            position: relative;
            padding-left: 1.7rem;
            margin-bottom: 1rem;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -.02rem;
            top: .42rem;
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            box-shadow: 0 0 0 6px rgba(123, 141, 255, .15);
        }

        .bars {
            min-height: 230px;
            display: flex;
            align-items: end;
            gap: .55rem;
        }

        .bar {
            width: 100%;
            max-width: 56px;
            border-radius: 12px 12px 6px 6px;
            background: linear-gradient(180deg, #77eed2, #7386ff);
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .form-control,
        .form-control:focus {
            background: rgba(6, 12, 25, .8);
            color: #e6edfe;
            border-color: rgba(139, 160, 255, .3);
            box-shadow: none;
        }

        .popup {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(2, 6, 16, .78);
            z-index: 2000;
        }

        .popup-box {
            width: min(500px, calc(100vw - 2rem));
            padding: 1.5rem;
        }
    </style>
</head>

<body class="grain">
    <div class="app-wrap">
        <nav class="navbar navbar-expand-lg sticky-top navbar-blur py-2">
            <div class="container">
                <a class="navbar-brand text-light fw-semibold d-flex align-items-center gap-2" href="#home">
                    <span class="brand-mark"></span>
                    <span>{{ $portfolio->person_name }}.</span>
                </a>
                <button class="navbar-toggler border-0 text-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto gap-lg-2">
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
                        <li class="nav-item"><a class="nav-link" href="#skills">Skills</a></li>
                        <li class="nav-item"><a class="nav-link" href="#experience">Experience</a></li>
                        <li class="nav-item"><a class="nav-link" href="#showcase">Graphs</a></li>
                        <li class="nav-item"><a class="nav-link" href="#upcoming">Upcoming</a></li>
                        <li class="nav-item"><a class="nav-link" href="#updates">Updates</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                        @auth
                            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.preview') }}">Preview</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('access.request.form') }}">Request Access</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('access.key.form') }}">Use Access Key</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <header class="container section-pad" id="home">
            <div class="glass hero-shell reveal">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-lg-7">
                        <div class="section-kicker mb-2">Dynamic Portfolio</div>
                        <h1 class="hero-title">
                            {{ $portfolio->hero_title }}
                            <span class="gradient-text d-block">{{ $portfolio->person_name }}</span>
                        </h1>
                        <p class="lead text-muted-x mb-4">{{ $portfolio->hero_subtitle }}</p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <a href="#projects" class="btn btn-brand">See My Work</a>
                            <a href="#contact" class="btn btn-ghost">Let’s Talk</a>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (($portfolio->badges ?? []) as $badge)
                                <span class="chip">{{ $badge }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="hero-avatar mb-3">
                            <img src="{{ $portfolio->avatar_url }}" alt="{{ $portfolio->person_name }} portrait" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="row g-2">
                            @foreach (($portfolio->stats ?? []) as $stat)
                                <div class="col-4">
                                    <div class="stat-box">
                                        <div class="fw-bold fs-5">{{ $stat['value'] ?? '' }}</div>
                                        <small class="text-muted-x">{{ $stat['label'] ?? '' }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section id="about" class="section-pad pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <div class="section-kicker">Profile</div>
                        <h2 class="section-title">About</h2>
                    </div>
                    <p class="text-muted-x mb-0">Short intro & what drives you</p>
                </div>
                <div class="row g-3">
                    @foreach (($portfolio->about_cards ?? []) as $card)
                        <div class="col-12 col-md-6 col-xl-4">
                            <article class="glass p-3 h-100 card-hover reveal">
                                <h3 class="h5">{{ $card['title'] ?? '' }}</h3>
                                <p class="mb-2 text-muted-x">{{ $card['description'] ?? '' }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (($card['tags'] ?? []) as $tag)
                                        <span class="chip">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="projects" class="section-pad pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <div class="section-kicker">Builds</div>
                        <h2 class="section-title">Projects</h2>
                    </div>
                    <p class="text-muted-x mb-0">Managed dynamically from dashboard</p>
                </div>

                @php
                    $projectTags = collect($portfolio->projects ?? [])
                        ->flatMap(fn ($project) => $project['tags'] ?? [])
                        ->map(fn ($tag) => trim((string) $tag))
                        ->filter()
                        ->unique()
                        ->values();
                @endphp

                @if ($projectTags->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2 mb-3 reveal">
                        <button type="button" class="project-filter-chip active" data-project-filter="all">All</button>
                        @foreach ($projectTags as $tag)
                            <button type="button" class="project-filter-chip" data-project-filter="{{ strtolower($tag) }}">{{ $tag }}</button>
                        @endforeach
                    </div>
                @endif

                <div class="row g-3" id="project-grid">
                    @foreach (($portfolio->projects ?? []) as $project)
                        @php
                            $liveUrl = $project['live_url'] ?? null;
                            $codeUrl = $project['code_url'] ?? null;
                            $isComingSoon = empty($liveUrl) || empty($codeUrl);
                            $tagString = collect($project['tags'] ?? [])->map(fn ($tag) => strtolower((string) $tag))->implode(',');
                        @endphp
                        <div class="col-12 col-md-6 col-xl-4">
                            <article class="glass p-3 h-100 card-hover reveal project-card" data-project-tags="{{ $tagString }}">
                                <div class="project-media mb-3" style="background-image:url('{{ $project['image_url'] ?? '' }}')"></div>
                                <h3 class="h5 mb-2">{{ $project['title'] ?? '' }}</h3>
                                <p class="text-muted-x mb-2">{{ $project['description'] ?? '' }}</p>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach (($project['tags'] ?? []) as $tag)
                                        <span class="chip">{{ $tag }}</span>
                                    @endforeach
                                </div>
                                <div class="d-flex gap-2">
                                    @if ($isComingSoon)
                                        <button type="button" class="btn btn-sm btn-brand" onclick="showPopup()">Live</button>
                                        <button type="button" class="btn btn-sm btn-ghost" onclick="showPopup()">Code</button>
                                    @else
                                        <a class="btn btn-sm btn-brand" href="{{ $liveUrl }}" target="_blank" rel="noreferrer">Live</a>
                                        <a class="btn btn-sm btn-ghost" href="{{ $codeUrl }}" target="_blank" rel="noreferrer">Code</a>
                                    @endif
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="skills" class="section-pad pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <div class="section-kicker">Tooling</div>
                        <h2 class="section-title">Skills</h2>
                    </div>
                    <p class="text-muted-x mb-0">Comfortable across the stack</p>
                </div>
                <div class="row g-3">
                    @foreach (($portfolio->skills ?? []) as $skill)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                            <div class="glass p-3 h-100 skill-hover reveal">
                                <div class="d-flex align-items-center gap-2">
                                    @if (! empty($skill['icon']))
                                        <img src="{{ $skill['icon'] }}" alt="{{ $skill['name'] ?? 'skill icon' }}" style="width:22px;height:22px;object-fit:contain;">
                                    @endif
                                    <strong>{{ $skill['name'] ?? '' }}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="experience" class="section-pad pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <div class="section-kicker">Journey</div>
                        <h2 class="section-title">Experience</h2>
                    </div>
                    <p class="text-muted-x mb-0">Timeline of roles & milestones</p>
                </div>
                <div class="glass p-3 reveal">
                    <div class="timeline">
                        @foreach (($portfolio->experiences ?? []) as $experience)
                            <div class="timeline-item">
                                <h3 class="h5 mb-1">{{ $experience['title'] ?? '' }}</h3>
                                <small class="text-muted-x">{{ $experience['period'] ?? '' }}</small>
                                <p class="mb-0 mt-1 text-muted-x">{{ $experience['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="showcase" class="section-pad pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <div class="section-kicker">Signals</div>
                        <h2 class="section-title">Graph Showcase</h2>
                    </div>
                    <p class="text-muted-x mb-0">Live metrics from dashboard</p>
                </div>
                <div class="glass p-3 reveal">
                    @php
                        $graphPoints = $portfolio->graph_points;
                        if (! is_array($graphPoints) || count($graphPoints) === 0) {
                            $graphPoints = [12, 18, 15, 26, 31, 28, 34];
                        }
                        $maxPoint = max($graphPoints ?: [1]);
                    @endphp
                    <div class="bars">
                        @forelse ($graphPoints as $point)
                            @php
                                $height = max(8, (int) (($point / $maxPoint) * 100));
                            @endphp
                            <div class="bar" style="height: {{ $height }}%" title="{{ $point }}"></div>
                        @empty
                            <p class="text-muted-x">No graph data yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section id="upcoming" class="section-pad pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <div class="section-kicker">Roadmap</div>
                        <h2 class="section-title">Upcoming Projects</h2>
                    </div>
                    <p class="text-muted-x mb-0">What’s coming next</p>
                </div>
                <div class="row g-3">
                    @forelse (($portfolio->upcoming_projects ?? []) as $upcoming)
                        <div class="col-12 col-md-6">
                            <article class="glass p-3 h-100 reveal">
                                <h3 class="h5 mb-1">{{ $upcoming['title'] ?? '' }}</h3>
                                <p class="text-muted-x mb-2">ETA: {{ $upcoming['eta'] ?? '' }}</p>
                                <p class="mb-0 text-muted-x">{{ $upcoming['details'] ?? '' }}</p>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <article class="glass p-3 reveal">
                                <h3 class="h5">No upcoming projects yet</h3>
                                <p class="mb-0 text-muted-x">Add upcoming items from your dashboard editor.</p>
                            </article>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="updates" class="section-pad pt-0">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <div class="section-kicker">Pulse</div>
                        <h2 class="section-title">Latest Updates</h2>
                    </div>
                    <p class="text-muted-x mb-0">Recent important changes</p>
                </div>
                <div class="row g-3">
                    @forelse (($portfolio->updates_feed ?? []) as $update)
                        <div class="col-12 col-md-6">
                            <article class="glass p-3 h-100 reveal">
                                <strong>{{ $update['title'] ?? '' }}</strong>
                                <div class="text-muted-x">{{ $update['date'] ?? '' }}</div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <article class="glass p-3 reveal">
                                <strong>No updates yet</strong>
                                <div class="text-muted-x">Updates will appear here after dashboard changes.</div>
                            </article>
                        </div>
                    @endforelse
                </div>
                @auth
                    @if (auth()->user()->isAdmin() && filled($portfolio->admin_notes))
                        <div class="alert alert-warning mt-3 mb-0 reveal">
                            <strong>Admin-only important notes:</strong> {{ $portfolio->admin_notes }}
                        </div>
                    @endif
                @endauth
            </div>
        </section>

        <section id="contact" class="section-pad pt-0">
            <div class="container">
                <div class="row g-3">
                    <div class="col-12 col-lg-6 reveal">
                        <div class="glass p-4 h-100">
                            <div class="section-kicker mb-1">Let’s connect</div>
                            <h2 class="section-title mb-2">Let’s build something great</h2>
                            <p class="text-muted-x">Drop a message — I’ll reply within 24 hours.</p>
                            @if (! empty($portfolio->contact_email))
                                <a href="mailto:{{ $portfolio->contact_email }}" class="link-info">Email me → {{ $portfolio->contact_email }}</a>
                            @endif

                            @if (session('contact_success'))
                                <div class="alert alert-success mt-3 mb-0">{{ session('contact_success') }}</div>
                            @endif

                            @if ($errors->has('contact'))
                                <div class="alert alert-danger mt-3 mb-0">
                                    {{ $errors->first('contact') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger mt-3 mb-0">
                                    Please fix the contact form errors and try again.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="glass p-4 reveal mb-3">
                            <form action="{{ route('contact.store') }}" method="POST" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label for="contact-name" class="form-label">Name</label>
                                    <input type="text" id="contact-name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact-email" class="form-label">Email</label>
                                    <input type="email" id="contact-email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact-message" class="form-label">Message</label>
                                    <textarea id="contact-message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-brand">Send Message</button>
                            </form>
                        </div>

                        <div class="row g-2">
                            @foreach (($portfolio->socials ?? []) as $social)
                                <div class="col-12 reveal">
                                    <a class="glass p-3 d-flex justify-content-between align-items-center social-hover text-decoration-none"
                                        href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noreferrer">
                                        <span>{{ $social['platform'] ?? '' }}</span>
                                        <span class="text-muted-x">{{ $social['handle'] ?? '' }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-4 text-center text-muted-x">
            <div class="container">© <span id="year"></span> {{ $portfolio->person_name }}</div>
        </footer>
    </div>

    <div id="popup" class="popup">
        <div class="popup-box glass text-center">
            <p class="mb-3">{{ $portfolio->popup_message ?: '🚧 This project is under development.' }}</p>
            <button class="btn btn-brand" onclick="closePopup()">Close</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function showPopup() {
            document.getElementById('popup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.16 });

        document.querySelectorAll('[data-project-filter]').forEach((button) => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-project-filter');

                document.querySelectorAll('[data-project-filter]').forEach((btn) => btn.classList.remove('active'));
                button.classList.add('active');

                document.querySelectorAll('.project-card').forEach((card) => {
                    const tags = (card.getAttribute('data-project-tags') || '').split(',').map((t) => t.trim()).filter(Boolean);
                    const shouldShow = filter === 'all' || tags.includes(filter);
                    card.classList.toggle('project-hidden', !shouldShow);
                });
            });
        });

        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>

</html>
