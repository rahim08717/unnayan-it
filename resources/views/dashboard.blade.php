<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl sm:text-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent tracking-tight">
                    {{ __('IT Operational Analytics & Command Center') }}
                </h2>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Real-time system telemetry, interactive charts & asset monitoring</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-slate-200/80 shadow-sm text-xs font-bold text-slate-700">
                    <span class="text-indigo-600">🕒</span>
                    <span id="liveClock">--:--:--</span>
                </div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60 shadow-sm shadow-emerald-500/10 animate-pulse">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    System Live
                </span>
            </div>
        </div>
    </x-slot>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="py-6 sm:py-8 bg-slate-900/5 min-h-screen">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Ultra Modern Hero Welcome Banner -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-900 p-6 sm:p-8 text-white shadow-2xl shadow-indigo-950/30 border border-slate-800">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="space-y-2.5">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-500/20 backdrop-blur-md border border-indigo-400/30 text-indigo-300 text-xs font-bold rounded-full uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                            Live Analytics Dashboard
                        </div>
                        <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
                            Welcome Back, <span class="bg-gradient-to-r from-indigo-200 via-sky-200 to-pink-200 bg-clip-text text-transparent">{{ Auth::user()->name }}</span> 🚀
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-300 max-w-2xl font-medium leading-relaxed">
                            Unnayan Prochesta Enterprise IT Systems — Interactive charts, ticket resolution metrics, and asset health status.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('tickets.index') }}" class="w-full sm:w-auto text-center px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-xl border border-white/20 text-white font-bold text-xs sm:text-sm transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg">
                            View Helpdesk →
                        </a>
                        <a href="{{ route('assets.index') }}" class="w-full sm:w-auto text-center px-5 py-3 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold text-xs sm:text-sm transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg shadow-indigo-500/30">
                            Manage Assets ⚡
                        </a>
                    </div>
                </div>
            </div>

            <!-- SECTION 1: ANIMATED INTERACTIVE CHARTS GRID (TOP PRIORITY) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shadow-sm shadow-indigo-500 animate-ping"></span>
                        Real-Time System Visualizations & Charts
                    </h3>
                    <span class="text-[11px] font-extrabold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                        Interactive Mode
                    </span>
                </div>

                <!-- Top Row Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Chart 1: Animated Bar/Column Chart for Ticket Status -->
                    <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40 lg:col-span-2 relative overflow-hidden">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                            <div>
                                <h4 class="font-extrabold text-slate-800 text-base sm:text-lg">Helpdesk Ticket Telemetry</h4>
                                <p class="text-xs font-semibold text-slate-400">Live breakdown of active support requests</p>
                            </div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold self-start sm:self-auto">
                                📊 Bar Analytics
                            </div>
                        </div>
                        <div id="ticketsBarChart" class="w-full h-72 sm:h-80"></div>
                    </div>

                    <!-- Chart 2: Animated Pie/Donut Chart for Asset Health -->
                    <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40 flex flex-col justify-between">
                        <div class="mb-4">
                            <h4 class="font-extrabold text-slate-800 text-base sm:text-lg">Asset Health Pie Ratio</h4>
                            <p class="text-xs font-semibold text-slate-400">Operational vs Damaged device status</p>
                        </div>
                        <div id="assetPieChart" class="w-full flex justify-center my-auto py-2"></div>
                    </div>

                </div>

                <!-- Bottom Row Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Chart 3: Radial Gauge Chart for Resolution SLA -->
                    <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40 flex flex-col items-center justify-between">
                        <div class="w-full text-left mb-2">
                            <h4 class="font-extrabold text-slate-800 text-base sm:text-lg">SLA Resolution Rate</h4>
                            <p class="text-xs font-semibold text-slate-400">Percentage of tickets solved</p>
                        </div>
                        <div id="resolutionGaugeChart" class="w-full flex justify-center py-2"></div>
                    </div>

                    <!-- Chart 4: Animated Polar Area Chart for Infrastructure Allocation -->
                    <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40 flex flex-col justify-between">
                        <div class="mb-2">
                            <h4 class="font-extrabold text-slate-800 text-base sm:text-lg">Infrastructure Polar Overview</h4>
                            <p class="text-xs font-semibold text-slate-400">Multi-metric operational balance</p>
                        </div>
                        <div id="infrastructurePolarChart" class="w-full flex justify-center py-2"></div>
                    </div>

                    <!-- Chart 5: Animated Area Chart for Activity Trend -->
                    <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40 md:col-span-2 lg:col-span-1 flex flex-col justify-between">
                        <div class="mb-2">
                            <h4 class="font-extrabold text-slate-800 text-base sm:text-lg">Volume Activity Trend</h4>
                            <p class="text-xs font-semibold text-slate-400">Monthly support & asset growth</p>
                        </div>
                        <div id="activityAreaChart" class="w-full h-64"></div>
                    </div>

                </div>
            </div>

            <!-- SECTION 2: STAT CARDS (MOVED BELOW CHARTS AS REQUESTED) -->
            <div class="space-y-6 pt-4">
                
                <!-- Hardware Infrastructure Summary -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 shadow-sm shadow-indigo-600"></span>
                            Hardware Infrastructure Overview
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                        
                        <div class="relative group bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Branches</span>
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center shadow-md shadow-indigo-500/30 font-bold">🏢</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl sm:text-4xl font-black text-slate-800 tracking-tight">{{ $totalBranches }}</span>
                                <p class="text-xs text-slate-500 font-semibold mt-1">Connected Branch Offices</p>
                            </div>
                        </div>

                        <div class="relative group bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Assets</span>
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center shadow-md shadow-blue-500/30 font-bold">💻</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl sm:text-4xl font-black text-blue-600 tracking-tight">{{ $totalAssets }}</span>
                                <p class="text-xs text-slate-500 font-semibold mt-1">Inventoried Devices</p>
                            </div>
                        </div>

                        <div class="relative group bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active In-Use</span>
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/30 font-bold">⚡</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl sm:text-4xl font-black text-emerald-600 tracking-tight">{{ $activeAssets }}</span>
                                <p class="text-xs text-slate-500 font-semibold mt-1">Operational & Deployed</p>
                            </div>
                        </div>

                        <div class="relative group bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-rose-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Damaged / Repair</span>
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center shadow-md shadow-rose-500/30 font-bold">🛠️</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl sm:text-4xl font-black text-rose-600 tracking-tight">{{ $damagedAssets }}</span>
                                <p class="text-xs text-slate-500 font-semibold mt-1">Requires Maintenance</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Helpdesk Support Telemetry Summary -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-sm shadow-amber-500"></span>
                            Helpdesk Support Telemetry
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                        
                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Open Tickets</span>
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">📥</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl font-black text-amber-600 tracking-tight">{{ $openTickets }}</span>
                                <p class="text-xs text-slate-400 font-semibold mt-1">Awaiting Assignment</p>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">In Progress</span>
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">⚙️</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl font-black text-indigo-600 tracking-tight">{{ $inProgressTickets }}</span>
                                <p class="text-xs text-slate-400 font-semibold mt-1">Active Resolution</p>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Resolved</span>
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">🎉</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl font-black text-emerald-600 tracking-tight">{{ $resolvedTickets }}</span>
                                <p class="text-xs text-slate-400 font-semibold mt-1">Successfully Closed</p>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-md hover:shadow-2xl hover:shadow-purple-500/10 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Tickets</span>
                                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">📋</div>
                            </div>
                            <div class="mt-4">
                                <span class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalTickets }}</span>
                                <p class="text-xs text-slate-400 font-semibold mt-1">All Time Requests</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- SECTION 3: RECENT TABLES SECTION -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-4">
                
                <!-- Recent Tickets -->
                <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-base sm:text-lg">Recent Helpdesk Tickets</h4>
                            <p class="text-xs font-semibold text-slate-400">Latest user submitted issues</p>
                        </div>
                        <a href="{{ route('tickets.index') }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all">
                            View All →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] font-black tracking-wider">
                                    <th class="pb-3 px-2">Ticket</th>
                                    <th class="pb-3 px-2">Subject</th>
                                    <th class="pb-3 px-2 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/80">
                                @forelse($recentTickets as $ticket)
                                    <tr class="group hover:bg-indigo-50/40 transition-colors">
                                        <td class="py-3 px-2 font-black text-indigo-600 text-xs">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="hover:underline flex items-center gap-1">
                                                <span>🎫</span>
                                                <span>{{ $ticket->ticket_number }}</span>
                                            </a>
                                        </td>
                                        <td class="py-3 px-2 text-xs font-bold text-slate-700 max-w-xs truncate">
                                            {{ $ticket->subject }}
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            @if($ticket->status == 'open')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-extrabold bg-amber-100 text-amber-800 rounded-full">
                                                    Open
                                                </span>
                                            @elseif($ticket->status == 'in_progress')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-extrabold bg-indigo-100 text-indigo-800 rounded-full">
                                                    In Progress
                                                </span>
                                            @elseif($ticket->status == 'resolved')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-extrabold bg-emerald-100 text-emerald-800 rounded-full">
                                                    Resolved
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-extrabold bg-slate-100 text-slate-700 rounded-full">
                                                    Closed
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-6 text-center text-slate-400 font-bold text-xs">
                                            No recent tickets log found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Assets -->
                <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/40">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-base sm:text-lg">Recently Added Assets</h4>
                            <p class="text-xs font-semibold text-slate-400">Newly registered devices</p>
                        </div>
                        <a href="{{ route('assets.index') }}" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all">
                            View All →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] font-black tracking-wider">
                                    <th class="pb-3 px-2">Asset Tag</th>
                                    <th class="pb-3 px-2">Device Name</th>
                                    <th class="pb-3 px-2">Location</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/80">
                                @forelse($recentAssets as $asset)
                                    <tr class="group hover:bg-slate-50 transition-colors">
                                        <td class="py-3 px-2 text-xs font-black text-indigo-600">
                                            <a href="{{ route('assets.show', $asset) }}" class="hover:underline">
                                                {{ $asset->asset_tag }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-2 text-xs font-bold text-slate-700 truncate max-w-xs">
                                            {{ $asset->name }}
                                        </td>
                                        <td class="py-3 px-2 text-xs font-semibold text-slate-500">
                                            📍 {{ $asset->branch->name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-6 text-center text-slate-400 font-bold text-xs">
                                            No recent assets found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- ADVANCED ANIMATED APEXCHARTS CONFIGURATIONS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // Live Digital Clock
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString();
                const clockEl = document.getElementById('liveClock');
                if(clockEl) clockEl.textContent = timeString;
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Dynamic PHP Variables Bindings
            const openTickets = {{ (int)$openTickets }};
            const inProgressTickets = {{ (int)$inProgressTickets }};
            const resolvedTickets = {{ (int)$resolvedTickets }};
            const totalTickets = {{ (int)$totalTickets }};

            const activeAssets = {{ (int)$activeAssets }};
            const damagedAssets = {{ (int)$damagedAssets }};
            const totalAssets = {{ (int)$totalAssets }};
            const otherAssets = Math.max(0, totalAssets - activeAssets - damagedAssets);
            const totalBranches = {{ (int)$totalBranches }};

            // Common Font Setup
            const fontFamily = 'Plus Jakarta Sans, Inter, sans-serif';

            // 1. Ticket Status Column/Bar Chart (Animated Gradient)
            new ApexCharts(document.querySelector("#ticketsBarChart"), {
                series: [{
                    name: 'Total Count',
                    data: [openTickets, inProgressTickets, resolvedTickets]
                }],
                chart: {
                    type: 'bar',
                    height: 310,
                    fontFamily: fontFamily,
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 1000,
                        animateGradually: { enabled: true, delay: 150 },
                        dynamicAnimation: { enabled: true, speed: 350 }
                    }
                },
                colors: ['#F59E0B', '#6366F1', '#10B981'],
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        distributed: true,
                        columnWidth: '45%',
                        dataLabels: { position: 'top' }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.2,
                        gradientToColors: ['#FBBF24', '#818CF8', '#34D399'],
                        opacityFrom: 0.95,
                        opacityTo: 0.85
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: { fontSize: '12px', fontWeight: '800', colors: ['#475569'] }
                },
                legend: { show: false },
                xaxis: {
                    categories: ['Open', 'In Progress', 'Resolved'],
                    labels: { style: { colors: '#64748B', fontWeight: 700, fontSize: '12px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: { labels: { style: { colors: '#94A3B8', fontWeight: 600 } } },
                grid: { borderColor: '#F1F5F9', strokeDashArray: 5 },
                responsive: [{
                    breakpoint: 640,
                    options: { plotOptions: { bar: { columnWidth: '60%' } } }
                }]
            }).render();

            // 2. Asset Pie Chart (Interactive Animated Pie/Donut)
            new ApexCharts(document.querySelector("#assetPieChart"), {
                series: [activeAssets, damagedAssets, otherAssets],
                labels: ['Active In-Use', 'Damaged / Disposed', 'In Stock / Other'],
                chart: {
                    type: 'pie',
                    height: 290,
                    fontFamily: fontFamily,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 1200
                    }
                },
                colors: ['#10B981', '#EF4444', '#94A3B8'],
                stroke: { width: 2, colors: ['#ffffff'] },
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 700,
                    labels: { colors: '#64748B' }
                },
                responsive: [{
                    breakpoint: 480,
                    options: { chart: { height: 260 }, legend: { position: 'bottom' } }
                }]
            }).render();

            // 3. Ticket SLA Resolution Radial Gauge Chart
            const resRate = totalTickets > 0 ? Math.round((resolvedTickets / totalTickets) * 100) : 100;
            new ApexCharts(document.querySelector("#resolutionGaugeChart"), {
                series: [resRate],
                chart: {
                    type: 'radialBar',
                    height: 270,
                    fontFamily: fontFamily,
                    animations: { enabled: true, speed: 1400 }
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        hollow: { size: '68%' },
                        track: { background: '#F1F5F9', strokeWidth: '100%' },
                        dataLabels: {
                            name: { fontSize: '12px', fontWeight: '800', color: '#64748B', offsetY: 18 },
                            value: { offsetY: -18, fontSize: '30px', fontWeight: '900', color: '#0F172A', formatter: (val) => `${val}%` }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        gradientToColors: ['#34D399'],
                        stops: [0, 100]
                    }
                },
                colors: ['#059669'],
                labels: ['Resolution SLA']
            }).render();

            // 4. Infrastructure Multi-Metric Polar Area Chart
            new ApexCharts(document.querySelector("#infrastructurePolarChart"), {
                series: [totalBranches, totalAssets, activeAssets, totalTickets],
                labels: ['Branches', 'Total Assets', 'Active Assets', 'Total Tickets'],
                chart: {
                    type: 'polarArea',
                    height: 270,
                    fontFamily: fontFamily,
                    animations: { enabled: true, speed: 1100 }
                },
                stroke: { colors: ['#fff'] },
                fill: { opacity: 0.85 },
                colors: ['#6366F1', '#3B82F6', '#10B981', '#A855F7'],
                legend: { position: 'bottom', fontSize: '11px', fontWeight: 700, labels: { colors: '#64748B' } }
            }).render();

            // 5. Activity Area Trend Chart
            new ApexCharts(document.querySelector("#activityAreaChart"), {
                series: [{
                    name: 'Activity Index',
                    data: [
                        Math.max(1, openTickets),
                        Math.max(2, totalAssets),
                        Math.max(1, activeAssets),
                        Math.max(1, totalTickets)
                    ]
                }],
                chart: {
                    type: 'area',
                    height: 240,
                    fontFamily: fontFamily,
                    toolbar: { show: false },
                    animations: { enabled: true, speed: 1300 }
                },
                colors: ['#8B5CF6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: ['Open Req', 'Assets', 'Deployed', 'Tickets'],
                    labels: { style: { colors: '#94A3B8', fontWeight: 600, fontSize: '10px' } }
                },
                yaxis: { show: false },
                grid: { show: false }
            }).render();

        });
    </script>
</x-app-layout>