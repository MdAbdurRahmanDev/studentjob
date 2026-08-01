<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class HomePage extends Component
{
    use WithFileUploads;
    public $home_hero_title = '';
    public $home_hero_subtitle = '';
    public $home_middle_title = '';
    public $home_cards_title = '';
    public $home_cards_subtitle = '';
    public $home_cards = [];

    public function mount()
    {
        $this->home_hero_title = Setting::get('home_hero_title', 'শিক্ষার্থীদের পার্ট-টাইম <br> কর্মসংস্থান আর <br> <span class="text-yellow-500">বেকারত্ব দূরীকরণে</span> <br> আমরা নিয়মিত কাজ করে <br> যাচ্ছি।');
        $this->home_hero_subtitle = Setting::get('home_hero_subtitle', 'ক্যাটারিং, প্যাকেজিং, ডেলিভারি এবং অফিস সাপোর্ট শিফট — ঢাকার ভেরিফায়েড এমপ্লয়াররা পোস্ট করেন, আপনি এক ক্লিকে অ্যাপ্লাই করুন মাত্র ৳২০০/মাস সাবস্ক্রিপশনে।');
        $this->home_middle_title = Setting::get('home_middle_title', 'যে শিক্ষার্থীর এই সপ্তাহেই টাকা দরকার, বছরের পর বছরের ক্যারিয়ার নয়।');
        $this->home_cards_title = Setting::get('home_cards_title', 'কেন আমাদের প্ল্যাটফর্ম বেছে নেবেন?');
        $this->home_cards_subtitle = Setting::get('home_cards_subtitle', 'আপনার ব্যবসার প্রয়োজনে সঠিক লোকবল খুঁজে পাওয়ার সবচেয়ে বিশ্বস্ত মাধ্যম');

        $defaultCards = [
            [
                'title' => 'মেধাবী ও পরিশ্রমী শিক্ষার্থী',
                'description' => 'আমাদের প্ল্যাটফর্মে রয়েছেন দেশের বিভিন্ন স্বনামধন্য বিশ্ববিদ্যালয়ের হাজারো মেধাবী শিক্ষার্থী। তারা যেমন পড়াশোনায় ভালো, তেমনি যেকোনো পার্ট-টাইম কাজেও অত্যন্ত দায়িত্বশীল ও পরিশ্রমী।',
                'image_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'tag' => 'Quality',
                'link_text' => 'বিস্তারিত জানুন',
                'link' => '/employer/register',
            ],
            [
                'title' => 'দ্রুত ও সহজ নিয়োগ প্রক্রিয়া',
                'description' => 'কোনো ঝামেলা ছাড়াই মাত্র কয়েক মিনিটে জব পোস্ট করুন। আপনার প্রয়োজন অনুযায়ী সঠিক স্কিলের শিক্ষার্থী খুঁজে পেতে আমাদের স্মার্ট সিস্টেম আপনাকে সাহায্য করবে।',
                'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'tag' => 'Speed',
                'link_text' => 'এখনই শুরু করুন',
                'link' => '/employer/register',
            ]
        ];
        
        $savedCards = Setting::get('home_cards');
        $this->home_cards = $savedCards ? json_decode($savedCards, true) : $defaultCards;

        // Initialize 'image' key for file uploads
        foreach ($this->home_cards as &$card) {
            $card['image'] = null;
        }
    }

    public function addCard()
    {
        $this->home_cards[] = [
            'title' => '',
            'description' => '',
            'image_url' => '',
            'image' => null,
            'tag' => '',
            'link_text' => '',
            'link' => '',
        ];
    }

    public function removeCard($index)
    {
        unset($this->home_cards[$index]);
        $this->home_cards = array_values($this->home_cards);
    }

    public function saveSettings()
    {
        $this->validate([
            'home_hero_title' => 'required|string',
            'home_hero_subtitle' => 'required|string',
            'home_middle_title' => 'required|string',
            'home_cards_title' => 'required|string',
            'home_cards_subtitle' => 'required|string',
            'home_cards' => 'array',
            'home_cards.*.title' => 'required|string',
            'home_cards.*.description' => 'required|string',
            'home_cards.*.image' => 'nullable|image|max:2048',
            'home_cards.*.tag' => 'required|string',
            'home_cards.*.link_text' => 'required|string',
            'home_cards.*.link' => 'required|string',
        ]);

        $cardsToSave = $this->home_cards;
        foreach ($cardsToSave as &$card) {
            if (isset($card['image']) && is_object($card['image'])) {
                $path = $card['image']->store('home_cards', 'uploads');
                $card['image_url'] = Storage::disk('uploads')->url($path);
            }
            unset($card['image']);
        }

        Setting::set('home_hero_title', $this->home_hero_title);
        Setting::set('home_hero_subtitle', $this->home_hero_subtitle);
        Setting::set('home_middle_title', $this->home_middle_title);
        Setting::set('home_cards_title', $this->home_cards_title);
        Setting::set('home_cards_subtitle', $this->home_cards_subtitle);
        Setting::set('home_cards', json_encode($cardsToSave, JSON_UNESCAPED_UNICODE));

        // Reset image properties so they don't persist on subsequent requests
        foreach ($this->home_cards as &$card) {
            $card['image'] = null;
        }

        session()->flash('success', 'Home Page Settings updated successfully.');
        $this->dispatch('settings-updated');
    }

    public function render()
    {
        return view('livewire.admin.settings.home-page')
            ->layout('layouts.app', ['title' => __('Home Page Settings')]);
    }
}
