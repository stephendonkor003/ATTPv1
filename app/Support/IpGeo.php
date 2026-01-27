<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IpGeo
{
    public static function countryForIp(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        return Cache::remember("ip_country_{$ip}", now()->addDays(7), function () use ($ip) {
            try {
                $response = Http::timeout(2)->get("https://ipapi.co/{$ip}/json/");
                if (!$response->successful()) {
                    return null;
                }
                return $response->json('country_name');
            } catch (\Throwable $e) {
                return null;
            }
        });
    }
}
