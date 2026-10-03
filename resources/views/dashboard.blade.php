<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IT Infrastructure Analytics & Overview') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Quick Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-lg p-6 text-white shadow-md">
                <h1 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-sm opacity-90 mt-1">
                    Unnayan Prochesta IT Management System — Here is your current operational overview.
                </p>
            </div>

            <!-- IT Asset Summary Cards -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">IT Assets Summary</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Total Branches</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBranches }}</p>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full">
                            🏢
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Total IT Assets</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalAssets }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-full">
                            💻
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Active In-Use</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">{{ $activeAssets }}</p>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-full">
                            ✅
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Damaged / Disposed</p>
                            <p class="text-2xl font-bold text-red-600 mt-1">{{ $damagedAssets }}</p>
                        </div>
                        <div class="p-3 bg-red-50 text-red-600 rounded-full">
                            ⚠️
                        </div>
                    </div>

                </div>
            </div>

            <!-- Helpdesk Ticket Summary Cards -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Support Tickets Metrics</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Open Tickets</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $openTickets }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 text-yellow-600 rounded-full">
                            📥
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">In Progress</p>
                            <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $inProgressTickets }}</p>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full">
                            ⚙️
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Resolved</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">{{ $resolvedTickets }}</p>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-full">
                            🎉
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Total Tickets</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalTickets }}</p>
                        </div>
                        <div class="p-3 bg-gray-100 text-gray-600 rounded-full">
                            📋
                        </div>
                    </div>

                </div>
            </div>

            <!-- Recent Activity Tables Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Recent Support Tickets -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800 text-base">Recent Support Tickets</h3>
                        <a href="{{ route('tickets.index') }}" class="text-xs text-indigo-600 hover:underline">View All &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-2">Ticket</th>
                                    <th class="p-2">Subject</th>
                                    <th class="p-2 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($recentTickets as $ticket)
                                    <tr>
                                        <td class="p-2 font-bold text-indigo-600">
                                            <a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->ticket_number }}</a>
                                        </td>
                                        <td class="p-2 truncate max-w-xs">{{ $ticket->subject }}</td>
                                        <td class="p-2 text-center">
                                            @if($ticket->status == 'open')
                                                <span class="px-2 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded">Open</span>
                                            @elseif($ticket->status == 'in_progress')
                                                <span class="px-2 py-0.5 text-xs bg-indigo-100 text-indigo-800 rounded">Progress</span>
                                            @elseif($ticket->status == 'resolved')
                                                <span class="px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded">Resolved</span>
                                            @else
                                                <span class="px-2 py-0.5 text-xs bg-gray-200 text-gray-800 rounded">Closed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-400">কোনো রিসেন্ট টিকেট নেই।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Added IT Assets -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800 text-base">Recently Added Assets</h3>
                        <a href="{{ route('assets.index') }}" class="text-xs text-indigo-600 hover:underline">View All &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-2">Asset Tag</th>
                                    <th class="p-2">Asset Name</th>
                                    <th class="p-2">Branch</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($recentAssets as $asset)
                                    <tr>
                                        <td class="p-2 font-bold text-gray-800">
                                            <a href="{{ route('assets.show', $asset) }}">{{ $asset->asset_tag }}</a>
                                        </td>
                                        <td class="p-2 font-medium">{{ $asset->name }}</td>
                                        <td class="p-2 text-gray-500">{{ $asset->branch->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-400">কোনো রিসেন্ট অ্যাসেট নেই।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>