<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class EventSlugGenerator
{
    public static function generate(string $title): string
    {
        $slug = Str::random(20);

        return strtolower($slug) . '-' . (int)floor(microtime(true) * 1000);
    }
}
