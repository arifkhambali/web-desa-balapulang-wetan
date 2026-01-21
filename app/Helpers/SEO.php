<?php

namespace App\Helpers;

class SEO
{
    public static function generateTitle($pageTitle, $siteName = null)
    {
        $siteName = $siteName ?? config('app.name', 'Sistem Informasi Desa');
        return $pageTitle ? "{$pageTitle} - {$siteName}" : $siteName;
    }
    
    public static function generateDescription($content, $maxLength = 160)
    {
        $stripped = strip_tags($content);
        return strlen($stripped) > $maxLength 
            ? substr($stripped, 0, $maxLength) . '...' 
            : $stripped;
    }
    
    public static function generateKeywords($tags)
    {
        return is_array($tags) ? implode(', ', $tags) : $tags;
    }
    
    public static function generateImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('images/default-og-image.jpg');
        }
        
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }
        
        return asset('storage/' . $imagePath);
    }
}
