<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dynamic Asset Categories Management') }}
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
                <!-- Create Category Form -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-md font-bold text-gray-800 mb-4">Add New Category</h3>
                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Category Name')" />
                            <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" required placeholder="e.g. Server, Projector" />
                        </div>
                        <div>
                            <x-input-label for="code" :value="__('Category Code (Prefix)')" />
                            <x-text-input id="code" name="code" type="text" class="block mt-1 w-full" placeholder="e.g. SVR, PRJ" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"></textarea>
                        </div>
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 text-sm text-gray-600">Active Category</span>
                        </div>
                        <x-primary-button class="w-full justify-center bg-indigo-700 hover:bg-indigo-800">Save Category</x-primary-button>
                    </form>
                </div>

                <!-- Category List Table -->
                <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                    <h3 class="text-md font-bold text-gray-800 mb-4">Categories List</h3>
                    <table class="w-full text-left text-sm text-gray-600 border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3">Code</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-bold text-indigo-600">{{ $cat->code ?? 'N/A' }}</td>
                                    <td class="p-3">{{ $cat->name }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $cat->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $cat->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete category?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $categories->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>