<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HireRequest extends Model
{
    protected $fillable = [
        'employer_id',
        'student_id',
        'work_title',
        'description',
        'status',
        'contact_number',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
