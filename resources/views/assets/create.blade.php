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
                    
                    <!-- Validation Errors Alert -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                            <div class="flex items-center mb-1">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm font-bold text-red-800">ফর্ম জমা দেওয়ায় কিছু সমস্যা পাওয়া গেছে:</p>
                            </div>
                            <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('assets.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Asset Tag (Required) -->
                            <div>
                                <x-input-label for="asset_tag" :value="__('Asset Tag / Code *')" />
                                <x-text-input id="asset_tag" class="block mt-1 w-full" type="text" name="asset_tag" :value="old('asset_tag')" required placeholder="e.g. AST-2026-001" />
                                <x-input-error :messages="$errors->get('asset_tag')" class="mt-2" />
                            </div>

                            <!-- Asset Name -->
                            <div>
                                <x-input-label for="name" :value="__('Item Name / Title *')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="e.g. Dell Optiplex Desktop" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="asset_category_id" :value="__('Asset Category *')" />
                                <select id="asset_category_id" name="asset_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('asset_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} {{ isset($category->type) ? '('.strtoupper($category->type).')' : '' }}
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
                                            {{ $branch->name }} {{ isset($branch->code) ? '('.$branch->code.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                            </div>

                            <!-- Assigned User -->
                            <div>
                                <x-input-label for="assigned_user_id" :value="__('Assigned User (Optional)')" />
                                <select id="assigned_user_id" name="assigned_user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Unassigned (Branch Property)</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assigned_user_id')" class="mt-2" />
                            </div>

                            <!-- Vendor -->
                            <div>
                                <x-input-label for="vendor_id" :value="__('Vendor / Supplier (Optional)')" />
                                <select id="vendor_id" name="vendor_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('vendor_id')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('Brand')" />
                                <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand')" placeholder="e.g. Dell, HP, Mikrotik" />
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model')" placeholder="e.g. OptiPlex 3080" />
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
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
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                                    <option value="in_repair" {{ old('status') == 'in_repair' ? 'selected' : '' }}>In Repair</option>
                                    <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                    <option value="scrapped" {{ old('status') == 'scrapped' ? 'selected' : '' }}>Scrapped</option>
                                    <option value="disposed" {{ old('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                                <x-text-input id="purchase_date" class="block mt-1 w-full" type="date" name="purchase_date" :value="old('purchase_date')" />
                                <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                            </div>

                            <!-- Warranty Duration (Months) -->
                            <div>
                                <x-input-label for="warranty_months" :value="__('Warranty Duration (Months)')" />
                                <x-text-input id="warranty_months" class="block mt-1 w-full" type="number" name="warranty_months" :value="old('warranty_months')" placeholder="e.g. 12 or 36" />
                                <x-input-error :messages="$errors->get('warranty_months')" class="mt-2" />
                            </div>

                            <!-- Purchase Cost -->
                            <div class="md:col-span-2">
                                <x-input-label for="purchase_cost" :value="__('Purchase Cost (BDT)')" />
                                <x-text-input id="purchase_cost" class="block mt-1 w-full" type="number" step="0.01" name="purchase_cost" :value="old('purchase_cost')" placeholder="0.00" />
                                <x-input-error :messages="$errors->get('purchase_cost')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Additional Notes')" />
                                <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="অতিরিক্ত বিবরণ বা মন্তব্য...">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
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