<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Check extends Model
{
    // Пока остановимся на ipv4 адресах
    public const IP_STR_MAX_LENGTH = 15;

    use HasFactory;
    
    public function checkProxies(): HasMany
    {
        return $this->hasMany(CheckProxy::class);
    } 
}
