<?php


if (!function_exists('getCourseDetailIcon')) {
    function getCourseDetailIcon($key)
    {
        $icons = [
            'Duration' => 'time',
            'Viewers' => 'eye',
            'Lectures' => 'files',
            'Students' => 'user',
            'Certificate' => 'medall',
            'Level' => 'menu-alt',
            'Skill level' => 'stats-up',
            'Language' => 'world', // Default extra example
        ];
        
        return $icons[$key] ?? 'info'; // Fallback icon if key is not found
    }
}
