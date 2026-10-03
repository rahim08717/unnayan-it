<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('NGO Employee Directory') }}
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
                <!-- Register Employee Form -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-md font-bold text-gray-800 mb-4">Add Employee Profile</h3>
                    <form action="{{ route('employees.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="employee_id" :value="__('Employee ID')" />
                            <x-text-input id="employee_id" name="employee_id" type="text" class="block mt-1 w-full" required placeholder="e.g. EMP-1001" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" required />
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <x-input-label for="designation" :value="__('Designation')" />
                                <x-text-input id="designation" name="designation" type="text" class="block mt-1 w-full" required />
                            </div>
                            <div>
                                <x-input-label for="department" :value="__('Department')" />
                                <x-text-input id="department" name="department" type="text" class="block mt-1 w-full" required />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="branch_id" :value="__('Branch')" />
                            <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
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
                        <x-primary-button class="w-full justify-center bg-indigo-700 hover:bg-indigo-800">Save Employee</x-primary-button>
                    </form>
                </div>

                <!-- Employee Directory Table -->
                <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-md font-bold text-gray-800">Employee List</h3>
                        <form method="GET" action="{{ route('employees.index') }}" class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID or Name..." class="border-gray-300 rounded text-xs py-1 px-2">
                            <button type="submit" class="bg-gray-800 text-white px-3 py-1 text-xs rounded">Search</button>
                        </form>
                    </div>

                    <table class="w-full text-left text-sm text-gray-600 border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3">EMP ID</th>
                                <th class="p-3">Name & Designation</th>
                                <th class="p-3">Branch & Dept</th>
                                <th class="p-3">Phone</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $emp)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-bold text-indigo-600">{{ $emp->employee_id }}</td>
                                    <td class="p-3">
                                        <span class="font-bold text-gray-800">{{ $emp->name }}</span><br>
                                        <span class="text-xs text-gray-500">{{ $emp->designation }}</span>
                                    </td>
                                    <td class="p-3">
                                        {{ $emp->branch->name }}<br>
                                        <span class="text-xs text-gray-500">{{ $emp->department }}</span>
                                    </td>
                                    <td class="p-3">{{ $emp->phone }}</td>
                                    <td class="p-3 text-right">
                                        <form action="{{ route('employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Remove employee?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-400">No employee record found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $employees->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>