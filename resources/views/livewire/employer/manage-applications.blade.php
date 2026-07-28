<div class="bg-[#faf9f6] min-h-[calc(100vh-200px)] py-12">
    <div class="container mx-auto px-6 lg:px-12">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <a href="{{ route('dashboard') }}" wire:navigate class="text-gray-500 hover:text-gray-900 flex items-center text-sm mb-4 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    ড্যাশবোর্ডে ফিরে যান
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">আবেদনকারী (Applicants)</h1>
                <p class="text-gray-600">শিফট: <span class="font-bold text-gray-900">{{ $shift->title }}</span></p>
            </div>
            
            <div class="mt-4 md:mt-0 px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-semibold border border-yellow-200">
                মোট আবেদন: {{ $applications->count() }}
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($applications->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($applications as $application)
                    <div class="bg-white rounded-2xl p-6 border {{ $application->status === 'hired' ? 'border-green-300 shadow-green-100/50' : ($application->status === 'rejected' ? 'border-red-200 bg-red-50/30' : 'border-gray-100') }} shadow-sm relative overflow-hidden transition-all duration-300">
                        
                        <!-- Status Badge -->
                        <div class="absolute top-5 right-5">
                            @if($application->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-[10px] font-bold uppercase tracking-wider rounded-full">Pending</span>
                            @elseif($application->status === 'hired')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-[10px] font-bold uppercase tracking-wider rounded-full flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Hired
                                </span>
                            @elseif($application->status === 'completed')
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-[10px] font-bold uppercase tracking-wider rounded-full flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Completed
                                </span>
                            @elseif($application->status === 'rejected')
                                <span class="px-3 py-1 bg-red-100 text-red-800 text-[10px] font-bold uppercase tracking-wider rounded-full">Rejected</span>
                            @elseif($application->status === 'absent')
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-[10px] font-bold uppercase tracking-wider rounded-full">Absent</span>
                            @endif
                        </div>

                        <!-- Applicant Info -->
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-bold text-xl mr-4 uppercase shrink-0">
                                {{ substr($application->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">{{ $application->user->name }}</h3>
                                <p class="text-xs text-gray-500">আবেদন করেছেন: {{ $application->created_at->format('d M, Y - h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Application Message -->
                        @if($application->message)
                            <div class="mb-6 bg-gray-50 p-4 rounded-xl text-sm text-gray-700 italic border border-gray-100">
                                "{{ $application->message }}"
                            </div>
                        @endif

                        <!-- Contact Details (Only visible if hired/completed/absent) -->
                        @if(in_array($application->status, ['hired', 'completed', 'absent']))
                            <div class="mb-6 p-4 bg-green-50 rounded-xl border border-green-100">
                                <h4 class="text-xs font-bold text-green-800 uppercase tracking-wider mb-2">যোগাযোগের তথ্য</h4>
                                <div class="space-y-2 text-sm text-green-900">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        {{ $application->user->email }}
                                    </div>
                                    @if($application->user->phone)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $application->user->phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        @if($application->status === 'pending')
                            <div class="flex items-center space-x-3 pt-4 border-t border-gray-100">
                                <button wire:click="hire({{ $application->id }})" wire:confirm="Are you sure you want to hire {{ $application->user->name }}?" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-xl text-sm transition-colors flex justify-center items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Hire
                                </button>
                                <button wire:click="reject({{ $application->id }})" wire:confirm="Are you sure you want to reject {{ $application->user->name }}?" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2 rounded-xl text-sm transition-colors border border-red-200">
                                    Reject
                                </button>
                            </div>
                        @elseif($application->status === 'hired')
                            <div class="pt-4 border-t border-gray-100">
                                @if($completingApplicationId === $application->id)
                                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mb-2">
                                        <label class="block text-sm font-medium text-blue-900 mb-2">আয়ের পরিমাণ (Earnings BDT)</label>
                                        <div class="flex space-x-2">
                                            <input type="number" wire:model="earningsAmount" class="flex-1 bg-white border border-blue-200 text-blue-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2" placeholder="e.g. 500">
                                            <button wire:click="markCompleted" class="bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded-lg text-sm transition-colors">
                                                Confirm
                                            </button>
                                            <button wire:click="cancelCompleting" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold px-4 py-2 rounded-lg text-sm transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                        @error('earningsAmount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                @else
                                    <div class="flex items-center space-x-3">
                                        <button wire:click="startCompleting({{ $application->id }})" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-xl text-sm transition-colors flex justify-center items-center">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Completed Job
                                        </button>
                                        <button wire:click="markAbsent({{ $application->id }})" wire:confirm="Are you sure you want to mark {{ $application->user->name }} as absent?" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 rounded-xl text-sm transition-colors border border-gray-300">
                                            Absent / No Show
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @elseif($application->status === 'completed')
                            <div class="pt-4 border-t border-gray-100">
                                <div class="bg-green-50 p-3 rounded-xl border border-green-100 text-center">
                                    <span class="text-sm text-green-800 font-bold">আয়: ৳{{ number_format($application->earnings, 2) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">কোনো আবেদন নেই</h3>
                <p class="text-gray-500 max-w-sm mx-auto">এখনও কেউ এই শিফটের জন্য আবেদন করেননি। কেউ আবেদন করলে এখানে দেখতে পাবেন।</p>
            </div>
        @endif

    </div>
</div>
