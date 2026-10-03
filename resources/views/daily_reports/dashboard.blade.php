<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daily IT Working Dashboard') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('daily-reports.calendar') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-md border">
                    📅 Calendar View
                </a>
                <a href="{{ route('daily-reports.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-md shadow">
                    + Today's Work Entry
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Today's Stats Overview -->
            <div>
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Today's Summary ({{ date('d M, Y') }})</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-4">
                    <div class="bg-white p-4 rounded-lg border shadow-sm text-center">
                        <p class="text-xs text-gray-400 font-medium">Work Entries</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['today_entries'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border shadow-sm text-center">
                        <p class="text-xs text-gray-400 font-medium">Total Duration</p>
                        <p class="text-lg font-bold text-indigo-600 mt-1">{{ $stats['today_duration'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border shadow-sm text-center">
                        <p class="text-xs text-gray-400 font-medium">Completed</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['completed_works'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border shadow-sm text-center">
                        <p class="text-xs text-gray-400 font-medium">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['pending_works'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border shadow-sm text-center">
                        <p class="text-xs text-gray-400 font-medium">Branches</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['branches_covered'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border shadow-sm text-center">
                        <p class="text-xs text-gray-400 font-medium">Tickets</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1">{{ $stats['tickets_resolved'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border shadow-sm text-center">
                        <p class="text-xs text-gray-400 font-medium">Assets</p>
                        <p class="text-2xl font-bold text-gray-700 mt-1">{{ $stats['assets_handled'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Reports Table -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800">Recent Working Reports</h3>
                    <a href="{{ route('daily-reports.index') }}" class="text-xs text-indigo-600 hover:underline">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600">Report #</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600">Date</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600">IT Officer</th>
                                <th class="px-4 py-2 text-center font-semibold text-gray-600">Entries</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600">Total Hours</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-2 text-center font-semibold text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentReports as $report)
                                <tr>
                                    <td class="px-4 py-2 font-mono text-indigo-600 font-medium">
                                        <a href="{{ route('daily-reports.show', $report) }}">{{ $report->report_number }}</a>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900">{{ $report->report_date->format('d M, Y') }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ $report->user->name }}</td>
                                    <td class="px-4 py-2 text-center font-bold text-gray-800">{{ $report->total_entries }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ $report->formatted_total_duration }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-0.5 text-xs rounded-full font-semibold {{ $report->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('daily-reports.show', $report) }}" class="text-xs bg-indigo-50 text-indigo-600 px-2 py-1 rounded hover:bg-indigo-100">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">কোনো রিপোর্ট পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>