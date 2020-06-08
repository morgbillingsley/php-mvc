<?php

namespace Core;

use Exception;
use JsonException;

class BaseController
{
    public function sendPlainText(string $text, int $httpCode = 200)
    {
        http_response_code($httpCode);
        self::printPlainText($text);
    }
    
    private static function printPlainText(string $text)
    {
        header("Content-Type: text/plain");
        echo($text);
    }

    public function sendJson($data, int $httpCode = 200)
    {
        try {
            http_response_code($httpCode);
            self::printJsonData($data);
        } catch (JsonException $e) {
            $this->sendPlainText("Sorry, we had trouble processing your request", 500);
        }
    }

    private static function printJsonData($data)
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        header("Content-Type: application/json");
        echo($json);
    }

    public function showView(string $name)
    {
        if ($this->viewExists($name)) {
            $this->includeView($name);
        } else {
            throw new Exception("The view <b>$name</b> could not be found at <b>$path</b>");
        }
    }

    private function viewExists(string $name)
    {
        return file_exists(VIEW_DIR . "/$name.php");
    }

    private function includeView(string $name)
    {
        require_once VIEW_DIR . "/$name.php";
    }
}

?>