<?php

namespace App\Services\Contracts;

use App\Models\CheckProxyProtocol;

interface ChecksProtocol
{
    public function checkProtocolSupport(CheckProxyProtocol $check): CheckProxyProtocol;
}
