<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckProxyDownloadSpeed extends Model
{
    use HasFactory;
    
    protected $casts = [
        'checked_at' => 'immutable_datetime'
    ];
}
