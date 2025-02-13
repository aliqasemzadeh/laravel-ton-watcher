<?php

namespace AliQasemzadeh\LaravelTonWatcher;

use Catchain\Ton\Address\Address;
use Illuminate\Support\Facades\Http;

class TonWatcher
{
    public static function txs(string $address = null): array
    {
        $txs = [];
        if($address) {
            $watcherAddress = $address;
        } else {
            $watcherAddress = config('tonwatcher.address');
        }
        $data = Http::withHeaders(['x-api-key' => config('tonwatcher.x-api-key')])->get('https://tonapi.io/v2/accounts/'.$watcherAddress.'/events?limit='.config('tonwatcher.page-limit'));
        if ($data->successful()) {
            $events = $data->json()['events'];
            foreach ($events as $event) {
                if (!$event['is_scam']) {
                    foreach ($event['actions'] as $action) {
                        if ($action['type'] == 'JettonTransfer') {
                            if ($action['status'] == 'ok') {
                                $transaction = $action['JettonTransfer'];
                                $txs[] = $transaction;
                            }
                        }
                        if ($action['type'] == 'TonTransfer') {
                            if ($action['status'] == 'ok') {
                                $transaction = $action['TonTransfer'];
                                $txs[] = $transaction;
                            }
                        }
                    }
                }
            }
        }
        return $txs;
    }

    public static function isValid(string $address): bool
    {
        return Address::isValid($address);
    }
}
