<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                    {{ __('ডেইলি ওয়ার্কিং রিপোর্ট বিবরণী') }}
                </h2>
                <p class="text-sm text-slate-500 mt-0.5">তারিখ: {{ \Carbon\Carbon::parse($report->report_date)->format('d F, Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('daily-reports.print', $report->id) }}" target="_blank" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    PDF তৈরি / প্রিন্ট করুন
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Summary Box -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">রিপোর্ট প্রদানকারী</p>
                <p class="text-base font-bold text-slate-800">{{ $report->user->name }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">মোট কাজের সময়</p>
                <p class="text-base font-bold text-emerald-600">{{ $report->total_duration }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase">মোট কাজের সংখ্যা</p>
                <p class="text-base font-bold text-indigo-600">{{ $report->workEntries->count() }} টি</p>
            </div>
        </div>

        <!-- Work Entries Details -->
        <div class="space-y-4">
            @foreach($report->workEntries as $index => $entry)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-3">
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-md">
                                {{ $entry->category }}
                            </span>
                            <h3 class="text-lg font-bold text-slate-800">{{ $index + 1 }}. {{ $entry->title }}</h3>
                        </div>
                        <span class="text-xs font-extrabold text-slate-600 bg-slate-100 px-3 py-1 rounded-full shrink-0">
                            সময়: {{ $entry->duration_minutes }} মিনিট
                        </span>
                    </div>

                    @if($entry->branch || $entry->asset)
                        <div class="flex flex-wrap gap-3 pt-1 text-xs">
                            @if($entry->branch)
                                <span class="text-slate-600">
                                    <strong>ব্রাঞ্চ:</strong> <span class="text-indigo-600 font-semibold">{{ $entry->branch->name }}</span>
                                </span>
                            @endif
                            @if($entry->asset)
                                <span class="text-slate-600">
                                    <strong>ডিভাইস:</strong> <span class="text-indigo-600 font-semibold">{{ $entry->asset->name }}</span>
                                </span>
                            @endif
                        </div>
                    @endif

                    @if($entry->description)
                        <p class="text-sm text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            {{ $entry->description }}
                        </p>
                    @endif

                    <!-- Attachments -->
                    @if($entry->attachments->count() > 0)
                        <div class="pt-3 border-t border-slate-100">
                            <p class="text-xs font-bold text-slate-500 uppercase mb-2">সংযুক্ত ছবি/ভিডিও/ফাইলসমূহ:</p>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach($entry->attachments as $attachment)
                                    @if($attachment->file_type === 'image')
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="block group relative rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                            <img src="{{ asset('storage/' . $attachment->file_path) }}" class="w-full h-28 object-cover group-hover:scale-105 transition-transform duration-200">
                                        </a>
                                    @elseif($attachment->file_type === 'video')
                                        <video controls class="w-full h-28 object-cover rounded-xl border border-slate-200">
                                            <source src="{{ asset('storage/' . $attachment->file_path) }}">
                                        </video>
                                    @else
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="p-3 bg-slate-100 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-200 transition-colors flex items-center justify-center text-center">
                                            📄 {{ $attachment->original_name }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>