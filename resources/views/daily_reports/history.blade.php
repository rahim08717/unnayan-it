<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
            {{ __('ব্রাঞ্চ ও ডিভাইস ভিত্তিক কাজের ইতিহাস (History)') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">পূর্বে কোন ব্রাঞ্চে বা পিসিতে কী কী সমস্যা সমাধান করা হয়েছে তার সম্পূর্ণ রেকর্ড</p>
    </x-slot>

    <div class="space-y-6">
        <!-- Filter Form -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
            <form method="GET" action="{{ route('daily-reports.history') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ব্রাঞ্চ পছন্দ করুন</label>
                    <select name="branch_id" class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500">
                        <option value="">সকল ব্রাঞ্চ</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ডিভাইস / Asset পছন্দ করুন</label>
                    <select name="asset_id" class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500">
                        <option value="">সকল ডিভাইস</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ request('asset_id') == $asset->id ? 'selected' : '' }}>{{ $asset->name }} ({{ $asset->asset_code ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl transition-all">
                        হিস্টোরি খুঁজুন
                    </button>
                    <a href="{{ route('daily-reports.history') }}" class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-xs rounded-xl transition-all">
                        রিসেট
                    </a>
                </div>
            </form>
        </div>

        <!-- Timeline History List -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
            <div class="relative border-l-2 border-indigo-200 ml-4 space-y-6">
                @forelse($historyEntries as $entry)
                    <div class="relative pl-6 group">
                        <!-- Bullet Icon -->
                        <div class="absolute -left-2.5 top-1.5 w-5 h-5 rounded-full bg-indigo-600 border-4 border-white shadow"></div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="text-xs font-extrabold text-indigo-600">
                                    {{ \Carbon\Carbon::parse($entry->dailyReport->report_date)->format('d F, Y') }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">
                                    সময় লেগেছে: <strong>{{ $entry->duration_minutes }} মিনিট</strong>
                                </span>
                            </div>

                            <h4 class="font-bold text-slate-800 text-base">{{ $entry->title }}</h4>

                            <div class="flex flex-wrap gap-2 text-xs">
                                @if($entry->branch)
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-bold rounded-lg">
                                        📍 ব্রাঞ্চ: {{ $entry->branch->name }}
                                    </span>
                                @endif
                                @if($entry->asset)
                                    <span class="px-2.5 py-1 bg-sky-50 text-sky-700 font-bold rounded-lg">
                                        💻 ডিভাইস: {{ $entry->asset->name }}
                                    </span>
                                @endif
                            </div>

                            @if($entry->description)
                                <p class="text-xs text-slate-600 pt-1">{{ $entry->description }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-500 font-bold py-8">কোনো কাজের রেকর্ড পাওয়া যায়নি</p>
                @endforelse
            </div>

            <div class="pt-4">
                {{ $historyEntries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>