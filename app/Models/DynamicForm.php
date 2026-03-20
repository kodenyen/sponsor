<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    protected $fillable = [
        'title',
        'description',
        'target_role',
        'fields',
    ];

    protected function casts(): array
    {
        return [
            'fields' => 'array',
        ];
    }
}
