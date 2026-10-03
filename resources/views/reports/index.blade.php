<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reports & Analytics') }}
            </h2>
            <a href="{{ route('reports.export-assets') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md text-xs uppercase tracking-widest transition">
                📥 Download Assets CSV
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-indigo-500">
                    <p class="text-xs font-bold text-gray-500 uppercase">Total Assets</p>
                    <p class="text-2xl font-black text-gray-800 mt-1">{{ $totalAssets }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-xs font-bold text-gray-500 uppercase">Active Assets</p>
                    <p class="text-2xl font-black text-green-600 mt-1">{{ $activeAssets }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <p class="text-xs font-bold text-gray-500 uppercase">In Repair</p>
                    <p class="text-2xl font-black text-yellow-600 mt-1">{{ $repairAssets }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-red-500">
                    <p class="text-xs font-bold text-gray-500 uppercase">Scrapped</p>
                    <p class="text-2xl font-black text-red-600 mt-1">{{ $scrappedAssets }}</p>
                </div>
            </div>

            <!-- Branch Summary Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Branch-wise Asset Breakdown</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Branch Name</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600">Total Assets</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600">Total Tickets</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($branches as $branch)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $branch->name }} ({{ $branch->code }})</td>
                                    <td class="px-4 py-3 text-center font-bold text-indigo-600">{{ $branch->assets_count }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-orange-600">{{ $branch->tickets_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>