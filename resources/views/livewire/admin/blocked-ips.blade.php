<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">{{ __('Blocked IPs') }}</flux:heading>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                <tr>
                    <th class="px-6 py-3 font-medium text-zinc-500 dark:text-zinc-400">IP Address</th>
                    <th class="px-6 py-3 font-medium text-zinc-500 dark:text-zinc-400">Blocked At</th>
                    <th class="px-6 py-3 font-medium text-zinc-500 dark:text-zinc-400 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse($blockedIps as $ip)
                    <tr>
                        <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">{{ $ip->ip_address }}</td>
                        <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">{{ $ip->created_at->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4 text-right">
                            <flux:button size="sm" variant="danger" wire:click="unblock({{ $ip->id }})" wire:confirm="Are you sure you want to unblock this IP?">
                                Unblock
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                            No blocked IP addresses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($blockedIps->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $blockedIps->links() }}
            </div>
        @endif
    </div>
</div>
