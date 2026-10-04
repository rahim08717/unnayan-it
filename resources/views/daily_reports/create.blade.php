<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
            {{ __('নতুন ডেইলি ওয়ার্কিং রিপোর্ট যোগ করুন') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto" x-data="reportForm()">
        <form action="{{ route('daily-reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- General Info -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">তারিখ *</label>
                    <input type="date" name="report_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">অতিরিক্ত নোট (ঐচ্ছিক)</label>
                    <input type="text" name="notes" placeholder="যেমন: আজকের বিশেষ কোনো কাজ..." class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Work Entries Dynamic List -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">কাজের বিবরণ সমূহের তালিকা</h3>
                    <button type="button" @click="addEntry()" class="px-3.5 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-bold text-xs rounded-xl transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        আরও একটি কাজ যোগ করুন
                    </button>
                </div>

                <template x-for="(entry, index) in entries" :key="index">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-4 relative">
                        <button type="button" @click="removeEntry(index)" x-show="entries.length > 1" class="absolute top-4 right-4 text-rose-500 hover:text-rose-700 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কাজের নাম/বিষয় *</label>
                                <input type="text" :name="`entries[${index}][title]`" x-model="entry.title" placeholder="যেমন: MS Office 2007 আনইনস্টল করে MS 365 সেটআপ" required class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কাজের ক্যাটাগরি *</label>
                                <select :name="`entries[${index}][category]`" x-model="entry.category" required class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500">
                                    <option value="Software">Software Support</option>
                                    <option value="Hardware">Hardware Repair</option>
                                    <option value="Network">Network & Internet</option>
                                    <option value="Social Media">Facebook & Social Media</option>
                                    <option value="Maintenance">General Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কত সময় লেগেছে (মিনিটে) *</label>
                                <input type="number" :name="`entries[${index}][duration_minutes]`" x-model="entry.duration_minutes" placeholder="যেমন: 45" min="1" required class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সংক্রান্ত ব্রাঞ্চ (ঐচ্ছিক)</label>
                                <select :name="`entries[${index}][branch_id]`" x-model="entry.branch_id" class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500">
                                    <option value="">কোনো নির্দিষ্ট ব্রাঞ্চ নেই</option>
                                    <template x-for="branch in branches" :key="branch.id">
                                        <option :value="branch.id" x-text="branch.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সংক্রান্ত ডিভাইস/Asset (ঐচ্ছিক)</label>
                                <select :name="`entries[${index}][asset_id]`" x-model="entry.asset_id" class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500">
                                    <option value="">কোনো নির্দিষ্ট ডিভাইস নেই</option>
                                    <template x-for="asset in assets" :key="asset.id">
                                        <option :value="asset.id" x-text="asset.name + (asset.asset_code ? ' (' + asset.asset_code + ')' : '')"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কাজের বিস্তারিত বর্ণনা</label>
                            <textarea :name="`entries[${index}][description]`" x-model="entry.description" rows="2" placeholder="কাজের বিস্তারিত বিবরণ লিখুন..." class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">প্রমাণ/সংযুক্ত ফাইল (ছবি, ভিডিও, বা PDF)</label>
                            <input type="file" :name="`entries[${index}][attachments][]`" multiple class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </template>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all">
                    রিপোর্ট জমা দিন
                </button>
            </div>
        </form>
    </div>

    <script>
        function reportForm() {
            return {
                branches: @json($branches),
                assets: @json($assets),
                entries: [
                    { title: '', category: 'Software', duration_minutes: 30, branch_id: '', asset_id: '', description: '' }
                ],
                addEntry() {
                    this.entries.push({ title: '', category: 'Software', duration_minutes: 30, branch_id: '', asset_id: '', description: '' });
                },
                removeEntry(index) {
                    this.entries.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>