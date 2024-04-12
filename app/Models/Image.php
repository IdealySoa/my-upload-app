<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'upload_date', 'delete_date'];

    protected $casts = [
        'upload_date' => 'datetime',
        'delete_date' => 'datetime',
    ];
}
