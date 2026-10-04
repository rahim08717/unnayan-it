<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                    {{ __('Daily Working Reports') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">দৈনন্দিন কাজের বিবরণী ও রেকর্ড সম্পর্কিত তথ্য</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('daily-reports.history') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs rounded-xl shadow-md transition-all duration-200">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    ব্রাঞ্চ ও ডিভাইস হিস্টোরি
                </a>
                <a href="{{ route('daily-reports.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md shadow-indigo-600/30 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    নতুন রিপোর্ট লিখুন
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Card -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
            <form method="GET" action="{{ route('daily-reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">তারিখ অনুযায়ী ফিল্টার</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ব্রাঞ্চ অনুযায়ী ফিল্টার</label>
                    <select name="branch_id" class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">সকল ব্রাঞ্চ</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl transition-all">
                        ফিল্টার করুন
                    </button>
                    <a href="{{ route('daily-reports.index') }}" class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-xs rounded-xl transition-all">
                        রিসেট
                    </a>
                </div>
            </form>
        </div>

        <!-- Reports List -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="divide-y divide-slate-100">
                @forelse($reports as $report)
                    <div class="p-6 hover:bg-slate-50/80 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-bold text-xs rounded-full border border-indigo-100">
                                    {{ \Carbon\Carbon::parse($report->report_date)->format('d M, Y') }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">
                                    এন্ট্রি করেছেন: <strong class="text-slate-700">{{ $report->user->name }}</strong>
                                </span>
                                <span class="text-xs text-emerald-600 bg-emerald-50 font-bold px-2.5 py-0.5 rounded-full">
                                    মোট সময়: {{ $report->total_duration }}
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-2 pt-1">
                                @foreach($report->workEntries as $entry)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                                        {{ $entry->title }}
                                        @if($entry->branch)
                                            <span class="text-indigo-600">({{ $entry->branch->name }})</span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('daily-reports.show', $report->id) }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-all">
                                বিস্তারিত দেখুন
                            </a>
                            <a href="{{ route('daily-reports.print', $report->id) }}" target="_blank" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl transition-all flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                PDF / প্রিন্ট
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="font-bold text-slate-600">কোনো ডেইলি ওয়ার্কিং রিপোর্ট পাওয়া যায়নি</p>
                    </div>
                @endforelse
            </div>
            
            <div class="p-4 bg-slate-50 border-t border-slate-100">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-app-layout>