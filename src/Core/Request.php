<?php

namespace Paw\Core;

class Request
{
    public function uri()
    {
        return ltrim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');
    }

    public function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function route(){
        return [
            "uri" => $this->uri(),
            "method" => $this->method()
        ];
    }

    public function post(string $key, $default = null)
    {
        if (!isset($_POST[$key])) {
            return $default;
        }
        return is_string($_POST[$key])
            ? trim($_POST[$key])
            : $_POST[$key];
    }

    public function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    public function json(): array
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        return is_array($data) ? $data : [];
    }

    public function allPost(): array
    {
        $clean = [];
        foreach ($_POST as $k => $v) {
            $clean[$k] = is_string($v) ? trim($v) : $v;
        }
        return $clean;
    }

}

?>