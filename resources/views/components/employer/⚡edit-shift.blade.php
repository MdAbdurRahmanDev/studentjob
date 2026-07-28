<?php

use Livewire\Component;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public Job $shift;

    public string $title = '';
    public $category_id;
    public string $location = '';
    public $start_datetime;
    public $end_datetime;
    public string $wage = '';
    public string $description = '';
    public string $requirements = '';

    public function mount(Job $shift)
    {
        if ($shift->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $this->shift = $shift;
        $this->title = $shift->title;
        $this->category_id = $shift->category_id;
        $this->location = $shift->location;
        $this->start_datetime = $shift->start_datetime ? \Carbon\Carbon::parse($shift->start_datetime)->format('Y-m-d\TH:i') : null;
        $this->end_datetime = $shift->end_datetime ? \Carbon\Carbon::parse($shift->end_datetime)->format('Y-m-d\TH:i') : null;
        $this->wage = $shift->wage;
        $this->description = $shift->description;
        $this->requirements = $shift->requirements;
    }

    public function update()
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location' => ['required', 'string', 'max:255'],
            'start_datetime' => ['required', 'date'],
            'end_datetime' => ['required', 'date', 'after:start_datetime'],
            'wage' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
        ]);

        $this->shift->update($validated);

        session()->flash('success', 'আপনার শিফট সফলভাবে আপডেট করা হয়েছে!');
        
        return redirect()->route('dashboard');
    }
    
    public function with(): array
    {
        return [
            'categories' => \App\Models\Category::all()
        ];
    }
};
?>

<div>
    <div class="bg-[#faf9f6] min-h-[calc(100vh-200px)] py-12">
        <div class="container mx-auto px-6 lg:px-12 max-w-4xl">
            
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
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500 rounded-full mix-blend-screen filter blur-[40px] opacity-30"></div>
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold mb-2">শিফট এডিট করুন</h2>
                        <p class="text-gray-300">আপনার শিফটের তথ্য পরিবর্তন করে সেভ করুন।</p>
                    </div>
                </div>

                <div class="p-10">
                    <form wire:submit="update" class="space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">ক্যাটাগরি <span class="text-red-500">*</span></label>
                                <select wire:model="category_id" id="category_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                    <option value="">-- ক্যাটাগরি নির্বাচন করুন --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">কাজের শিরোনাম <span class="text-red-500">*</span></label>
                                <input wire:model="title" id="title" type="text" required placeholder="যেমন: ইভেন্ট ক্যাটারিং স্টাফ" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                @error('title') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">লোকেশন <span class="text-red-500">*</span></label>
                                <input wire:model="location" id="location" type="text" required placeholder="যেমন: বনানী, ঢাকা" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                @error('location') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="start_datetime" class="block text-sm font-medium text-gray-700 mb-2">শুরুর তারিখ ও সময় <span class="text-red-500">*</span></label>
                                <input wire:model="start_datetime" id="start_datetime" type="datetime-local" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                @error('start_datetime') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="end_datetime" class="block text-sm font-medium text-gray-700 mb-2">শেষের তারিখ ও সময় <span class="text-red-500">*</span></label>
                                <input wire:model="end_datetime" id="end_datetime" type="datetime-local" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                @error('end_datetime') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="wage" class="block text-sm font-medium text-gray-700 mb-2">পেমেন্ট / মজুরি <span class="text-red-500">*</span></label>
                                <input wire:model="wage" id="wage" type="text" required placeholder="যেমন: ৳১০০০ / দিন" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                @error('wage') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">কাজের বিবরণ <span class="text-red-500">*</span></label>
                            <textarea wire:model="description" id="description" rows="4" required placeholder="কাজের বিস্তারিত বিবরণ লিখুন..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors"></textarea>
                            @error('description') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">যোগ্যতা ও শর্তাবলী <span class="text-red-500">*</span></label>
                            <textarea wire:model="requirements" id="requirements" rows="3" required placeholder="কী কী যোগ্যতা প্রয়োজন..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors"></textarea>
                            @error('requirements') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm px-8 py-4 transition-all shadow-lg flex items-center" wire:loading.attr="disabled">
                                <span wire:loading.remove class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    আপডেট করুন
                                </span>
                                <span wire:loading>আপডেট করা হচ্ছে...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>