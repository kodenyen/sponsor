<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorStudentAssignment extends Model
{
    protected $fillable = [
        'sponsor_id',
        'student_id',
    ];
}
