<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $company_id = '';
    public $start_date = '';
    public $end_date = '';

    // Modal state for posting new job
    public $title = '';
    public $location = '';
    public $start_datetime = '';
    public $end_datetime = '';
    public $wage = '';
    public $description = '';
    public $requirements = '';
    public $selected_company_id = '';
    public $status = 'OPEN';

    public function with(): array
    {
        $query = Job::with(['user', 'applications.user']);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->company_id) {
            $query->where('user_id', $this->company_id);
        }

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }

        return [
            'jobs' => $query->latest()->paginate(10),
            'companies' => User::where('role', 'company')->get(),
        ];
    }

    public function create()
    {
        $this->reset(['title', 'location', 'start_datetime', 'end_datetime', 'wage', 'description', 'requirements', 'selected_company_id']);
        $this->status = 'OPEN';
        $this->dispatch('modal-show', name: 'post-job-modal');
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'wage' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'selected_company_id' => 'nullable|exists:users,id',
            'status' => 'required|string'
        ]);

        $employerName = Auth::user()->name;
        $userId = Auth::id();

        if ($this->selected_company_id) {
            $company = User::find($this->selected_company_id);
            $employerName = $company->name;
            $userId = $company->id;
        }

        Job::create([
            'title' => $this->title,
            'location' => $this->location,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'wage' => $this->wage,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'status' => $this->status,
            'user_id' => $userId,
            'employer_name' => $employerName,
        ]);

        $this->dispatch('modal-close', name: 'post-job-modal');
        session()->flash('success', 'Job posted successfully.');
    }
};
?>

<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Total Jobs</h2>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
            Post New Job
        </button>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div>
            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
            <input type="text" wire:model.live="search" placeholder="Search title..." class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Company</label>
            <select wire:model.live="company_id" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <option value="">All Companies</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
            <input type="date" wire:model.live="start_date" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
            <input type="date" wire:model.live="end_date" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Job Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Company</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date Posted</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Completed By</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($jobs as $job)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $job->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $job->employer_name ?? 'Admin' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $job->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ strtoupper($job->status) === 'OPEN' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ $job->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            @php
                                $completedApp = $job->applications->firstWhere(function($app) {
                                    return in_array(strtolower($app->status), ['accepted', 'completed']);
                                });
                            @endphp
                            @if($completedApp && $completedApp->user)
                                <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $completedApp->user->name }}</span>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No jobs found matching your criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $jobs->links() }}
    </div>

    <!-- Modal for Posting Job -->
    <flux:modal name="post-job-modal" class="max-w-xl">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Post New Job</flux:heading>
            </div>
            
            <div class="space-y-4 max-h-[60vh] overflow-y-auto p-1">
                <flux:input wire:model="title" :label="__('Job Title')" type="text" />

                <div class="grid grid-cols-2 gap-4">
                    <flux:input wire:model="location" :label="__('Location')" type="text" />
                    <flux:input wire:model="wage" :label="__('Wage (e.g. $15/hr)')" type="text" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input wire:model="start_datetime" :label="__('Start Date & Time')" type="datetime-local" />
                    <flux:input wire:model="end_datetime" :label="__('End Date & Time')" type="datetime-local" />
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <flux:select wire:model="status" :label="__('Status')">
                        <option value="OPEN">Open</option>
                        <option value="CLOSED">Closed</option>
                        <option value="COMPLETED">Completed</option>
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model="selected_company_id" :label="__('Assign to Company (Optional)')">
                        <option value="">-- Post as Admin --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </flux:select>
                    <p class="text-xs text-zinc-500 mt-1">If no company is selected, the job will be posted by the Admin.</p>
                </div>

                <flux:textarea wire:model="description" :label="__('Description')" rows="3" />
                <flux:textarea wire:model="requirements" :label="__('Requirements')" rows="2" />
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="submit">{{ __('Post Job') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>