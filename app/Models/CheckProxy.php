<?php

namespace App\Models;

use App\Services\Enums\Protocol;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CheckProxy extends Model
{
    use HasFactory;

    protected $casts = [
        'finished_at' => 'immutable_datetime',
        'is_available' => 'boolean',
        'supported_protocol' => Protocol::class,
    ];

    protected $fillable = [
        'ip',
        'port',
    ];

    public function check(): BelongsTo
    {
        return $this->belongsTo(Check::class);
    }

    public function checkProxyProtocols(): HasMany
    {
        return $this->hasMany(CheckProxyProtocol::class);
    }

    public function checkProxyIp(): HasOne
    {
        return $this->hasOne(CheckProxyIp::class);
    }

    public function checkProxyGeo(): HasOne
    {
        return $this->hasOne(CheckProxyGeo::class);
    }
    
    public function checkProxyDownloadSpeed(): HasOne
    {
        return $this->hasOne(CheckProxyDownloadSpeed::class);
    }

    /**
     * Создать список протоколов, которые нужно проверить для текущего прокси
     */
    public function createProtocolChecks(): Collection
    {
        $protocols = collect([
            Protocol::Http,
            Protocol::Https,
            Protocol::Socks5,
        ]);

        return $this->checkProxyProtocols()->createMany($protocols->map(fn (Protocol $p) => [
            'protocol' => $p,
        ]));
    }

    /**
     * Создать проверку IP для текущего прокси
     */
    public function createIpCheck(): CheckProxyIp
    {
        return $this->checkProxyIp()->create();
    }

    /**
     * Создать проверку географических данных для текущего прокси
     */
    public function createGeoCheck(): CheckProxyIp
    {
        return $this->checkProxyGeo()->create();
    }

    /**
     * Создать проверку скорости загрузки данных для текущего прокси
     */
    public function createDownloadSpeedCheck(): CheckProxyGeo
    {
        return $this->checkProxyGeo()->create();
    }

    /**
     * @throws Exception Если протокол ещё не найден
     * @return string Поддерживаемый прокси протокол
     */
    public function ensureSupportedProtocolFound(): string
    {
        if (is_null($this->supported_protocol)) {
            throw new Exception('Supported protocol is not found yet or the proxy is not available');
        }

        return $this->supported_protocol;
    }

    /**
     * @throws Exception Если внешний IP ещё не найден
     * @return string Внешний IP прокси
     */
    public function ensureExternalIpFound(): string
    {
        if (is_null($this->external_ip)) {
            throw new Exception('External IP is not determined yet or the proxy is not available');
        }

        return $this->external_ip;
    }
}
