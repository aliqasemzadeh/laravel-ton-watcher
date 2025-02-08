<?php

namespace AliQasemzadeh\LaravelTonWatcher;

use Catchain\Ton\Address\Address;
use Illuminate\Support\Facades\Http;

class TonWatcher
{
    public static function txs(string $address = null): void|array
    {
        $data = Http::withHeaders(['x-api-key' => config('tonwatcher.x-api-key')])->get('https://tonapi.io/v2/accounts/'.config('tonwatcher.address').'/events?limit='.config('tonwatcher.page-limit'));
        return $data;
    }

    public static function isValid(string $address): bool
    {
        return Address::isValid($address);
    }
}
