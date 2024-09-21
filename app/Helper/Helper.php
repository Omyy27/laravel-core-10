<?php
if (!function_exists("save_laravel_log")) {
    function save_laravel_log(string $path, $msg, string $type = 'info')
    {
        $now = new DateTime("now", new DateTimeZone('America/Bogota'));
        $file = storage_path("logs/{$path}.log");
        if (!file_exists($file)) {
            if (!file_exists(storage_path('logs'))) {
                mkdir(storage_path('logs'), 0755, true);
            }
            touch($file);
        }
        $log_msg = file_get_contents($file);
        $type = strtoupper($type);
        $log_msg .= "[{$now->format('Y-m-d H:i:s')}] {$type}: {$msg} \n";
        file_put_contents($file, $log_msg);
    }
}
