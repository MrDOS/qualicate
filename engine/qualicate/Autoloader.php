<?php namespace qualicate;

class Autoloader
{
    private $classpath;

    public function __construct($classpath)
    {
        if (substr($classpath, -1) !== '/')
            $classpath .= '/';
        $this->classpath = $classpath;
    }

    public function load($class)
    {
        $class = str_replace('\\', '/', $class);
        if (is_readable($this->classpath . $class . '.php'))
            include $this->classpath . $class . '.php';
    }
}
