<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS using sms.net.bd API
     */
    public function sendSms(string $to, string $message): bool
    {
        $customerId = \App\Models\Setting::get('sms_customer_id', env('SMS_CUSTOMER_ID', 1597));
        $apiKey = \App\Models\Setting::get('sms_api_key', env('SMS_API_KEY', '79cd045232d86db8f9dda04e9a374dd6adad435ee2c8d'));

        // Format phone number (usually 24bulksmsbd expects 880 prefix)
        if (str_starts_with($to, '01')) {
            $to = '88'.$to;
        } elseif (str_starts_with($to, '+880')) {
            $to = substr($to, 1);
        }

        try {
            $response = Http::asForm()
                ->withoutVerifying()
                ->post('https://www.24bulksmsbd.com/api/smsSendApi', [
                    'customer_id' => $customerId,
                    'api_key' => $apiKey,
                    'message' => $message,
                    'mobile_no' => $to,
                ]);

            if ($response->successful()) {
                // The API returns HTTP 200 even for errors, so we must check the JSON body
                $data = $response->json();

                // Usually it returns something like {"status": "Failed", ...} or {"status": "Success", ...}
                // or just a raw string depending on the API.
                // Let's check if it's an array and if status is not "Failed"
                if (is_array($data) && isset($data['status']) && strtolower($data['status']) === 'failed') {
                    Log::error('SMS API Error (Failed Status)', ['response' => $response->body()]);

                    return false;
                }

                Log::info('SMS Sent successfully', ['response' => $response->body()]);

                return true;
            }

            Log::error('SMS API Error (HTTP Error)', ['response' => $response->body()]);

            return false;

        } catch (\Exception $e) {
            Log::error('SMS Sending Exception', ['error' => $e->getMessage()]);

            return false;
        }
    }
}
