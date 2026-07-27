<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    protected $table = 'shifts';
    protected $fillable = ['title', 'location', 'time', 'status', 'description', 'wage', 'requirements', 'employer_name'];
}
