<?php

namespace App\Http\Controllers\Traits;

trait RestActions
{
    public function respond($state, $data = [], $error = null, $message = "", $log = true): array
    {
        if ($log && $state != 200) {
            $path = "warnings-caught-" . now()->format("Y-m-d");
            save_laravel_log($path, json_encode($error));
        }
        return [
            "state" => $state, //response status
            "data" => $data, //response data
            "error" => $error, //bug for developer
            "message" => $message //user message
        ];
    }

    public function respond_exception($e, $options = []): array
    {
        $data = [
            "data" => $options["data"] ?? null,
            "trace" => $e->getTrace()
        ];

        $error = "File: " . $e->getFile() . " | Line: " . $e->getLine() . " | Message: " . $e->getMessage();
        $message = "";

        if (isset($options["message"])) {
            $message = $options["message"];
        }

        if(isset($options["class"]) && is_array($options["class"])) {
            $class = (object) $options["class"];
            $name = $class->name ?? "";
            $id = $class->id ?? "";
            $error = "object<$name> : id <$id> <-- $error";
        }

        $path = "errors-caught-" . now()->format("Y-m-d");
        save_laravel_log($path, json_encode($error));

        return [
            "state" => 500, //response status
            "data" => $data, //response data
            "error" => $error, //bug for developer
            "message" => $message //user message
        ];
    }
}
