<?php

namespace App\Helpers;

class Helper
{

    // Upload Image
    public static function socialMediaUsername($url, $platform)
    {
        $patterns = [
            'facebook' => "/(?:https?:\/\/)?(?:www\.)?facebook\.com\/([^\/]+)/i",
            'twitter' => "/(?:https?:\/\/)?(?:www\.)?twitter\.com\/([^\/]+)/i",
            'instagram' => "/(?:https?:\/\/)?(?:www\.)?instagram\.com\/([^\/]+)/i",
            'linkedin' => "/(?:https?:\/\/)?(?:www\.)?linkedin\.com\/in\/([^\/]+)/i",
        ];

        if (isset($patterns[$platform]) && preg_match($patterns[$platform], $url, $matches)) {
            return $matches[1];
        }

        return '';
    }


    // Domain Return
    public static function extractDomain($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        if (strpos($host, 'www.') === 0) {
            return $host;
        } else {
            return $host;
        }
    }

    // Ip address
    public static function ipAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
