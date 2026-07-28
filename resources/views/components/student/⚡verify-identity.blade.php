<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\UserVerification;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithFileUploads;

    public $document_type = 'student_id';
    public $front_image;
    public $back_image;

    public function mount()
    {
        $user = Auth::user();
        // If already pending or approved, redirect to dashboard
        if ($user->verification && $user->verification->status !== 'rejected') {
            return redirect()->route('dashboard');
        }
    }

    public function submit()
    {
        $rules = [
            'document_type' => 'required|in:nid,student_id',
            'front_image' => 'required|image|max:5120', // 5MB Max
        ];

        if ($this->document_type === 'nid') {
            $rules['back_image'] = 'required|image|max:5120';
        }

        $this->validate($rules);

        $frontPath = $this->front_image->store('verifications', 'public');
        $backPath = $this->document_type === 'nid' && $this->back_image ? $this->back_image->store('verifications', 'public') : null;

        UserVerification::create([
            'user_id' => Auth::id(),
            'document_type' => $this->document_type,
            'front_image' => $frontPath,
            'back_image' => $backPath,
            'status' => 'pending',
        ]);

        session()->flash('success', 'আপনার ভেরিফিকেশন রিকোয়েস্ট সফলভাবে জমা হয়েছে। রিভিউয়ের জন্য অপেক্ষা করুন।');
        return redirect()->route('dashboard');
    }
};
?>

<div>
    <div class="bg-[#faf9f6] min-h-[calc(100vh-200px)] py-12">
        <div class="container mx-auto px-6 lg:px-12 max-w-3xl">
            
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-800 flex items-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    ড্যাশবোর্ডে ফিরে যান
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-black text-white p-10 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500 rounded-full mix-blend-screen filter blur-[40px] opacity-30"></div>
                    <div class="relative z-10 flex items-center">
                        <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mr-5 border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold mb-1">একাউন্ট ভেরিফিকেশন</h2>
                            <p class="text-gray-300">ন্যাশনাল আইডি অথবা স্টুডেন্ট আইডি দিয়ে আপনার পরিচয় নিশ্চিত করুন।</p>
                        </div>
                    </div>
                </div>

                <div class="p-10">
                    @if(auth()->user()->verification && auth()->user()->verification->status === 'rejected')
                        <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 shrink-0 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h4 class="font-bold">আপনার আগের রিকোয়েস্টটি বাতিল করা হয়েছে!</h4>
                                <p class="text-sm mt-1">অনুগ্রহ করে সঠিক এবং স্পষ্ট ছবি দিয়ে পুনরায় আবেদন করুন।</p>
                            </div>
                        </div>
                    @endif

                    <form wire:submit="submit" class="space-y-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">ডকুমেন্টের ধরন <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model.live="document_type" value="student_id" class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50 flex flex-col items-center justify-center text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                        <span class="font-bold text-gray-900">Student ID</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model.live="document_type" value="nid" class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 hover:bg-gray-50 flex flex-col items-center justify-center text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <span class="font-bold text-gray-900">National ID (NID)</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label class="block text-sm font-medium text-gray-700 mb-2">সামনের দিকের ছবি (Front Side) <span class="text-red-500">*</span></label>
                            <input type="file" wire:model="front_image" accept="image/*" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5 transition-colors">
                            <p class="text-xs text-gray-500 mt-2">Max size 5MB. Please upload a clear photo.</p>
                            @error('front_image') <span class="mt-1 text-sm text-red-600 block">{{ $message }}</span> @enderror
                            
                            @if ($front_image)
                                <div class="mt-4 border rounded-xl overflow-hidden inline-block relative">
                                    <img src="{{ $front_image->temporaryUrl() }}" class="h-32 object-cover">
                                </div>
                            @endif
                        </div>

                        @if($document_type === 'nid')
                        <div class="pt-4 border-t border-gray-100">
                            <label class="block text-sm font-medium text-gray-700 mb-2">পেছনের দিকের ছবি (Back Side) <span class="text-red-500">*</span></label>
                            <input type="file" wire:model="back_image" accept="image/*" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5 transition-colors">
                            <p class="text-xs text-gray-500 mt-2">Max size 5MB. Please upload a clear photo.</p>
                            @error('back_image') <span class="mt-1 text-sm text-red-600 block">{{ $message }}</span> @enderror

                            @if ($back_image)
                                <div class="mt-4 border rounded-xl overflow-hidden inline-block relative">
                                    <img src="{{ $back_image->temporaryUrl() }}" class="h-32 object-cover">
                                </div>
                            @endif
                        </div>
                        @endif

                        <div class="pt-6 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm px-8 py-4 transition-all shadow-lg flex items-center" wire:loading.attr="disabled">
                                <span wire:loading.remove class="flex items-center">
                                    সাবমিট করুন
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                                <span wire:loading>সাবমিট হচ্ছে...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>