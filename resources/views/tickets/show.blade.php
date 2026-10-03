<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ticket Details: ') }} {{ $ticket->ticket_number }}
            </h2>
            <a href="{{ route('tickets.edit', $ticket) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-xs uppercase font-semibold">
                Edit Status / Resolution
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Ticket Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="border-b pb-4 mb-4 flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $ticket->subject }}</h1>
                        <p class="text-xs text-gray-500 mt-1">
                            Submitted by <span class="font-semibold text-gray-700">{{ $ticket->user->name }}</span> |
                            Branch: <span class="font-semibold text-gray-700">{{ $ticket->branch->name }}</span> |
                            Date: {{ $ticket->created_at->format('d M, Y h:i A') }}
                        </p>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        @if($ticket->status == 'open')
                            <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Open</span>
                        @elseif($ticket->status == 'in_progress')
                            <span class="px-3 py-1 text-xs font-semibold text-indigo-800 bg-indigo-100 rounded-full">In Progress</span>
                        @elseif($ticket->status == 'resolved')
                            <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Resolved</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">Closed</span>
                        @endif

                        <span class="text-xs font-bold text-gray-500 uppercase">Priority: {{ $ticket->priority }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-bold text-gray-700 text-sm mb-1">Problem Description:</h3>
                    <div class="bg-gray-50 p-4 rounded-md text-gray-800 text-sm whitespace-pre-line">{{ $ticket->description }}</div>
                </div>

                @if($ticket->asset)
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md text-sm text-blue-900">
                        <span class="font-bold">Linked IT Asset:</span> {{ $ticket->asset->name }} (Tag: <strong>{{ $ticket->asset->asset_tag }}</strong>)
                    </div>
                @endif

                @if($ticket->resolution_notes)
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
                        <h3 class="font-bold text-green-800 text-sm mb-1">Resolution Notes:</h3>
                        <p class="text-green-900 text-sm whitespace-pre-line">{{ $ticket->resolution_notes }}</p>
                        @if($ticket->resolved_at)
                            <p class="text-xs text-green-600 mt-2">Resolved Date: {{ $ticket->resolved_at->format('d M, Y h:i A') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Comment / Discussion Thread -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Discussion & Comments ({{ $ticket->comments->count() }})</h3>

                <div class="space-y-4 mb-6">
                    @forelse($ticket->comments as $comment)
                        <div class="p-4 rounded-lg bg-gray-50 border border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-sm text-indigo-700">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $comment->comment }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm italic">এখনও কোনো কমেন্ট বা আপডেট যোগ করা হয়নি।</p>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST" class="border-t pt-4">
                    @csrf
                    <x-input-label for="comment" :value="__('Add a Response / Update Comment')" />
                    <textarea id="comment" name="comment" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required placeholder="আপডেট বা মন্তব্য লিখুন..."></textarea>
                    
                    <div class="mt-3 flex justify-end">
                        <x-primary-button>Post Comment</x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>