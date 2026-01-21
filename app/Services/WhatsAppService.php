<?php

namespace App\Services;

use App\Models\IdentitasDesa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public static function send($to, $message)
    {
        $config = IdentitasDesa::first();

        if (!$config || !$config->wa_api_url || !$config->wa_api_key) {
            Log::warning('WhatsApp API config not found or incomplete.');
            return false;
        }

        // Format number to international format if starts with 0
        if (str_starts_with($to, '0')) {
            $to = '62' . substr($to, 1);
        }

        try {
            // Assuming common API format, adjust according to actual gateway (e.g. Fonnte)
            $response = Http::withHeaders([
                'Authorization' => $config->wa_api_key,
            ])->post($config->wa_api_url, [
                'target' => $to,
                'message' => $message,
                'countryCode' => '62', // optional but good practice
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp sent to $to: $message");
                return true;
            }

            Log::error("WhatsApp failed to $to: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("WhatsApp error: " . $e->getMessage());
            return false;
        }
    }

    public static function parseTemplate($template, $data)
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }
        return $template;
    }
}
