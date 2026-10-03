<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('IT Asset Inventory') }}
            </h2>
            <a href="{{ route('assets.create') }}" class="w-full sm:w-auto text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150">
                + Add New Asset
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filter Bar -->
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm border border-gray-100">
                <form method="GET" action="{{ route('assets.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search Input -->
                    <div>
                        <x-input-label for="search" :value="__('Search Tag / Name / S/N')" />
                        <x-text-input id="search" name="search" type="text" class="block mt-1 w-full text-sm" placeholder="Search..." :value="request('search')" />
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Branch Filter (Admin Only) -->
                    @if(auth()->user()->isAdmin())
                        <div>
                            <x-input-label for="branch_id" :value="__('Branch')" />
                            <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Status Filter -->
                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                            <option value="in_repair" {{ request('status') == 'in_repair' ? 'selected' : '' }}>In Repair</option>
                            <option value="damaged" {{ request('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                            <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-2">
                        <x-primary-button class="w-full justify-center">
                            {{ __('Filter') }}
                        </x-primary-button>
                        <a href="{{ route('assets.index') }}" class="px-3 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase hover:bg-gray-300">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Asset Data Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Asset Tag</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Name & Model</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Category</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Branch</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($assets as $asset)
                                    <tr>
                                        <td class="px-4 py-3 font-mono font-medium text-indigo-600 whitespace-nowrap">
                                            <a href="{{ route('assets.show', $asset) }}" class="hover:underline">
                                                {{ $asset->asset_tag }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900 font-medium whitespace-nowrap">
                                            {{ $asset->name }}
                                            <span class="block text-xs text-gray-500 font-normal">{{ $asset->brand }} {{ $asset->model }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                            {{ $asset->assetCategory->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                            {{ $asset->branch->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $asset->status === 'in_use' || $asset->status === 'active' ? 'bg-green-100 text-green-800' : ($asset->status === 'in_repair' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst(str_replace('_', ' ', $asset->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('assets.show', $asset) }}" class="text-blue-600 hover:text-blue-900 text-xs bg-blue-50 px-2 py-1 rounded">View</a>
                                                <a href="{{ route('assets.edit', $asset) }}" class="text-indigo-600 hover:text-indigo-900 text-xs bg-indigo-50 px-2 py-1 rounded">Edit</a>
                                                @if(auth()->user()->isAdmin())
                                                    <form action="{{ route('assets.destroy', $asset) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই অ্যাসেটটি ডিলিট করতে চান?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs bg-red-50 px-2 py-1 rounded">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">কোনো IT অ্যাসেট পাওয়া যায়নি।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $assets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>