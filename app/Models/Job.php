<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'requirements','company', 'job_type', 'experience_level',
        'min_salary', 'max_salary', 'location',
        'salary_type', 'application_deadline',
    ];

    public function category()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
