<?php

use App\Models\Check;
use App\Models\CheckProxy;
use App\Models\CheckProxyProtocol;
use App\Services\Enums\Protocol;
use App\Services\ProtocolCheckers\HttpClientProtocolChecker;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{ip}/{port}', function ($ip, $port, HttpClientProtocolChecker $checker) {
    /** @var Check $check */
    $check = Check::create();

    /** @var CheckProxy $proxy */
    $proxy = $check->checkProxies()->create([
        'ip' => $ip,
        'port' => $port,
    ]);

    $protocols = $proxy->createProtocolChecks();

    $supportedProtocols = $protocols->map(
        fn (CheckProxyProtocol $protocol) => $checker->checkProtocolSupport($protocol),
    )->filter->is_supported->map->protocol;

    if ($supportedProtocols->isEmpty()) {
        return $protocols;
    }

    if (
        $supportedProtocols->contains(Protocol::Http)
        && $supportedProtocols->contains(Protocol::Https)
    ) {
        $proxy->supported_protocol = Protocol::Https;
    
    } elseif ($supportedProtocols->count() > 1) {
        throw new LogicException();

    } else {
        $proxy->supported_protocol = $supportedProtocols->first();
    }

    $proxy->save();

    return $protocols;
});
