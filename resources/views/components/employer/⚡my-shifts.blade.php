<?php

use Livewire\Component;
use App\Models\Job;

new class extends Component
{
    public function with(): array
    {
        return [
            'myShifts' => Job::withCount('applications')
                ->where('user_id', auth()->id())
                ->latest()
                ->get()
        ];
    }

    public function toggleStatus($jobId)
    {
        $job = Job::where('id', $jobId)->where('user_id', auth()->id())->first();
        if ($job) {
            $job->status = $job->status === 'OPEN' ? 'CLOSED' : 'OPEN';
            $job->save();
        }
    }
};
?>

<div>
    <div class="mb-12 mt-10">
        <div class="flex items-center gap-3 mb-8">
            <div class="p-2.5 bg-yellow-50 dark:bg-yellow-500/10 rounded-xl text-yellow-600 dark:text-yellow-400 shrink-0 shadow-sm border border-yellow-100">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">আপনার পোস্টকৃত শিফটসমূহ</h2>
                <p class="text-sm text-gray-500">আপনার পোস্ট করা সকল জব শিফট পরিচালনা করুন</p>
            </div>
        </div>
        
        @if($myShifts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($myShifts as $shift)
                <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-[1.5rem] p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
                    <!-- Header: Badge & Status -->
                    <div class="flex justify-between items-start mb-4">
                        @if($shift->status == 'OPEN')
                            <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                {{ $shift->status }}
                            </div>
                        @else
                            <div class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-zinc-400 mr-2"></span>
                                {{ $shift->status }}
                            </div>
                        @endif
                        <div class="p-2 bg-gray-50 dark:bg-zinc-800 rounded-lg text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-5 line-clamp-2 leading-snug group-hover:text-yellow-600 transition-colors">{{ $shift->title }}</h3>
                    
                    <!-- Details -->
                    <div class="space-y-3.5 text-sm text-gray-600 dark:text-gray-400 mb-8 flex-grow">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="leading-relaxed font-medium">{{ $shift->location }}</span>
                        </div>
                        
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="leading-relaxed font-medium">
                                @if($shift->start_datetime && $shift->end_datetime)
                                    {{ \Carbon\Carbon::parse($shift->start_datetime)->format('M d, g:i A') }} <br> 
                                    <span class="text-xs text-gray-400 font-normal">to</span> {{ \Carbon\Carbon::parse($shift->end_datetime)->format('M d, g:i A') }}
                                @else
                                    {{ $shift->time }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex items-center pt-2">
                            <svg class="w-5 h-5 mr-3 shrink-0 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-black text-gray-900 dark:text-white text-lg">৳{{ number_format($shift->wage) }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-auto flex flex-col gap-3">
                        <div class="flex gap-3 w-full">
                            <a href="{{ route('employer.applications', $shift->id) }}" wire:navigate class="flex-1 flex items-center justify-center gap-2 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-500/10 dark:hover:bg-indigo-500/20 text-indigo-700 dark:text-indigo-400 font-bold py-3 rounded-xl transition-all duration-300 text-sm">
                                আবেদনকারী 
                                <span class="bg-indigo-600 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $shift->applications_count }}</span>
                            </a>
                            <a href="{{ route('employer.edit-shift', $shift->id) }}" wire:navigate class="flex-1 flex items-center justify-center gap-2 bg-gray-50 hover:bg-gray-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-gray-700 dark:text-gray-300 font-bold py-3 rounded-xl transition-all duration-300 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                এডিট
                            </a>
                        </div>
                        <button wire:click="toggleStatus({{ $shift->id }})" class="w-full flex items-center justify-center gap-2 {{ $shift->status == 'OPEN' ? 'bg-white hover:bg-red-50 text-red-600 border border-red-200' : 'bg-white hover:bg-emerald-50 text-emerald-600 border border-emerald-200' }} font-bold py-3 rounded-xl transition-all duration-300 text-sm shadow-sm">
                            @if($shift->status == 'OPEN')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                শিফট অফ করুন
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                শিফট অন করুন
                            @endif
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white dark:bg-zinc-900 rounded-3xl border border-dashed border-gray-300 dark:border-zinc-700 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">কোনো শিফট পাওয়া যায়নি</h3>
                <p class="text-gray-500">আপনি এখনও কোনো শিফট পোস্ট করেননি।</p>
                <a href="{{ route('employer.post-shift') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-black font-bold rounded-xl transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    নতুন শিফট পোস্ট করুন
                </a>
            </div>
        @endif
    </div>
</div>