<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'surname',
        'age',
        'class',
        'profile_photo',
        'banner_image',
        'about',
        'result_files',
    ];

    protected function casts(): array
    {
        return [
            'result_files' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
