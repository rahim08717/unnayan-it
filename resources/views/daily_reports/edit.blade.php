<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daily Report Entry — ') }} {{ $dailyReport->report_date->format('d M, Y') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('daily-reports.show', $dailyReport) }}" class="px-3 py-1.5 bg-gray-200 text-gray-800 text-xs font-semibold rounded">
                    Preview Report
                </a>
                @if($dailyReport->status === 'draft')
                    <form action="{{ route('daily-reports.submit', $dailyReport) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ডেইলি রিপোর্ট জমা দিতে চান?');">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded shadow">
                            ✓ Submit Final Report
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add New Work Entry Form -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-md font-bold text-gray-800 border-b pb-3 mb-4">+ Add Work Entry for Today</h3>
                <form action="{{ route('daily-reports.entries.store', $dailyReport) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <x-input-label for="title" :value="__('Work Title *')" />
                            <x-text-input id="title" name="title" type="text" class="block mt-1 w-full text-sm" placeholder="e.g. Printer Problem Solved at Mirpur Branch" required />
                        </div>
                        <div>
                            <x-input-label for="work_category_id" :value="__('Work Category *')" />
                            <select id="work_category_id" name="work_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 rounded-md text-sm" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="branch_id" :value="__('Related Branch')" />
                            <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 rounded-md text-sm">
                                <option value="">General / Head Office</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="asset_id" :value="__('Related Asset')" />
                            <select id="asset_id" name="asset_id" class="block mt-1 w-full border-gray-300 rounded-md text-sm">
                                <option value="">None / Select Asset</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->asset_tag }} - {{ $asset->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="ticket_id" :value="__('Related Ticket')" />
                            <select id="ticket_id" name="ticket_id" class="block mt-1 w-full border-gray-300 rounded-md text-sm">
                                <option value="">None / Select Ticket</option>
                                @foreach($tickets as $ticket)
                                    <option value="{{ $ticket->id }}">{{ $ticket->ticket_number }} - {{ $ticket->subject }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="employee_id" :value="__('Related Employee')" />
                            <select id="employee_id" name="employee_id" class="block mt-1 w-full border-gray-300 rounded-md text-sm">
                                <option value="">None / Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->employee_id }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="start_time" :value="__('Start Time')" />
                            <x-text-input id="start_time" name="start_time" type="time" class="block mt-1 w-full text-sm" />
                        </div>
                        <div>
                            <x-input-label for="end_time" :value="__('End Time')" />
                            <x-text-input id="end_time" name="end_time" type="time" class="block mt-1 w-full text-sm" />
                        </div>
                        <div>
                            <x-input-label for="priority" :value="__('Priority')" />
                            <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 rounded-md text-sm">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 rounded-md text-sm">
                                <option value="completed" selected>Completed</option>
                                <option value="in_progress">In Progress</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="problem" :value="__('Problem / Issue Description')" />
                            <textarea id="problem" name="problem" rows="2" class="block mt-1 w-full border-gray-300 rounded-md text-sm" placeholder="সমস্যা কি ছিল..."></textarea>
                        </div>
                        <div>
                            <x-input-label for="action_taken" :value="__('Action Taken / Solution')" />
                            <textarea id="action_taken" name="action_taken" rows="2" class="block mt-1 w-full border-gray-300 rounded-md text-sm" placeholder="কি পদক্ষেপ নেওয়া হয়েছে..."></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="attachments" :value="__('Upload Evidence / Photos / Videos / Docs')" />
                            <input id="attachments" name="attachments[]" type="file" multiple class="block mt-1 w-full text-xs text-gray-500 border border-gray-300 rounded-md p-1" />
                        </div>
                        <div>
                            <x-input-label for="attachment_type" :value="__('Evidence Type')" />
                            <select id="attachment_type" name="attachment_type" class="block mt-1 w-full border-gray-300 rounded-md text-sm">
                                <option value="general">General Attachment</option>
                                <option value="before">Before Work Photo</option>
                                <option value="after">After Work Photo</option>
                                <option value="problem">Problem Evidence</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-primary-button>
                            {{ __('+ Add Work Entry') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- List of Added Work Entries -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-md font-bold text-gray-800 mb-4">Added Work Entries ({{ $dailyReport->workEntries->count() }})</h3>
                <div class="space-y-4">
                    @forelse($dailyReport->workEntries as $index => $entry)
                        <div class="p-4 border rounded-lg bg-gray-50 flex justify-between items-start gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-indigo-600">#{{ $index + 1 }}</span>
                                    <h4 class="font-bold text-gray-900">{{ $entry->title }}</h4>
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800 font-semibold">{{ $entry->category->name ?? 'N/A' }}</span>
                                    <span class="text-xs text-gray-500">({{ $entry->formatted_duration }})</span>
                                </div>
                                <p class="text-xs text-gray-600">
                                    <strong>Branch:</strong> {{ $entry->branch->name ?? 'Head Office' }} |
                                    <strong>Problem:</strong> {{ $entry->problem ?? 'N/A' }} |
                                    <strong>Action:</strong> {{ $entry->action_taken ?? 'N/A' }}
                                </p>
                            </div>
                            <form action="{{ route('work-entries.destroy', $entry) }}" method="POST" onsubmit="return confirm('এই এন্ট্রিটি ডিলিট করতে চান?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded hover:bg-red-200">Delete</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 text-center py-4">এখনো কোনো কাজের এন্ট্রি যুক্ত করা হয়নি। উপরের ফর্ম পূরণ করে কাজের তথ্য যুক্ত করুন।</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>