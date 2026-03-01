<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DashX • Bootstrap Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #070c1d;
            --panel: #101b36;
            --panel-2: #111f3c;
            --line: #233a63;
            --text: #e7eeff;
            --muted: #9aacd8;
            --accent: #7c6cff;
            --ok: #35d38b;
            --danger: #f16f82;
        }

        body {
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 10% -10%, #21356a 0, transparent 28%),
                radial-gradient(circle at 90% 110%, #361765 0, transparent 36%),
                var(--bg);
        }

        .app-shell {
            min-height: 100vh;
            padding: 1rem;
        }

        .sidebar-wrap,
        .panel,
        .card-dark {
            border: 1px solid var(--line);
            border-radius: 1rem;
            background: linear-gradient(165deg, var(--panel) 0%, #0b1430 100%);
        }

        .sidebar-wrap {
            min-height: calc(100vh - 2rem);
        }

        .brand {
            font-size: 1.9rem;
            font-weight: 700;
            letter-spacing: .03em;
        }

        .brand span {
            color: #8ea9ff;
        }

        .nav-pills .nav-link {
            color: #b9c8ee;
            border: 1px solid transparent;
            border-radius: .7rem;
            padding: .62rem .8rem;
            display: flex;
            align-items: center;
            gap: .55rem;
        }

        .nav-pills .nav-link:hover,
        .nav-pills .nav-link.active {
            color: #fff;
            border-color: #2d4675;
            background: #17284c;
        }

        .topbar {
            border: 1px solid var(--line);
            border-radius: .9rem;
            background: linear-gradient(160deg, var(--panel) 0%, #0b1530 100%);
        }

        .search-dark {
            background: #0b1632;
            border: 1px solid #294371;
            color: #cfdbff;
        }

        .search-dark::placeholder {
            color: #90a5d4;
        }

        .search-dark:focus {
            background: #0b1632;
            border-color: #4d6aff;
            color: #e4ecff;
            box-shadow: 0 0 0 .2rem rgba(124, 108, 255, .2);
        }

        .profile-pill {
            border: 1px solid #294371;
            background: #122447;
            border-radius: 999px;
        }

        .avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: linear-gradient(145deg, #8ca8ff, #7e5dff);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
        }

        .muted {
            color: var(--muted) !important;
        }

        .card-dark {
            min-height: 130px;
            position: relative;
        }

        .trend {
            font-size: .85rem;
            font-weight: 600;
            position: absolute;
            top: .85rem;
            right: .9rem;
        }

        .trend.up {
            color: var(--ok);
        }

        .trend.down {
            color: var(--danger);
        }

        .spark {
            height: 2rem;
            border: 1px solid #253d69;
            border-radius: .6rem;
            margin-top: .7rem;
            background:
                radial-gradient(70px 32px at 18% 100%, #6f7cff60 0 45%, transparent 46%),
                radial-gradient(70px 32px at 58% 40%, #8f5dff60 0 45%, transparent 46%),
                radial-gradient(80px 40px at 92% 100%, #6f7cff85 0 45%, transparent 46%),
                #121f3a;
        }

        .panel {
            padding: .95rem;
        }

        .chart-box,
        .bars-box {
            border: 1px solid #263f6b;
            border-radius: .8rem;
            background: linear-gradient(145deg, #111e3a, #0b1630);
        }

        .chart-box {
            height: 245px;
            position: relative;
            overflow: hidden;
            background-image:
                linear-gradient(to top, #8f5dff44 6%, transparent 65%),
                repeating-linear-gradient(to top, transparent 0 35px, #173057 35px 36px),
                linear-gradient(145deg, #111e3a, #0b1630);
        }

        .chart-box::after {
            content: "";
            position: absolute;
            inset: 1.5rem .9rem 2.2rem;
            border-radius: .8rem;
            border: 2px solid transparent;
            border-left-color: #8d72ff;
            border-bottom-color: #9d89ff;
            transform: skewY(-9deg);
            opacity: .72;
        }

        .bars-box {
            height: 186px;
        }

        .bar {
            width: 100%;
            border-radius: .65rem .65rem .25rem .25rem;
            background: linear-gradient(to top, #5f71ff, #9d7dff);
            box-shadow: 0 0 18px rgba(143, 93, 255, .35);
        }

        .donut {
            width: 146px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: conic-gradient(#7f68ff 0 46%, #9461ff 46% 70%, #708dff 70% 85%, #5168d8 85% 100%);
            position: relative;
        }

        .donut::after {
            content: "";
            position: absolute;
            inset: 27px;
            border-radius: 50%;
            border: 1px solid #2a426f;
            background: #101d3a;
        }

        .table-darkx {
            --bs-table-bg: #111f3c;
            --bs-table-striped-bg: #122347;
            --bs-table-hover-bg: #132a52;
            --bs-table-color: #e4ecff;
            --bs-table-border-color: #27416e;
            border-radius: .8rem;
            overflow: hidden;
        }

        .badge-soft-success {
            color: #89f0c0;
            background: #1e533f;
        }

        .badge-soft-warning {
            color: #ffd483;
            background: #5a4517;
        }

        .badge-soft-danger {
            color: #ffa7b4;
            background: #5b2532;
        }
    </style>
</head>
<body>
    <div class="app-shell container-fluid">
        <div class="row g-3 g-xl-4">
            <aside class="col-12 col-xl-2">
                <div class="sidebar-wrap p-3 p-md-4 d-flex flex-column gap-3">
                    <div class="brand"><span>D</span>ashX</div>

                    <ul class="nav nav-pills flex-column gap-1 small">
                        <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-house"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><i class="bi bi-people"></i>Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-bar-chart"></i>Analytics</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-cash-coin"></i>Revenue</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-activity"></i>Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-gear"></i>Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i>Logout</a></li>
                    </ul>
                </div>
            </aside>

            <main class="col-12 col-xl-10">
                <div class="d-grid gap-3 gap-xl-4">
                    <section class="topbar p-2 p-md-3">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                            <div class="flex-grow-1" style="max-width: 520px;">
                                <input type="search" class="form-control search-dark" placeholder="Search...">
                            </div>

                            <div class="profile-pill py-1 px-2 d-inline-flex align-items-center gap-2">
                                <i class="bi bi-bell text-light-emphasis"></i>
                                <span class="avatar">J</span>
                                <strong class="small text-light">Jin Profile</strong>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h1 class="display-6 fw-semibold mb-0">Welcome back, Jin Profile</h1>
                        <p class="muted mb-0" id="dateLine">Current date ...</p>
                    </section>

                    <section class="row row-cols-1 row-cols-md-2 row-cols-xxl-4 g-3">
                        <div class="col">
                            <article class="card-dark p-3 h-100">
                                <span class="trend up">↑ 30%</span>
                                <h3 class="display-6 fw-bold mb-0">360</h3>
                                <div class="muted small">Total Users</div>
                                <div class="spark"></div>
                            </article>
                        </div>
                        <div class="col">
                            <article class="card-dark p-3 h-100">
                                <span class="trend up">↑ 30%</span>
                                <h3 class="display-6 fw-bold mb-0">$1.6M</h3>
                                <div class="muted small">Monthly Revenue</div>
                                <div class="spark"></div>
                            </article>
                        </div>
                        <div class="col">
                            <article class="card-dark p-3 h-100">
                                <span class="trend up">↑ 53%</span>
                                <h3 class="display-6 fw-bold mb-0">493</h3>
                                <div class="muted small">Active Sessions</div>
                                <div class="spark"></div>
                            </article>
                        </div>
                        <div class="col">
                            <article class="card-dark p-3 h-100">
                                <span class="trend down">↓ 30%</span>
                                <h3 class="display-6 fw-bold mb-0">37.3%</h3>
                                <div class="muted small">Growth %</div>
                                <div class="spark"></div>
                            </article>
                        </div>
                    </section>

                    <section class="row g-3">
                        <div class="col-12 col-xxl-8">
                            <div class="panel h-100">
                                <h2 class="h5 fw-semibold mb-2">Monthly Revenue</h2>
                                <div class="chart-box"></div>
                                <div class="d-flex justify-content-between muted small mt-2 px-1">
                                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span>
                                </div>

                                <h3 class="h5 fw-semibold mt-4 mb-2">Recent Activity</h3>
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-hover align-middle mb-0 table-darkx">
                                        <thead>
                                            <tr>
                                                <th scope="col">User</th>
                                                <th scope="col">Action</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Admin Oren</td>
                                                <td>Created Report #123</td>
                                                <td>2023-07-28 10:00 AM</td>
                                            </tr>
                                            <tr>
                                                <td>Bath Ivorsons</td>
                                                <td>Invited new user</td>
                                                <td>2023-07-28 10:00 AM</td>
                                            </tr>
                                            <tr>
                                                <td>Onina Brain</td>
                                                <td>Updated project status</td>
                                                <td>2023-07-28 10:00 AM</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xxl-4">
                            <div class="d-grid gap-3 h-100">
                                <div class="panel">
                                    <h2 class="h5 fw-semibold mb-2">User Activity</h2>

                                    <div class="bars-box p-3 d-flex align-items-end gap-2">
                                        <div class="bar" style="height:38%"></div>
                                        <div class="bar" style="height:60%"></div>
                                        <div class="bar" style="height:88%"></div>
                                        <div class="bar" style="height:70%"></div>
                                        <div class="bar" style="height:64%"></div>
                                        <div class="bar" style="height:40%"></div>
                                        <div class="bar" style="height:84%"></div>
                                        <div class="bar" style="height:72%"></div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <h2 class="h5 fw-semibold mb-3">Traffic Source</h2>

                                    <div class="row g-3 align-items-center">
                                        <div class="col-12 col-sm-5 text-center">
                                            <div class="donut mx-auto"></div>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            <ul class="list-unstyled small mb-3 muted">
                                                <li class="mb-1"><i class="bi bi-circle-fill me-2" style="color:#7f68ff"></i>Direct</li>
                                                <li class="mb-1"><i class="bi bi-circle-fill me-2" style="color:#9461ff"></i>Search</li>
                                                <li><i class="bi bi-circle-fill me-2" style="color:#708dff"></i>Social</li>
                                            </ul>

                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge rounded-pill badge-soft-success">Success</span>
                                                <span class="badge rounded-pill badge-soft-warning">Pending</span>
                                                <span class="badge rounded-pill badge-soft-danger">Failed</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const now = new Date();
        const formatter = new Intl.DateTimeFormat("en-US", { year: "numeric", month: "long", day: "numeric" });
        document.getElementById("dateLine").textContent = `Current date ${formatter.format(now)}`;
    </script>
</body>
</html>