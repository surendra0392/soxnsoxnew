<?php

use Stevebauman\Purify\Facades\Purify;
use Webkul\Core\Facades\Acl;
use Webkul\Core\Facades\Core;
use Webkul\Core\Facades\Menu;
use Webkul\Core\Facades\SystemConfig;

if (! function_exists('core')) {
    /**
     * Core helper.
     *
     * @return Webkul\Core\Core
     */
    function core()
    {
        return Core::getFacadeRoot();
    }
}

if (! function_exists('menu')) {
    /**
     * Menu helper.
     *
     * @return Webkul\Core\Menu
     */
    function menu()
    {
        return Menu::getFacadeRoot();
    }
}

if (! function_exists('acl')) {
    /**
     * Acl helper.
     *
     * @return Webkul\Core\Acl
     */
    function acl()
    {
        return Acl::getFacadeRoot();
    }
}

if (! function_exists('system_config')) {
    /**
     * System Config helper.
     *
     * @return Webkul\Core\SystemConfig
     */
    function system_config()
    {
        return SystemConfig::getFacadeRoot();
    }
}

if (! function_exists('clean_path')) {
    /**
     * Clean path.
     */
    function clean_path(string $path): string
    {
        return collect(explode('/', $path))
            ->filter(fn ($segment) => ! empty($segment))
            ->join('/');
    }
}

if (! function_exists('clean_content')) {
    /**
     * Clean content.
     */
    function clean_content(string $content): string
    {
        $cleaned = Purify::clean($content);

        $patterns = [
            '/\{\{.*?\}\}/',
            '/\{!!.*?!!\}/',
            '/@(php|if|else|endif|foreach|endforeach|for|endfor|while|endwhile|switch|endswitch|case|break|continue|include|extends|section|endsection|yield|push|endpush|stack|endstack)/',
            '/<\?php.*?\?>/s',
        ];

        foreach ($patterns as $pattern) {
            $cleaned = preg_replace($pattern, '', $cleaned);
        }

        $cleaned = str_replace(
            ['{{', '}}', '{!!', '!!}'],
            ['&#123;&#123;', '&#125;&#125;', '&#123;!!', '!!&#125;'],
            $cleaned
        );

        return $cleaned;
    }
}

if (! function_exists('array_permutation')) {
    function array_permutation($input)
    {
        $results = [];

        foreach ($input as $key => $values) {
            if (empty($values)) {
                continue;
            }

            if (empty($results)) {
                foreach ($values as $value) {
                    $results[] = [$key => $value];
                }
            } else {
                $append = [];

                foreach ($results as &$result) {
                    $result[$key] = array_shift($values);

                    $copy = $result;

                    foreach ($values as $item) {
                        $copy[$key] = $item;
                        $append[] = $copy;
                    }

                    array_unshift($values, $result[$key]);
                }

                $results = array_merge($results, $append);
            }
        }

        return $results;
    }
}

if (! function_exists('soxnsox_avatar_color')) {
    /**
     * Get a deterministic background color for a user avatar.
     */
    function soxnsox_avatar_color(?string $name): string
    {
        $palette = [
            '#133b63', // SOX N SOX Navy
            '#2ca7a3', // SOX N SOX Teal
            '#d97706', // Warm Amber
            '#059669', // Emerald Green
            '#7c3aed', // Vibrant Purple
            '#2563eb', // Royal Blue
            '#dc2626', // Crimson Red
            '#db2777', // Rose Pink
            '#ea580c', // Tangerine
            '#0891b2', // Cyan Ocean
            '#4f46e5', // Indigo
            '#0d9488', // Dark Teal
        ];

        $clean = trim($name ?: 'User');
        $hash = crc32(mb_strtolower($clean, 'UTF-8'));

        return $palette[abs($hash) % count($palette)];
    }
}

if (! function_exists('soxnsox_avatar')) {
    /**
     * Generate an inline SVG Data URI avatar displaying user initials on a distinct background color.
     */
    function soxnsox_avatar(?string $name, int $size = 80, bool $rounded = true): string
    {
        $clean = trim($name ?: 'U');
        $initial = mb_strtoupper(mb_substr($clean, 0, 1, 'UTF-8'), 'UTF-8');
        if (! $initial) {
            $initial = 'U';
        }

        $color = soxnsox_avatar_color($clean);
        $encodedColor = rawurlencode($color);
        $rx = $rounded ? '50%' : '20%';
        $fontSize = (int) round($size * 0.48);

        $svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {$size} {$size}' width='{$size}' height='{$size}'>"
            ."<rect width='{$size}' height='{$size}' rx='{$rx}' fill='{$encodedColor}'/>"
            ."<text x='50%' y='54%' dominant-baseline='middle' text-anchor='middle' fill='%23ffffff' font-family='Plus Jakarta Sans, -apple-system, sans-serif' font-size='{$fontSize}' font-weight='700'>{$initial}</text>"
            .'</svg>';

        return 'data:image/svg+xml;utf8,'.$svg;
    }
}
