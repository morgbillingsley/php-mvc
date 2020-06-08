<?php

namespace Core;

use Core\Utils\StringModifier;
use Exception;

class App
{
    protected $controller;
    protected $controllerName = "Home";
    protected $methodName = "index";
    protected $parameterNames = array();

    public function __construct() {
        $path = $this->getCleanUrlPath();
        $this->setControllerNameFromPath($path);
        $this->setMethodNameFromPath($path);
        $this->setParameterNamesFromPath($path);
    }

    public function run()
    {
        $this->setController();
        if (method_exists($this->controller, $this->methodName)) {
            call_user_func_array([$this->controller, $this->methodName], $this->parameterNames);
        } else {
            throw new Exception("The route cannot be found");
        }
    }

    private function getCleanUrlPath()
    {
        $path = strtok($_SERVER["REQUEST_URI"], "?");
        return rtrim($path, "/");
    }

    private function setControllerNameFromPath($path)
    {
        if ($this->pathHasControllerName($path)) {
            $rawControllerName = $this->getControllerNameFromPath($path);
            $controllerString = new StringModifier($rawControllerName);
            $this->controllerName = $controllerString->pascal();
        }
    }

    private function pathHasControllerName(string $path)
    {
        $parts = explode("/", $path);
        return isset($parts[0]) && !empty($parts[0]);
    }

    private function getControllerNameFromPath(string $path)
    {
        $parts = explode("/", $path);
        return $parts[0];
    }

    private function setMethodNameFromPath(string $path)
    {
        if ($this->pathHasMethodName($path)) {
            $this->methodName = $this->getMethodNameFromPath($path);
        }
    }

    private function pathHasMethodName(string $path)
    {
        $parts = explode("/", $path);
        return isset($parts[1]);
    }

    private function getMethodNameFromPath(string $path)
    {
        $parts = explode("/", $path);
        return $path[1];
    }

    private function setParameterNamesFromPath(string $path)
    {
        if ($this->pathHasParameterNames($path)) {
            $this->parameterNames = $this->getParameterNamesFromPath($path);
        }
    }

    private function pathHasParameterNames(string $path)
    {
        $parts = explode("/", $path);
        return isset($path[2]);
    }

    private function getParameterNamesFromPath(string $path)
    {
        $parts = explode("/", $path);
        $firstParameterNameIndex = 2;
        $numberOfParameterNames = count($parts) - $firstParameterNameIndex;
        return array_slice($parts, $firstParameterNameIndex, $numberOfParameterNames);
    }

    private function controllerExists()
    {
        $controllerFilePath = CONTROLLER_DIR . "/{$this->controllerName}.php";
        return file_exists($controllerFilePath);
    }

    private function setController()
    {
        if ($this->controllerExists()) {
            $this->includeController();
            $controllerClassName = "\\Controllers\\" . $this->controllerName;
            $this->controller = new $controllerClassName();
        } else {
            throw new Exception("The controller cannot be found.");
        }
    }

    private function includeController()
    {
        require_once CONTROLLER_DIR . "/{$this->controllerName}.php";
    }
}

?>