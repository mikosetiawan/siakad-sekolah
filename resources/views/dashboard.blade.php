<x-app-layout title="Dashboard">
    <style>
        :root {
            --primary: #2563EB;
            --primary-light: #E0E7FF;
            --success: #059669;
            --warning: #D97706;
            --danger: #DC2626;
            --purple: #7C3AED;
            --card-bg: #FFFFFF;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .dark {
            --primary: #3B82F6;
            --primary-light: #1E3A8A;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --purple: #A78BFA;
            --card-bg: #1F2937;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        .dark .bg-white {
            background-color: var(--card-bg);
        }

        .dark .text-gray-800 {
            color: #E5E7EB;
        }

        .dark .text-gray-600 {
            color: #9CA3AF;
        }

        .dark .border-gray-200 {
            border-color: #374151;
        }

        .dark .bg-gray-50 {
            background-color: #2D3748;
        }

        .card-hover {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(37, 99, 235, 0.05) 100%);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .card-hover:hover::before {
            left: 100%;
        }

        .card-hover:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }

        .chart-container {
            background: linear-gradient(145deg, var(--card-bg), rgba(37, 99, 235, 0.02));
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .stat-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .icon-wrapper {
            background: linear-gradient(135deg, var(--primary), var(--purple));
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>

    <!-- Header with Dark Mode Toggle -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Dashboard</h1>
        <button id="theme-toggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700">
            <i class="fas fa-moon text-gray-600 dark:text-gray-300"></i>
        </button>
    </div>

    <!-- Stats Cards dengan Design Baru -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="rounded-2xl shadow-xl p-6 card-hover border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Total Siswa</p>
                    <p class="text-5xl font-black stat-number">{{ number_format($totalStudents) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-500 text-sm font-medium">+12%</span>
                        <span class="text-gray-500 text-xs ml-1">dari bulan lalu</span>
                    </div>
                </div>
                <div class="icon-wrapper p-4 rounded-2xl text-white">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl shadow-xl p-6 card-hover border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Total Guru</p>
                    <p class="text-5xl font-black stat-number">{{ number_format($totalTeachers) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-blue-500 text-sm font-medium">+3%</span>
                        <span class="text-gray-500 text-xs ml-1">dari bulan lalu</span>
                    </div>
                </div>
                <div class="icon-wrapper p-4 rounded-2xl text-white">
                    <i class="fas fa-user-tie text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl shadow-xl p-6 card-hover border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Kelas Aktif</p>
                    <p class="text-5xl font-black stat-number">{{ number_format($activeClasses) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-purple-500 text-sm font-medium">Stabil</span>
                        <span class="text-gray-500 text-xs ml-1">semester ini</span>
                    </div>
                </div>
                <div class="icon-wrapper p-4 rounded-2xl text-white">
                    <i class="fas fa-school text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl shadow-xl p-6 card-hover border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Rata-rata Nilai</p>
                    <p class="text-5xl font-black stat-number">{{ number_format($averageGrade, 1) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-500 text-sm font-medium">+5.2%</span>
                        <span class="text-gray-500 text-xs ml-1">peningkatan</span>
                    </div>
                </div>
                <div class="icon-wrapper p-4 rounded-2xl text-white">
                    <i class="fas fa-trophy text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section dengan Design Baru -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Performance Chart - Ganti ke Bar Chart -->
        <div class="chart-container">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Performa Akademik (6 Bulan Terakhir)</h3>
                <div class="flex space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                </div>
            </div>
            <div class="h-80">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Class Distribution - Ganti ke Polar Area Chart -->
        <div class="chart-container">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Distribusi Siswa per Kelas</h3>
                <div class="text-sm text-gray-500">Total: {{ $classDistribution->sum('student_count') }} siswa</div>
            </div>
            <div class="h-80">
                <canvas id="classChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Aktivitas Terbaru</h3>
                <a href="{{ route('students.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">Lihat Semua</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start space-x-3">
                        <div class="bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900 p-2 rounded-full">
                            <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }}-600 dark:text-{{ $activity['color'] }}-400 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $activity['title'] }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Belum ada aktivitas terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Chart.js and Dark Mode Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dark Mode Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
            themeToggle.innerHTML = html.classList.contains('dark') ?
                '<i class="fas fa-sun text-gray-300"></i>' :
                '<i class="fas fa-moon text-gray-600"></i>';
            updateChartColors();
        });

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
            themeToggle.innerHTML = '<i class="fas fa-sun text-gray-300"></i>';
        }

        // Function to update chart colors based on theme
        function updateChartColors() {
            const isDark = html.classList.contains('dark');
            performanceChart.options.scales.y.grid.color = isDark ? '#374151' : '#E5E7EB';
            performanceChart.options.scales.x.grid.color = isDark ? '#374151' : '#E5E7EB';
            classChart.options.plugins.legend.labels.color = isDark ? '#D1D5DB' : '#1F2937';
            performanceChart.update();
            classChart.update();
        }

        // Performance Chart - Ganti ke 3D Bar Chart Style
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(performanceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($performanceData, 'month')) !!},
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: {!! json_encode(array_column($performanceData, 'grade')) !!},
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.8)',
                        'rgba(124, 58, 237, 0.8)', 
                        'rgba(5, 150, 105, 0.8)',
                        'rgba(217, 119, 6, 0.8)',
                        'rgba(220, 38, 38, 0.8)',
                        'rgba(8, 145, 178, 0.8)'
                    ],
                    borderColor: [
                        'rgb(37, 99, 235)',
                        'rgb(124, 58, 237)',
                        'rgb(5, 150, 105)',
                        'rgb(217, 119, 6)',
                        'rgb(220, 38, 38)',
                        'rgb(8, 145, 178)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: html.classList.contains('dark') ? '#374151' : '#E5E7EB',
                            borderColor: html.classList.contains('dark') ? '#4B5563' : '#D1D5DB'
                        },
                        ticks: {
                            color: html.classList.contains('dark') ? '#D1D5DB' : '#1F2937'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: html.classList.contains('dark') ? '#D1D5DB' : '#1F2937'
                        }
                    }
                }
            }
        });

        // Class Distribution Chart - Ganti ke Polar Area Chart
        const classCtx = document.getElementById('classChart').getContext('2d');
        const classChart = new Chart(classCtx, {
            type: 'polarArea',
            data: {
                labels: {!! json_encode($classDistribution->pluck('class_name')) !!},
                datasets: [{
                    data: {!! json_encode($classDistribution->pluck('student_count')) !!},
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.7)',
                        'rgba(5, 150, 105, 0.7)',
                        'rgba(124, 58, 237, 0.7)',
                        'rgba(217, 119, 6, 0.7)',
                        'rgba(220, 38, 38, 0.7)',
                        'rgba(8, 145, 178, 0.7)',
                        'rgba(101, 163, 13, 0.7)',
                        'rgba(234, 88, 12, 0.7)'
                    ],
                    borderColor: [
                        'rgb(37, 99, 235)',
                        'rgb(5, 150, 105)',
                        'rgb(124, 58, 237)',
                        'rgb(217, 119, 6)',
                        'rgb(220, 38, 38)',
                        'rgb(8, 145, 178)',
                        'rgb(101, 163, 13)',
                        'rgb(234, 88, 12)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: html.classList.contains('dark') ? '#D1D5DB' : '#1F2937',
                            padding: 20,
                            boxWidth: 12,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    r: {
                        grid: {
                            color: html.classList.contains('dark') ? '#374151' : '#E5E7EB'
                        },
                        ticks: {
                            color: html.classList.contains('dark') ? '#D1D5DB' : '#1F2937',
                            backdropColor: 'transparent'
                        }
                    }
                }
            }
        });

        // Initial chart color update
        updateChartColors();
    </script>
</x-app-layout>