<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $portfolio->site_title }}</title>
    <meta name="description" content="Dynamic portfolio of {{ $portfolio->person_name }}." />
    <meta name="color-scheme" content="dark light">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --bg: #0b0f14;
            --bg-soft: #10161f;
            --card: #0f141b;
            --text: #e6ebf2;
            --muted: #a9b2c3;
            --brand: #7c9cff;
            --brand-2: #9bffd1;
            --outline: 1px solid rgba(255, 255, 255, .08);
            --shadow: 0 10px 30px rgba(0, 0, 0, .35);
            --radius: 20px;
        }

        body {
            margin: 0;
            color: var(--text);
            background: radial-gradient(1200px 800px at 80% -10%, rgba(124, 156, 255, .15), transparent 60%), radial-gradient(900px 700px at -10% 20%, rgba(2, 195, 154, .12), transparent 60%), var(--bg);
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "Segoe UI", Roboto, system-ui, sans-serif;
        }

        .section-pad {
            padding: 4rem 0;
        }

        .text-muted-x {
            color: var(--muted) !important;
        }

        .glass {
            background: var(--card);
            border: var(--outline);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .navbar-blur {
            background: color-mix(in hsl, var(--bg) 80%, transparent);
            backdrop-filter: saturate(180%) blur(12px);
            border-bottom: var(--outline);
        }

        .nav-link {
            color: var(--text);
            opacity: .92;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #fff;
            background: rgba(124, 156, 255, .12);
            border-radius: 999px;
        }

        .brand-dot {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            box-shadow: 0 0 0 6px rgba(124, 156, 255, .15);
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            border: none;
            color: #0b1120;
            font-weight: 700;
        }

        .btn-ghost {
            border: var(--outline);
            color: var(--text);
            background: transparent;
        }

        .btn-ghost:hover {
            color: #fff;
            background: rgba(124, 156, 255, .1);
        }

        .hero-avatar {
            border-radius: 18px;
            overflow: hidden;
            border: var(--outline);
            aspect-ratio: 1/1;
        }

        .stat-box {
            background: var(--bg-soft);
            border: var(--outline);
            border-radius: 14px;
            text-align: center;
            padding: .8rem;
        }

        .card-hover,
        .skill-hover,
        .social-hover {
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .card-hover:hover,
        .skill-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .45);
        }

        .project-media {
            aspect-ratio: 16 / 10;
            background-size: cover;
            background-position: center;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom: var(--outline);
        }

        .chip {
            font-size: .75rem;
            padding: .25rem .55rem;
            border-radius: 999px;
            background: rgba(124, 156, 255, 0.12);
            border: 1px solid rgba(124, 156, 255, 0.25);
            display: inline-block;
            margin-right: .25rem;
            margin-bottom: .25rem;
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
            background: rgba(255, 255, 255, .12);
        }

        .timeline-item {
            position: relative;
            padding-left: 1.6rem;
            margin-bottom: 1rem;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -.03rem;
            top: .45rem;
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            box-shadow: 0 0 0 6px rgba(124, 156, 255, .12);
        }

        .bars {
            min-height: 210px;
            display: flex;
            align-items: end;
            gap: .5rem;
        }

        .bar {
            width: 100%;
            max-width: 60px;
            border-radius: 10px 10px 4px 4px;
            background: linear-gradient(180deg, var(--brand-2), var(--brand));
        }

        .popup {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, .65);
            z-index: 2000;
        }

        .popup-box {
            max-width: 460px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-blur py-2">
        <div class="container">
            <a class="navbar-brand text-light fw-bold d-flex align-items-center gap-2" href="#home">
                <span class="brand-dot"></span>
                <span>{{ $portfolio->person_name }}.</span>
            </a>
            <button class="navbar-toggler border-0 text-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto gap-lg-2">
                    <li class="nav-item"><a class="nav-link px-3" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#skills">Skills</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#experience">Experience</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#showcase">Graphs</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#upcoming">Upcoming</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#updates">Updates</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#contact">Contact</a></li>

                    @auth
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('dashboard.preview') }}">Preview</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('access.request.form') }}">Request Access</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('access.key.form') }}">Use Access Key</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <header class="container section-pad" id="home">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-7">
                <h1 class="display-5 fw-bold mb-2 reveal">
                    Hi, I’m
                    <span style="background: linear-gradient(90deg, var(--brand), var(--brand-2)); -webkit-background-clip:text; color:transparent;">
                        {{ $portfolio->person_name }}
                    </span>
                    — {{ $portfolio->hero_title }}
                </h1>
                <p class="lead text-muted-x reveal">{{ $portfolio->hero_subtitle }}</p>
                <div class="d-flex flex-wrap gap-2 reveal">
                    <a href="#projects" class="btn btn-brand">View Projects</a>
                    <a href="#contact" class="btn btn-ghost">Contact Me</a>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-3 reveal">
                    @foreach (($portfolio->badges ?? []) as $badge)
                        <span class="badge rounded-pill text-bg-secondary">{{ $badge }}</span>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-5 d-none d-lg-block">
                <div class="glass p-3 reveal">
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

    <section id="about" class="section-pad">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="h2 mb-0">About</h2>
                <p class="text-muted-x mb-0">Short intro & what drives you</p>
            </div>

            <div class="row g-3">
                @foreach (($portfolio->about_cards ?? []) as $card)
                    <div class="col-12 col-md-6 col-xl-4">
                        <article class="glass p-3 h-100 card-hover reveal">
                            <h3 class="h5">{{ $card['title'] ?? '' }}</h3>
                            <p class="mb-2">{{ $card['description'] ?? '' }}</p>
                            <div>
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

    <section id="projects" class="section-pad">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="h2 mb-0">Projects</h2>
                <p class="text-muted-x mb-0">Dynamic list from dashboard</p>
            </div>

            <div class="row g-3">
                @foreach (($portfolio->projects ?? []) as $project)
                    @php
                        $liveUrl = $project['live_url'] ?? null;
                        $codeUrl = $project['code_url'] ?? null;
                        $isComingSoon = empty($liveUrl) || empty($codeUrl);
                    @endphp
                    <div class="col-12 col-md-6 col-xl-4">
                        <article class="glass h-100 overflow-hidden card-hover reveal">
                            <div class="project-media" style="background-image:url('{{ $project['image_url'] ?? '' }}')"></div>
                            <div class="p-3">
                                <h3 class="h5">{{ $project['title'] ?? '' }}</h3>
                                <p>{{ $project['description'] ?? '' }}</p>
                                <div class="mb-2">
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
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="skills" class="section-pad">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="h2 mb-0">Skills</h2>
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

    <section id="experience" class="section-pad">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="h2 mb-0">Experience</h2>
                <p class="text-muted-x mb-0">Timeline of roles & milestones</p>
            </div>

            <div class="timeline reveal">
                @foreach (($portfolio->experiences ?? []) as $experience)
                    <div class="timeline-item">
                        <h3 class="h5 mb-1">{{ $experience['title'] ?? '' }}</h3>
                        <small class="text-muted-x">{{ $experience['period'] ?? '' }}</small>
                        <p class="mb-0 mt-1">{{ $experience['description'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="showcase" class="section-pad">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="h2 mb-0">Graph Showcase</h2>
                <p class="text-muted-x mb-0">Live metrics from your dynamic dashboard</p>
            </div>

            <div class="glass p-3 reveal">
                @php
                    $graphPoints = $portfolio->graph_points ?? [];
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

    <section id="upcoming" class="section-pad">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="h2 mb-0">Upcoming Projects</h2>
                <p class="text-muted-x mb-0">What’s coming next</p>
            </div>

            <div class="row g-3">
                @forelse (($portfolio->upcoming_projects ?? []) as $upcoming)
                    <div class="col-12 col-md-6">
                        <article class="glass p-3 h-100 reveal">
                            <h3 class="h5 mb-1">{{ $upcoming['title'] ?? '' }}</h3>
                            <p class="text-muted-x mb-2">ETA: {{ $upcoming['eta'] ?? '' }}</p>
                            <p class="mb-0">{{ $upcoming['details'] ?? '' }}</p>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <article class="glass p-3 reveal">
                            <h3 class="h5">No upcoming projects yet</h3>
                            <p class="mb-0">Add upcoming items from your dashboard editor.</p>
                        </article>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="updates" class="section-pad">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="h2 mb-0">Latest Updates</h2>
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

    <section id="contact" class="section-pad">
        <div class="container">
            <div class="row g-3">
                <div class="col-12 col-lg-6 reveal">
                    <div class="glass p-3 h-100">
                        <h2 class="h3">Let’s build something great</h2>
                        <p class="text-muted-x">Drop a message — I’ll reply within 24 hours.</p>
                        @if (! empty($portfolio->contact_email))
                            <a href="mailto:{{ $portfolio->contact_email }}" class="link-info">Email me → {{ $portfolio->contact_email }}</a>
                        @endif

                        @if (session('contact_success'))
                            <div class="alert alert-success mt-3 mb-0">{{ session('contact_success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mt-3 mb-0">
                                Please fix the contact form errors and try again.
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="glass p-3 reveal mb-3">
                        <form action="{{ route('contact.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="contact-name" class="form-label">Name</label>
                                <input
                                    type="text"
                                    id="contact-name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact-email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    id="contact-email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact-message" class="form-label">Message</label>
                                <textarea
                                    id="contact-message"
                                    name="message"
                                    rows="5"
                                    class="form-control @error('message') is-invalid @enderror"
                                    required
                                >{{ old('message') }}</textarea>
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

    <div id="popup" class="popup">
        <div class="popup-box glass p-4 text-center">
            <p class="mb-2">{{ $portfolio->popup_message ?: '🚧 This project is under development.' }}</p>
            <button class="btn btn-brand" onclick="closePopup()">Close</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function showPopup() {
            document.getElementById("popup").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                }
            });
        }, { threshold: .15 });

        document.querySelectorAll(".reveal").forEach(el => observer.observe(el));
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>

</html>
