@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Page background & fonts */
    body {
        background: linear-gradient(180deg,#f5f8ff 0%, #eef4ff 100%);
        font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    .container-fluid { padding-top: 28px; padding-bottom: 40px; }

    /* Title */
    .dash-title {
        font-size: 34px;
        font-weight: 800;
        color: #0f1b33;
        margin-bottom: 22px;
        letter-spacing: -0.3px;
    }

    /* Glass card */
    .glass {
        position: relative;
        border-radius: 18px;
        padding: 22px;
        background: rgba(255,255,255,0.65);
        box-shadow: 0 12px 30px rgba(14,30,60,0.08);
        border: 1px solid rgba(255,255,255,0.6);
        backdrop-filter: blur(8px) saturate(120%);
        transition: transform .25s ease, box-shadow .25s ease;
        overflow: hidden;
    }
    .glass:hover { transform: translateY(-6px); box-shadow: 0 22px 50px rgba(14,30,60,0.12); }

    /* subtle animated gradient overlay */
    .glass::after {
        content: "";
        position: absolute;
        inset: -40%;
        background: conic-gradient(from 180deg,#6f9cff, #50e3c2, #f9d976, #6f9cff);
        opacity: 0.08;
        transform: rotate(0deg);
        animation: spinBg 14s linear infinite;
        pointer-events: none;
    }
    @keyframes spinBg { to { transform: rotate(360deg); } }

    /* stats card specifics */
    .stat-label { color: #58657b; font-weight: 600; font-size: 14px; }
    .stat-value { font-size: 40px; font-weight: 900; color: #0d2240; margin-top: 6px; }
    .stat-small { font-size: 13px; color: #7b8798; margin-top: 6px; }

    .icon-circle {
        width: 64px; height: 64px; border-radius: 14px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 24px; color: white; box-shadow: 0 8px 20px rgba(11,23,50,0.08);
        margin-left: auto;
        opacity: 0.95;
    }
    .ic-blue { background: linear-gradient(135deg,#4a6bff,#7b5bff); }
    .ic-green { background: linear-gradient(135deg,#15d58b,#00c6a7); }
    .ic-gold  { background: linear-gradient(135deg,#ffd36b,#ff9b3b); }

    /* list card */
    .list-title { font-size: 18px; font-weight: 700; color: #11233d; margin-bottom: 12px; }
    .list-item { padding: 12px 0; border-bottom: 1px dashed rgba(15,30,60,0.06); }
    .list-item:last-child { border-bottom: none; }

    /* charts */
    .chart-title { font-size: 16px; font-weight: 700; color: #0f1b33; margin-bottom: 10px; }

    /* responsive adjustments */
    @media (max-width: 991px) {
        .stat-value { font-size: 32px; }
    }
</style>

<div class="container-fluid">
    <h1 class="dash-title"><strong>{{ ucfirst($user->role) }}</strong> Dashboard</h1>

    @if ($user->role === "employee")
<div class="col-md-4">
    <div class="glass d-flex flex-column h-100">
        <div class="d-flex align-items-start">
            <div>
                <div class="stat-label">Applied Jobs</div>
                <div class="stat-value counter" data-target="{{ $data['appliedJobs'] ?? 0 }}">0</div>
                <div class="stat-small">Jobs you have applied for</div>
            </div>

            <div class="ms-auto">
                <div class="icon-circle ic-blue">
                    <i class="fa fa-paper-plane"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

    <!-- TOP STATS ROW -->
    <div class="row g-4">
        @if ($user->role === "admin")
        <div class="col-md-4">
            <div class="glass d-flex flex-column h-100">
                <div class="d-flex align-items-start">
                    <div>
                        <div class="stat-label">Employers</div>
                        <div class="stat-value counter" data-target="{{ $data['employers'] ?? 0 }}">0</div>
                        <div class="stat-small">Total registered employers</div>
                    </div>

                    <div class="ms-auto">
                        <div class="icon-circle ic-blue">
                            <i class="fa fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-md-4">
            <div class="glass d-flex flex-column h-100">
                <div class="d-flex align-items-start">
                    <div>
                        <div class="stat-label">Employees</div>
                        <div class="stat-value counter" data-target="{{ $data['employees'] ?? 0 }}">0</div>
                        <div class="stat-small">Job seekers registered</div>
                    </div>

                    <div class="ms-auto">
                        <div class="icon-circle ic-green">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
        @if ($user->role !== "employee")
        
        
        <div class="col-md-4">
            <div class="glass d-flex flex-column h-100">
                <div class="d-flex align-items-start">
                    <div>
                        <div class="stat-label">Jobs Posted</div>
                        <div class="stat-value counter" data-target="{{ $data['jobs'] ?? 0 }}">0</div>
                        <div class="stat-small">Active job listings</div>
                    </div>

                    <div class="ms-auto">
                        <div class="icon-circle ic-gold">
                            <i class="fa fa-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div> <!-- /row -->

    <!-- MAIN ROW: charts + lists -->
     @if ($user->role === "admin")
     
     
    <div class="row g-4 mt-3">

        <!-- Left: Charts -->
        <div class="col-lg-8">
            <div class="glass">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <div class="chart-title">Platform Overview</div>
                        <div class="small text-muted">Real-time snapshot of your platform (DB driven)</div>
                    </div>
                    <div class="text-muted small">Updated: {{ now()->format('M d, Y H:i') }}</div>
                </div>

                <!-- Charts -->
                <div class="row g-3">
                    <div class="col-12 mb-3">
                        <canvas id="overviewBar" height="120"></canvas>
                    </div>

                    @if(!empty($data['jobStats']) && count($data['jobStats'])>0)
                        <div class="col-12">
                            <div class="chart-title">Jobs posted (last 7 days)</div>
                            <canvas id="jobStatsLine" height="90"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Latest lists -->
        <div class="col-lg-4">
            <div class="glass mb-3">
                <div class="list-title">Latest Job Posts</div>
                @forelse($data['latestJobs'] ?? [] as $job)
                    <div class="list-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $job->title }}</strong><br>
                                <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">{{ Str::limit($job->location ?? '-', 18) }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-item">No recent jobs.</div>
                @endforelse
            </div>

            <div class="glass">
                <div class="list-title">Recent Employers</div>
                @forelse($data['latestEmployers'] ?? [] as $emp)
                    <div class="list-item">
                        <strong>{{ $emp->company_name ?? ($emp->user->name ?? 'Employer') }}</strong><br>
                        <small class="text-muted">{{ $emp->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="list-item">No recent employers.</div>
                @endforelse
            </div>
        </div>
    </div>
    
     <!-- /main row -->

    <!-- FOOTER ROW: latest employees & job distribution -->
    <div class="row g-4 mt-3">

        <div class="col-lg-6">
            <div class="glass">
                <div class="list-title">Latest Employees</div>
                @forelse($data['latestEmployees'] ?? [] as $emp)
                    <div class="list-item">
                        <strong>{{ $emp->name ?? ($emp->user->name ?? 'Employee') }}</strong><br>
                        <small class="text-muted">{{ $emp->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="list-item">No recent employees.</div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-6">
            <div class="glass">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="list-title">User Distribution</div>
                    <div class="small text-muted">Employers vs Employees</div>
                </div>
                <canvas id="userDistribution" height="160"></canvas>
            </div>
        </div>

    </div> <!-- /footer row -->
    @endif
</div> <!-- /container -->

<!-- Animated count-up script -->
<script>
    document.querySelectorAll('.counter').forEach(el => {
        const target = parseInt(el.getAttribute('data-target') || 0, 10);
        let cur = 0;
        const step = Math.max(1, Math.floor(target / 60));
        const tick = () => {
            cur += step;
            if (cur >= target) {
                el.innerText = target;
            } else {
                el.innerText = cur;
                requestAnimationFrame(tick);
            }
        };
        tick();
    });
</script>

<!-- Charts (Chart.js) -->
<script>
    Chart.defaults.font.family = "Poppins, system-ui, -apple-system, 'Segoe UI', Roboto";
    Chart.defaults.color = "#334155";

    // Overview bar (employers / employees / jobs)
    (function () {
        const ctx = document.getElementById('overviewBar').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Employers','Employees','Jobs'],
                datasets: [{
                    label: 'Counts',
                    data: [
                        {{ $data['employers'] ?? 0 }},
                        {{ $data['employees'] ?? 0 }},
                        {{ $data['jobs'] ?? 0 }}
                    ],
                    backgroundColor: ['#4a6bff','#21c77a','#f6b041'],
                    borderRadius: 8,
                    barThickness: 28
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#6b7280' } },
                    y: { grid: { color: 'rgba(15,23,42,0.05)' }, ticks: { color: '#6b7280', beginAtZero: true } }
                }
            }
        });
    })();

    // User distribution pie
    (function () {
        const ctx = document.getElementById('userDistribution').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Employers','Employees'],
                datasets: [{
                    data: [{{ $data['employers'] ?? 0 }}, {{ $data['employees'] ?? 0 }}],
                    backgroundColor: ['#6f9cff','#50e3c2'],
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#6b7280' } }
                }
            }
        });
    })();

    // JobStats line (if exists)
    @if(!empty($data['jobStats']) && count($data['jobStats'])>0)
    (function () {
        const labels = {!! json_encode(array_keys($data['jobStats']->toArray())) !!};
        const values = {!! json_encode(array_values($data['jobStats']->toArray())) !!};
        const ctx = document.getElementById('jobStatsLine').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jobs posted',
                    data: values,
                    borderColor: '#4a6bff',
                    backgroundColor: 'rgba(74,107,255,0.12)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: '#6b7280' }, grid: { display: false } },
                    y: { ticks: { color: '#6b7280' }, grid: { color: 'rgba(15,23,42,0.04)' } }
                }
            }
        });
    })();
    @endif
</script>
<script>
Chart.defaults.font.family = "Poppins, sans-serif";
Chart.defaults.color = "#334155";
</script>
{{-- ---------------------------------------------------------
     EMPLOYER CHARTS (FIXED, RESPONSIVE, SHARP)
---------------------------------------------------------- --}}
@if($user->role === 'employer')

<style>
    .chart-box {
        background: white;
        border-radius: 14px;
        padding: 18px;
        margin-top: 25px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        flex: 1 1 calc(50% - 20px);
    min-width: 300px;
    width: 100%;
    }


    canvas {
        width: 100% !important;
        max-height: 240px !important;
    }
</style>

<script>
    Chart.defaults.font.family = "Poppins";
    Chart.defaults.color = "#334155";
    Chart.defaults.devicePixelRatio = 2; // sharp charts
</script>


{{-- ---------------------------
     Applications Per Job
---------------------------- --}}
<div class="chart-box">
    <h4 class="font-semibold mb-2">Applications Per Job</h4>
    <canvas id="applicationsPerJobChart" height="200"></canvas>
</div>

<script>
    new Chart(document.getElementById('applicationsPerJobChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($data['applicationsPerJob']->pluck('title')) !!},
            datasets: [{
                label: "Applications",
                data: {!! json_encode($data['applicationsPerJob']->pluck('applications_count')) !!},
                backgroundColor: "#4a6bff",
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>



{{-- ---------------------------
     Daily Applications
---------------------------- --}}
<div class="chart-box">
    <h4 class="font-semibold mb-2">Daily Applications (Last 7 Days)</h4>
    <canvas id="dailyApplicationsChart" height="200"></canvas>
</div>

<script>
    new Chart(document.getElementById('dailyApplicationsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($data['dailyApplications']->keys()) !!},
            datasets: [{
                label: "Daily Applications",
                data: {!! json_encode($data['dailyApplications']->values()) !!},
                borderColor: "#21c77a",
                backgroundColor: "rgba(33,199,122,0.2)",
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>


{{-- ---------------------------
     Job Status (Active / Closed / Draft)
---------------------------- --}}
<div class="chart-box">
    <h4 class="font-semibold mb-2">Job Status Overview</h4>
    <canvas id="jobStatusChart" height="200"></canvas>
</div>

<script>
    new Chart(document.getElementById('jobStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($data['jobStatusCount']->keys()) !!},
            datasets: [{
                data: {!! json_encode($data['jobStatusCount']->values()) !!},
                backgroundColor: ["#4a6bff", "#21c77a", "#f6b041"]
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    position: 'bottom',
                    labels: { boxWidth: 14 }
                }
            }
        }
    });
</script>

@endif


@endsection
