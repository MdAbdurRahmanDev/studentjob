<?php 
require 'vendor/autoload.php'; 
$app = require_once 'bootstrap/app.php'; 
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class); 
$kernel->bootstrap(); 
$u = \App\Models\User::find(2); 
$u->update([
    'title' => 'টাইটেল বা পেশা',
    'category_id' => 1,
    'custom_category' => 'cards',
    'bio' => 'আপনার সম্পর্কে (Bio)আপনার সআপনার সম্পর্কে (Bio)আপনার সম্পর্কে (Bio)আপনার সম্পর্কে (Bio)আপনার সম্পর্কে (Bio)আপনার সম্পর্কে (Bio)ম্পর্কে (Bio)আপনার সম্পর্কে (Bio)আপনার সম্পর্কে (Bio)আপনার সম্পর্কে (Bio)'
]); 
echo json_encode($u->fresh()->toArray());
