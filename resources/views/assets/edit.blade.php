<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit IT Asset: ') }} {{ $asset->asset_tag }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <form action="{{ route('assets.update', $asset) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Category -->
                            <div>
                                <x-input-label for="asset_category_id" :value="__('Asset Category *')" />
                                <select id="asset_category_id" name="asset_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('asset_category_id', $asset->asset_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Branch -->
                            <div>
                                <x-input-label for="branch_id" :value="__('Branch *')" />
                                <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id', $asset->branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }} ({{ $branch->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Asset Name -->
                            <div>
                                <x-input-label for="name" :value="__('Item Name / Title *')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $asset->name)" required />
                            </div>

                            <!-- Assigned User -->
                            <div>
                                <x-input-label for="user_id" :value="__('Assigned User')" />
                                <select id="user_id" name="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Unassigned (Branch Property)</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $asset->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('Brand')" />
                                <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand', $asset->brand)" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model', $asset->model)" />
                            </div>

                            <!-- Serial Number -->
                            <div>
                                <x-input-label for="serial_number" :value="__('Serial Number (S/N)')" />
                                <x-text-input id="serial_number" class="block mt-1 w-full" type="text" name="serial_number" :value="old('serial_number', $asset->serial_number)" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Asset Status *')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="active" {{ old('status', $asset->status) == 'active' ? 'selected' : '' }}>Active (In Use)</option>
                                    <option value="spare" {{ old('status', $asset->status) == 'spare' ? 'selected' : '' }}>Spare (In Store)</option>
                                    <option value="in_repair" {{ old('status', $asset->status) == 'in_repair' ? 'selected' : '' }}>In Repair</option>
                                    <option value="scrapped" {{ old('status', $asset->status) == 'scrapped' ? 'selected' : '' }}>Scrapped / Damaged</option>
                                </select>
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                                <x-text-input id="purchase_date" class="block mt-1 w-full" type="date" name="purchase_date" :value="old('purchase_date', optional($asset->purchase_date)->format('Y-m-d'))" />
                            </div>

                            <!-- Warranty Expiry -->
                            <div>
                                <x-input-label for="warranty_expiry" :value="__('Warranty Expiry Date')" />
                                <x-text-input id="warranty_expiry" class="block mt-1 w-full" type="date" name="warranty_expiry" :value="old('warranty_expiry', optional($asset->warranty_expiry)->format('Y-m-d'))" />
                            </div>

                            <!-- Purchase Cost -->
                            <div class="md:col-span-2">
                                <x-input-label for="purchase_cost" :value="__('Purchase Cost (BDT)')" />
                                <x-text-input id="purchase_cost" class="block mt-1 w-full" type="number" step="0.01" name="purchase_cost" :value="old('purchase_cost', $asset->purchase_cost)" />
                            </div>

                            <!-- Specifications -->
                            <div class="md:col-span-2">
                                <x-input-label for="specifications" :value="__('Specifications')" />
                                <textarea id="specifications" name="specifications" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('specifications', $asset->specifications) }}</textarea>
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Additional Notes')" />
                                <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $asset->notes) }}</textarea>
                            </div>

                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('assets.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            <x-primary-button class="w-full sm:w-auto">
                                {{ __('Update Asset') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>