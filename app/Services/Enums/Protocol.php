<?php

namespace App\Services\Enums;

enum Protocol: string
{
    case Http = 'http';
    case Https = 'https';
    case Socks5 = 'socks5';
}
