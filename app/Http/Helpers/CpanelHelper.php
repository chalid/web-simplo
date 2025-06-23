<?php

namespace App\Http\Helpers;

class CpanelHelper
{
    private static $cpanelUsername;
    private static $apiToken;
    private static $host;
    private static $port;

    public static function init()
    {
        self::$cpanelUsername = env('CPANEL_USERNAME');
        self::$apiToken = env('CPANEL_API_TOKEN');
        self::$host = env('CPANEL_HOST');
        self::$port = env('CPANEL_PORT');
    }

    private static function executeRequest($path, $data)
    {
        self::init();

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => self::$host . ':' . self::$port . $path,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false, // Disable SSL verification (for testing)
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification (for testing)
            CURLOPT_HTTPHEADER => [
                'Authorization: cpanel ' . self::$cpanelUsername . ':' . self::$apiToken,
            ],
        ]);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            // Handle error
            $error = curl_error($ch);

            return ['error' => $error];
        }

        // Close cURL session
        curl_close($ch);

        // Decode JSON response
        $result = json_decode($response, true);


        return $result;
    }

    public static function createEmailAccount($email, $password)
    {
        $path = '/execute/Email/add_pop';
        $data = [
            'email' => $email,
            'password' => $password,
        ];

        return self::executeRequest($path, $data);
    }
}