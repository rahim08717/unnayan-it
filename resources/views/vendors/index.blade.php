<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IT Vendors & Service Suppliers Directory') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Add Vendor Form -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-md font-bold text-gray-800 mb-4">Register New Vendor</h3>
                    <form action="{{ route('vendors.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="company_name" :value="__('Company Name')" />
                            <x-text-input id="company_name" name="company_name" type="text" class="block mt-1 w-full" required placeholder="e.g. Flora Limited" />
                        </div>
                        <div>
                            <x-input-label for="contact_person" :value="__('Contact Person Name')" />
                            <x-text-input id="contact_person" name="contact_person" type="text" class="block mt-1 w-full" placeholder="e.g. Md. Rahim" />
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" name="phone" type="text" class="block mt-1 w-full" required />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="service_type" :value="__('Service/Product Type')" />
                            <x-text-input id="service_type" name="service_type" type="text" class="block mt-1 w-full" placeholder="e.g. Laptop Supplier, Internet Service" />
                        </div>
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"></textarea>
                        </div>
                        <x-primary-button class="w-full justify-center bg-indigo-700 hover:bg-indigo-800">Register Vendor</x-primary-button>
                    </form>
                </div>

                <!-- Vendors List Table -->
                <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                    <h3 class="text-md font-bold text-gray-800 mb-4">Vendor Directory</h3>
                    <table class="w-full text-left text-sm text-gray-600 border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3">Company</th>
                                <th class="p-3">Contact Person</th>
                                <th class="p-3">Phone / Email</th>
                                <th class="p-3">Type</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $vendor)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-bold text-gray-800">{{ $vendor->company_name }}</td>
                                    <td class="p-3">{{ $vendor->contact_person ?? 'N/A' }}</td>
                                    <td class="p-3">
                                        {{ $vendor->phone }}<br>
                                        <span class="text-xs text-gray-400">{{ $vendor->email }}</span>
                                    </td>
                                    <td class="p-3"><span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $vendor->service_type ?? 'General' }}</span></td>
                                    <td class="p-3 text-right">
                                        <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" onsubmit="return confirm('Remove vendor?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-400">No vendors registered.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $vendors->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>