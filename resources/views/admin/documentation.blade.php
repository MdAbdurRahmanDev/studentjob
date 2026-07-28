<x-layouts::app :title="__('Documentation')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-100 dark:border-gray-700 max-w-5xl mx-auto w-full">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Admin Panel Documentation</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8 border-b pb-6 dark:border-gray-700">অ্যাডমিন প্যানেল ব্যবহারের নির্দেশিকা / Guide to using the Admin Panel</p>

            <div class="space-y-12">
                
                <!-- Section 1: Dashboard -->
                <section>
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-md text-indigo-600 dark:text-indigo-300 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">1. Admin Dashboard / অ্যাডমিন ড্যাশবোর্ড</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900 p-6 rounded-xl">
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">Bangla</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                ড্যাশবোর্ড হচ্ছে অ্যাডমিন প্যানেলের মূল পেজ। এখানে আপনি পুরো সিস্টেমের একটি ওভারভিউ দেখতে পাবেন। যেমন- সিস্টেমে মোট কতজন ইউজার, কোম্পানি এবং অ্যাডমিন আছে। এছাড়া সাবস্ক্রিপশন, ভেরিফিকেশন এবং টোটাল আয়-ব্যয়ের রিপোর্ট এখানে চার্ট এবং কার্ডের মাধ্যমে দেখানো হয়।
                            </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">English</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                The dashboard is the main page of the admin panel. Here you can see an overview of the entire system, such as total users, companies, and admins. Subscription stats, verification metrics, and total earnings are displayed using interactive cards and charts.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 2: All Users -->
                <section>
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-md text-blue-600 dark:text-blue-300 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">2. All Users / সকল ইউজার</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900 p-6 rounded-xl">
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">Bangla</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                এই পেজ থেকে আপনি ওয়েবসাইটের সকল রেজিস্টার্ড ইউজারদের তালিকা দেখতে পাবেন। কে কোম্পানি আর কে স্টুডেন্ট, সেটি আলাদা করা যায়। আপনি চাইলে যে কোনো ইউজারকে ডিলিট, সাসপেন্ড অথবা তাদের রোল পরিবর্তন করতে পারবেন।
                            </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">English</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                From this page, you can view the list of all registered users on the website. You can filter by role (Company/Student). You also have the ability to delete, suspend, or change the role of any user.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 3: User Verifications -->
                <section>
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-md text-green-600 dark:text-green-300 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">3. User Verifications / ইউজার ভেরিফিকেশন</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900 p-6 rounded-xl">
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">Bangla</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                স্টুডেন্টরা যখন তাদের NID বা Student ID আপলোড করে, সেটি এই পেজে এসে জমা হয় (Pending অবস্থায়)। আপনি <strong>"View Details"</strong> বাটনে ক্লিক করে তাদের আপলোড করা আইডি কার্ডটি চেক করতে পারবেন। সব ঠিক থাকলে <strong>Approve</strong> করুন, আর ভুল থাকলে <strong>Reject</strong> করে দিন।
                            </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">English</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                When students upload their NID or Student ID, it appears on this page as Pending. You can click the <strong>"View Details"</strong> button to inspect the uploaded documents. If valid, click <strong>Approve</strong>. If invalid, click <strong>Reject</strong>.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 4: Jobs & Applications -->
                <section>
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-md text-purple-600 dark:text-purple-300 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">4. Total Jobs & Applications / সকল কাজ ও আবেদন</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900 p-6 rounded-xl">
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">Bangla</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                <strong>Total Jobs:</strong> কোম্পানিগুলো যেসব কাজের শিফট পোস্ট করে, সেগুলো আপনি এখানে দেখতে পাবেন। চাইলে যেকোনো জব ডিলিট বা ব্লক করতে পারেন।<br><br>
                                <strong>Applications:</strong> কোন স্টুডেন্ট কোন জবে অ্যাপ্লাই করেছে এবং তার বর্তমান স্ট্যাটাস (Hired, Completed, Absent) কী, তা এখান থেকে মনিটর করা যায়।
                            </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">English</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                <strong>Total Jobs:</strong> View all the shifts posted by companies. You can delete or block any job posting if needed.<br><br>
                                <strong>Applications:</strong> Monitor which student applied to which job and check their current status (e.g., Hired, Completed, Absent).
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 5: Settings & Others -->
                <section>
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-gray-200 dark:bg-gray-700 rounded-md text-gray-700 dark:text-gray-300 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">5. Settings & General / সেটিংস</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-900 p-6 rounded-xl">
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">Bangla</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                <strong>Categories:</strong> এখান থেকে কাজের ক্যাটাগরি (যেমন- ওয়েটার, ডেলিভারি) তৈরি এবং ম্যানেজ করা যায়।<br>
                                <strong>Settings:</strong> সাইটের নাম, লোগো, হোমপেজ ব্যানার, সাবস্ক্রিপশন ফি এবং অন্যান্য সিস্টেম সেটিংস এখান থেকে কন্ট্রোল করতে পারবেন।
                            </p>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-700 dark:text-gray-300 mb-2">English</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                <strong>Categories:</strong> Create and manage job categories (e.g., Waiter, Delivery) from this section.<br>
                                <strong>Settings:</strong> Control site name, logos, homepage banners, subscription fees, and core system configurations from here.
                            </p>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</x-layouts::app>
