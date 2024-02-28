<?php

namespace App\Services\ProtocolCheckers;

use App\Models\CheckProxyProtocol;
use App\Services\Contracts\ChecksProtocol;
use Illuminate\Support\Facades\Http;

class HttpClientProtocolChecker implements ChecksProtocol
{
    public function checkProtocolSupport(CheckProxyProtocol $check): CheckProxyProtocol
    {
        $proxy = $check->checkProxy;

        try {
            $success = Http::withOptions([
                'proxy' => $check->protocol->value . '://' . $proxy->ip . ':' . $proxy->port,
            ])
                ->timeout(5)
                ->get('http://example.org')
                ->successful();

        } catch (\Throwable $th) {
            $success = false;
        }

        $check->is_supported = $success;
        $check->checked_at = now();
        $check->save();

        return $check;
    }
}
