<?php

namespace App\Models;

use App\Services\Enums\Protocol;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Protocol $protocol 
 * @property boolean $is_supported 
 * @property CarbonImmutable $checked_at 
 */
class CheckProxyProtocol extends Model
{
    use HasFactory;

    protected $casts = [
        'is_supported' => 'boolean',
        'checked_at' => 'immutable_datetime',
        'protocol' => Protocol::class,
    ];

    protected $fillable = [
        'protocol',
    ];

    public function checkProxy(): BelongsTo
    {
        return $this->belongsTo(CheckProxy::class);
    }
}
