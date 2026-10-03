<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Branch List') }}
            </h2>
            <a href="{{ route('branches.create') }}" class="w-full sm:w-auto text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150">
                + Add New Branch
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <!-- Mobile-Responsive Table Wrapper -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Code</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Branch Name</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Region</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Phone</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Users</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($branches as $branch)
                                    <tr>
                                        <td class="px-4 py-3 font-bold text-indigo-600 whitespace-nowrap">{{ $branch->code }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $branch->name }}</td>
                                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $branch->region ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $branch->phone ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-gray-600 whitespace-nowrap">{{ $branch->users_count }}</td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            @if($branch->is_active)
                                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('branches.edit', $branch) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs bg-indigo-50 px-2 py-1 rounded">Edit</a>
                                                <form action="{{ route('branches.destroy', $branch) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ব্র্যাঞ্চটি মুছে ফেলতে চান?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs bg-red-50 px-2 py-1 rounded">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">কোনো ব্র্যাঞ্চ পাওয়া যায়নি। নতুন ব্র্যাঞ্চ যুক্ত করতে ওপরের বাটন চাপুন।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $branches->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>