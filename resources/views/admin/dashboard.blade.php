<x-layouts::app :title="__('Dashboard')">
    @php
        $now = \Carbon\Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $getStats = function($role) use ($startOfThisMonth, $startOfLastMonth, $endOfLastMonth) {
            $total = \App\Models\User::where('role', $role)->count();
            $thisMonth = \App\Models\User::where('role', $role)->where('created_at', '>=', $startOfThisMonth)->count();
            $lastMonth = \App\Models\User::where('role', $role)->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
            
            $percentChange = 0;
            if ($lastMonth > 0) {
                $percentChange = (($thisMonth - $lastMonth) / $lastMonth) * 100;
            } else if ($thisMonth > 0) {
                $percentChange = 100;
            }
            
            return [
                'total' => $total,
                'thisMonth' => $thisMonth,
                'percentChange' => round($percentChange, 1),
                'isPositive' => $percentChange >= 0
            ];
        };

        $userStats = $getStats('user');
        $companyStats = $getStats('company');
        $adminStats = $getStats('admin');
        $all = max($userStats['total'] + $companyStats['total'] + $adminStats['total'], 1);

        // New Application & Job Stats
        $totalCompletedJobs = \App\Models\Application::where('status', 'completed')->count();
        $totalAbsent = \App\Models\Application::where('status', 'absent')->count();
        $totalHired = \App\Models\Application::where('status', 'hired')->count();
        $totalEarningsPaid = \App\Models\Application::where('status', 'completed')->sum('earnings');
        $totalJobsOnPlatform = \App\Models\Job::count();

        // Verification Stats
        $totalVerifiedUsers = \App\Models\UserVerification::where('status', 'approved')->count();
        $totalRejectedUsers = \App\Models\UserVerification::where('status', 'rejected')->count();
        $totalPendingVerifications = \App\Models\UserVerification::where('status', 'pending')->count();
    @endphp

    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">
            <!-- Total Users -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Total Users</h3>
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-md text-indigo-600 dark:text-indigo-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">{{ $userStats['total'] }}</p>
                <div class="mt-4 flex items-center text-sm">
                    @if($userStats['isPositive'])
                        <span class="text-green-500 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $userStats['percentChange'] }}%
                        </span>
                    @else
                        <span class="text-red-500 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                            {{ $userStats['percentChange'] }}%
                        </span>
                    @endif
                    <span class="text-gray-500 dark:text-gray-400 ml-2">vs last month ({{ $userStats['thisMonth'] }} new)</span>
                </div>
            </div>
            
            <!-- Total Companies -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Total Companies</h3>
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-md text-green-600 dark:text-green-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">{{ $companyStats['total'] }}</p>
                <div class="mt-4 flex items-center text-sm">
                    @if($companyStats['isPositive'])
                        <span class="text-green-500 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $companyStats['percentChange'] }}%
                        </span>
                    @else
                        <span class="text-red-500 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                            {{ $companyStats['percentChange'] }}%
                        </span>
                    @endif
                    <span class="text-gray-500 dark:text-gray-400 ml-2">vs last month ({{ $companyStats['thisMonth'] }} new)</span>
                </div>
            </div>

            <!-- Total Admins -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Total Admins</h3>
                    <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-md text-purple-600 dark:text-purple-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">{{ $adminStats['total'] }}</p>
                <div class="mt-4 flex items-center text-sm">
                    @if($adminStats['isPositive'])
                        <span class="text-green-500 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $adminStats['percentChange'] }}%
                        </span>
                    @else
                        <span class="text-red-500 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                            {{ $adminStats['percentChange'] }}%
                        </span>
                    @endif
                    <span class="text-gray-500 dark:text-gray-400 ml-2">vs last month ({{ $adminStats['thisMonth'] }} new)</span>
                </div>
            </div>
        </div>

        <!-- Verification Report -->
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-4 mb-2">User Verification Report</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">
            <!-- Total Verified -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Total Verified</h3>
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-md text-green-600 dark:text-green-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">{{ $totalVerifiedUsers }}</p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">Approved users</div>
            </div>

            <!-- Total Pending -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Pending Verification</h3>
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-md text-yellow-600 dark:text-yellow-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">{{ $totalPendingVerifications }}</p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">Waiting for review</div>
            </div>

            <!-- Total Rejected -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Total Rejected</h3>
                    <div class="p-2 bg-red-100 dark:bg-red-900 rounded-md text-red-600 dark:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">{{ $totalRejectedUsers }}</p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">Needs resubmission</div>
            </div>
        </div>

        @php
            $subPrice = 200;
            $pendingCount = \App\Models\Subscription::where('status', 'pending')->count();
            $approvedCount = \App\Models\Subscription::where('status', 'approved')->count();
            $rejectedCount = \App\Models\Subscription::where('status', 'rejected')->count();
            
            $pendingAmount = $pendingCount * $subPrice;
            $approvedAmount = $approvedCount * $subPrice;
            $rejectedAmount = $rejectedCount * $subPrice;

            $uniqueSubscribers = \App\Models\Subscription::where('status', 'approved')->distinct('user_id')->count('user_id');
        @endphp

        <!-- Subscription Report -->
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-4 mb-2">Subscription Report</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-2">
            <!-- Pending Amount -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Pending Amount</h3>
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-md text-yellow-600 dark:text-yellow-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">৳{{ number_format($pendingAmount) }}</p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    From {{ $pendingCount }} requests
                </div>
            </div>

            <!-- Approved Amount -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Total Earned</h3>
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-md text-green-600 dark:text-green-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">৳{{ number_format($approvedAmount) }}</p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    From {{ $approvedCount }} approvals
                </div>
            </div>

            <!-- Rejected Amount -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Rejected Amount</h3>
                    <div class="p-2 bg-red-100 dark:bg-red-900 rounded-md text-red-600 dark:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">৳{{ number_format($rejectedAmount) }}</p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    From {{ $rejectedCount }} rejections
                </div>
            </div>

            <!-- Total Subscribers -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">Active Subscribers</h3>
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-md text-blue-600 dark:text-blue-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-4">{{ number_format($uniqueSubscribers) }}</p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    Unique approved users
                </div>
            </div>
        </div>

        @php
            $recentTransactions = \App\Models\Subscription::with('user')->latest()->take(5)->get();
            $recentUsers = \App\Models\User::latest()->take(5)->get();
        @endphp

        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mt-6 mb-4">Job & Application Analytics</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Total Completed Jobs -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg text-green-600 dark:text-green-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider mb-1">মোট সম্পন্ন কাজ</h3>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalCompletedJobs }}</p>
                </div>
            </div>

            <!-- Total Absent -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg text-red-600 dark:text-red-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider mb-1">মোট অনুপস্থিত</h3>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalAbsent }}</p>
                </div>
            </div>

            <!-- Currently Hired -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-600 dark:text-blue-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider mb-1">বর্তমানে হায়ারড</h3>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalHired }}</p>
                </div>
            </div>

            <!-- Total Earnings -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-xl shadow-lg shadow-green-500/30 text-white flex flex-col justify-between hover:shadow-xl transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-white/20 rounded-lg text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-green-100 text-sm font-semibold uppercase tracking-wider mb-1">সর্বমোট আয় (Paid)</h3>
                    <p class="text-3xl font-bold">৳{{ number_format($totalEarningsPaid) }}</p>
                </div>
            </div>

            <!-- Total Jobs -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg text-yellow-600 dark:text-yellow-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider mb-1">প্ল্যাটফর্মের মোট শিফট</h3>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalJobsOnPlatform }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Recent Transactions</h3>
                    <a href="{{ route('admin.transactions') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentTransactions as $tx)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ optional($tx->user)->name }}</div>
                                    <div class="text-xs text-gray-500">{{ optional($tx->user)->email }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    ৳200 <span class="text-xs text-gray-500">({{ ucfirst($tx->payment_method) }})</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($tx->status === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($tx->status === 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">No recent transactions.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Recent Users</h3>
                    <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentUsers as $user)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'company' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">No recent users.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-layouts::app>
