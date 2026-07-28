<?php

namespace App\Livewire;

use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Subscribe extends Component
{
    public string $payment_method = '';
    public string $transaction_id = '';

    public function mount()
    {
        $firstMethod = \App\Models\PaymentMethod::where('is_active', true)->first();
        if ($firstMethod) {
            $this->payment_method = $firstMethod->name;
        }
    }

    public function submit()
    {
        $activeMethods = \App\Models\PaymentMethod::where('is_active', true)->pluck('name')->toArray();

        $this->validate([
            'payment_method' => ['required', \Illuminate\Validation\Rule::in($activeMethods)],
            'transaction_id' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        Subscription::create([
            'user_id' => Auth::id(),
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'status' => 'pending',
        ]);

        session()->flash('success', 'আপনার ট্রানজেকশন আইডি সফলভাবে জমা দেওয়া হয়েছে! ভেরিফাই হলে আপনি শিফটে এপ্লাই করতে পারবেন।');
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        return view('livewire.subscribe', compact('paymentMethods'))->layout('components.layouts.front');
    }
}
