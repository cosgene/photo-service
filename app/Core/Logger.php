<?php

class Logger
{
    private static function path()
    {
        // всегда корень проекта
        return dirname(__DIR__, 2) . '/public/logs/';
    }

    private static function ensureDir()
    {
        $dir = self::path();

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    public static function log($file, $data)
    {
        $dir = self::ensureDir();
        $path = $dir . $file;

        $time = date('Y-m-d H:i:s');

        if (is_array($data) || is_object($data)) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $line = "[$time] " . $data . PHP_EOL;

        file_put_contents($path, $line, FILE_APPEND | LOCK_EX);
    }
}
