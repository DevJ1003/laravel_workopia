<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category_id',
        'job_nature_id',
        'vacancy',
        'salary',
        'location',
        'description',
        'benefits',
        'responsibility',
        'qualifications',
        'experience',
        'keywords',
        'company_name',
        'company_location',
        'website'
    ];

    public function jobNature()
    {
        return $this->belongsTo(JobNature::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
