<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Support Ticket') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <!-- Global Error Messages Box -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <p class="font-bold mb-1">ফর্ম সাবমিট করা যাচ্ছে না, নিচের সমস্যাগুলো সমাধান করুন:</p>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Branch Selection (Visible to all or Admin) -->
                            <div class="md:col-span-2">
                                <x-input-label for="branch_id" :value="__('Select Branch *')" />
                                <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id', Auth::user()->branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }} ({{ $branch->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subject -->
                            <div class="md:col-span-2">
                                <x-input-label for="subject" :value="__('Problem Subject / Title *')" />
                                <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject" :value="old('subject')" required placeholder="e.g. Internet connectivity is slow / Printer not working" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category" :value="__('Category *')" />
                                <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>Hardware Issue</option>
                                    <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software / OS</option>
                                    <option value="network" {{ old('category') == 'network' ? 'selected' : '' }}>Network & Router</option>
                                    <option value="internet" {{ old('category') == 'internet' ? 'selected' : '' }}>Internet & Wifi</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other Problem</option>
                                </select>
                            </div>

                            <!-- Priority -->
                            <div>
                                <x-input-label for="priority" :value="__('Priority Level *')" />
                                <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>

                            <!-- Linked Asset -->
                            <div class="md:col-span-2">
                                <x-input-label for="asset_id" :value="__('Related Asset (Optional)')" />
                                <select id="asset_id" name="asset_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">No Specific Asset Linked</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                            {{ $asset->asset_tag }} - {{ $asset->name }} ({{ $asset->brand }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Detailed Problem Description *')" />
                                <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="সমস্যার বিস্তারিত বিবরণ লিখুন...">{{ old('description') }}</textarea>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('tickets.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            <x-primary-button class="w-full sm:w-auto">
                                {{ __('Submit Support Ticket') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>