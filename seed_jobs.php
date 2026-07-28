<?php
$categories = \App\Models\Category::all();
$user = \App\Models\User::first();

foreach($categories as $category) {
    for($i = 1; $i <= 3; $i++) {
        \App\Models\Job::create([
            'title' => $category->name . ' Specialist ' . $i,
            'location' => 'Dhaka, Bangladesh',
            'time' => '10:00 AM - 06:00 PM',
            'status' => 'OPEN',
            'description' => 'Looking for an expert in ' . $category->name . ' for this role.',
            'wage' => rand(500, 2000) . ' BDT/day',
            'requirements' => '1 year of experience in ' . $category->name,
            'employer_name' => 'Demo Company',
            'user_id' => $user ? $user->id : null,
            'category_id' => $category->id
        ]);
    }
}
echo "Jobs created successfully.\n";
