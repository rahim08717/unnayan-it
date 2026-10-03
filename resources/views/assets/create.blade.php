<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New IT Asset') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <form action="{{ route('assets.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Category -->
                            <div>
                                <x-input-label for="asset_category_id" :value="__('Asset Category *')" />
                                <select id="asset_category_id" name="asset_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('asset_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ strtoupper($category->type) }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('asset_category_id')" class="mt-2" />
                            </div>

                            <!-- Branch -->
                            <div>
                                <x-input-label for="branch_id" :value="__('Branch *')" />
                                <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }} ({{ $branch->code }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                            </div>

                            <!-- Asset Name -->
                            <div>
                                <x-input-label for="name" :value="__('Item Name / Title *')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="e.g. Dell Optiplex Desktop" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Assigned User -->
                            <div>
                                <x-input-label for="user_id" :value="__('Assigned User (Optional)')" />
                                <select id="user_id" name="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Unassigned (Branch Property)</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('Brand')" />
                                <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand')" placeholder="e.g. Dell, HP, Mikrotik" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model')" placeholder="e.g. OptiPlex 3080" />
                            </div>

                            <!-- Serial Number -->
                            <div>
                                <x-input-label for="serial_number" :value="__('Serial Number (S/N)')" />
                                <x-text-input id="serial_number" class="block mt-1 w-full" type="text" name="serial_number" :value="old('serial_number')" placeholder="Unique Serial Number" />
                                <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Asset Status *')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (In Use)</option>
                                    <option value="spare" {{ old('status') == 'spare' ? 'selected' : '' }}>Spare (In Store)</option>
                                    <option value="in_repair" {{ old('status') == 'in_repair' ? 'selected' : '' }}>In Repair</option>
                                    <option value="scrapped" {{ old('status') == 'scrapped' ? 'selected' : '' }}>Scrapped / Damaged</option>
                                </select>
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                                <x-text-input id="purchase_date" class="block mt-1 w-full" type="date" name="purchase_date" :value="old('purchase_date')" />
                            </div>

                            <!-- Warranty Expiry -->
                            <div>
                                <x-input-label for="warranty_expiry" :value="__('Warranty Expiry Date')" />
                                <x-text-input id="warranty_expiry" class="block mt-1 w-full" type="date" name="warranty_expiry" :value="old('warranty_expiry')" />
                            </div>

                            <!-- Purchase Cost -->
                            <div class="md:col-span-2">
                                <x-input-label for="purchase_cost" :value="__('Purchase Cost (BDT)')" />
                                <x-text-input id="purchase_cost" class="block mt-1 w-full" type="number" step="0.01" name="purchase_cost" :value="old('purchase_cost')" placeholder="0.00" />
                            </div>

                            <!-- Specifications -->
                            <div class="md:col-span-2">
                                <x-input-label for="specifications" :value="__('Specifications (RAM, CPU, Hard Drive, etc.)')" />
                                <textarea id="specifications" name="specifications" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Core i5 10th Gen, 8GB DDR4 RAM, 256GB SSD...">{{ old('specifications') }}</textarea>
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Additional Notes')" />
                                <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            </div>

                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('assets.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            <x-primary-button class="w-full sm:w-auto">
                                {{ __('Save Asset') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>