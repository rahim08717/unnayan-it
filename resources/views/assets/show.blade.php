<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Asset Details: ') }} {{ $asset->asset_tag }}
            </h2>
            <a href="{{ route('assets.edit', $asset) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-xs uppercase font-semibold">
                Edit Asset
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="border-b pb-4 mb-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $asset->name }}</h1>
                        <p class="text-sm text-gray-500">Tag: <span class="font-bold text-indigo-600">{{ $asset->asset_tag }}</span></p>
                    </div>
                    <div>
                        @if($asset->status == 'active')
                            <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                        @elseif($asset->status == 'in_repair')
                            <span class="px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full">In Repair</span>
                        @elseif($asset->status == 'spare')
                            <span class="px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">Spare</span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Scrapped</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500">Category:</p>
                        <p class="font-semibold">{{ $asset->category->name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Assigned Branch:</p>
                        <p class="font-semibold">{{ $asset->branch->name }} ({{ $asset->branch->code }})</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Assigned User:</p>
                        <p class="font-semibold">{{ $asset->assignedUser->name ?? 'None (Branch Property)' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Brand & Model:</p>
                        <p class="font-semibold">{{ $asset->brand ?? 'N/A' }} {{ $asset->model ? '('.$asset->model.')' : '' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Serial Number:</p>
                        <p class="font-semibold">{{ $asset->serial_number ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Purchase Cost:</p>
                        <p class="font-semibold">{{ $asset->purchase_cost ? '৳ ' . number_format($asset->purchase_cost, 2) : 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Purchase Date:</p>
                        <p class="font-semibold">{{ $asset->purchase_date ? $asset->purchase_date->format('d M, Y') : 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Warranty Expiry:</p>
                        <p class="font-semibold">{{ $asset->warranty_expiry ? $asset->warranty_expiry->format('d M, Y') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t">
                    <h3 class="font-bold text-gray-700 mb-2">Specifications</h3>
                    <p class="text-gray-600 bg-gray-50 p-3 rounded-md">{{ $asset->specifications ?? 'No specifications provided.' }}</p>
                </div>

                @if($asset->notes)
                    <div class="mt-4">
                        <h3 class="font-bold text-gray-700 mb-2">Notes</h3>
                        <p class="text-gray-600 bg-gray-50 p-3 rounded-md">{{ $asset->notes }}</p>
                    </div>
                @endif

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('assets.index') }}" class="text-indigo-600 hover:underline text-sm font-semibold">← Back to Asset List</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>