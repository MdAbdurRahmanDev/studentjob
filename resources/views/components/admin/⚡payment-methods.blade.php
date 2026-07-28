<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads, WithPagination;

    public $name = '';
    public $type = 'personal';
    public $number = '';
    public $logo;
    public $is_active = true;
    
    public $editId = null;
    public $existingLogo = null;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:personal,agent,others',
            'number' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];
    }

    public function with(): array
    {
        return [
            'paymentMethods' => PaymentMethod::latest()->paginate(10)
        ];
    }

    public function create()
    {
        $this->reset(['name', 'type', 'number', 'logo', 'is_active', 'editId', 'existingLogo']);
        $this->type = 'personal';
        $this->is_active = true;
        
        $this->dispatch('modal-show', name: 'payment-method-modal');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $method = PaymentMethod::findOrFail($id);
        $this->editId = $method->id;
        $this->name = $method->name;
        $this->type = $method->type;
        $this->number = $method->number;
        $this->is_active = $method->is_active;
        $this->existingLogo = $method->logo;
        $this->logo = null;
        
        $this->dispatch('modal-show', name: 'payment-method-modal');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'number' => $this->number,
            'is_active' => $this->is_active,
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('payment_logos', 'public');
            
            // Delete old logo if updating
            if ($this->editId && $this->existingLogo) {
                Storage::disk('public')->delete($this->existingLogo);
            }
        }

        if ($this->editId) {
            PaymentMethod::findOrFail($this->editId)->update($data);
        } else {
            PaymentMethod::create($data);
        }

        $this->dispatch('modal-close', name: 'payment-method-modal');
        $this->reset(['name', 'type', 'number', 'logo', 'is_active', 'editId', 'existingLogo']);
    }

    public function delete($id)
    {
        $method = PaymentMethod::findOrFail($id);
        if ($method->logo) {
            Storage::disk('public')->delete($method->logo);
        }
        $method->delete();
    }
};
?>

<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Payment Methods</h2>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
            Add New
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Logo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Number</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($paymentMethods as $method)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($method->logo)
                                <img src="{{ Storage::url($method->logo) }}" alt="{{ $method->name }}" class="h-10 w-auto rounded object-contain bg-white dark:bg-gray-200 p-1">
                            @else
                                <div class="h-10 w-16 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center text-gray-400 text-xs">No Logo</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $method->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 capitalize">{{ $method->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $method->number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $method->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $method->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $method->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</button>
                            <button wire:click="delete({{ $method->id }})" wire:confirm="Are you sure you want to delete this payment method?" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No payment methods found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $paymentMethods->links() }}
    </div>

    <!-- Modal -->
    <flux:modal name="payment-method-modal" class="max-w-lg">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editId ? 'Edit Payment Method' : 'Add Payment Method' }}</flux:heading>
            </div>
            
            <div class="space-y-4">
                <flux:input wire:model="name" :label="__('Name (e.g. Bkash)')" type="text" />

                <flux:select wire:model="type" :label="__('Type')">
                    <option value="personal">Personal</option>
                    <option value="agent">Agent</option>
                    <option value="others">Others</option>
                </flux:select>

                <flux:input wire:model="number" :label="__('Account Number')" type="text" />

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Logo</label>
                    <input type="file" wire:model="logo" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-zinc-800 dark:file:text-zinc-300">
                    @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                    <div wire:loading wire:target="logo" class="text-sm text-zinc-500 mt-1">Uploading...</div>

                    @if ($logo)
                        <div class="mt-2">
                            <p class="text-xs text-zinc-500 mb-1">Preview:</p>
                            <img src="{{ $logo->temporaryUrl() }}" class="h-12 rounded border p-1 bg-white">
                        </div>
                    @elseif($existingLogo)
                        <div class="mt-2">
                            <p class="text-xs text-zinc-500 mb-1">Current Logo:</p>
                            <img src="{{ Storage::url($existingLogo) }}" class="h-12 rounded border p-1 bg-white">
                        </div>
                    @endif
                </div>

                <flux:checkbox wire:model="is_active" :label="__('Active')" />
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse mt-6">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>