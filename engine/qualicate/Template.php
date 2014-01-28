<?php namespace qualicate;

class Template
{
    private $filename;
    private $values;

    public function __construct($filename, $values = [])
    {
        if (!is_readable($filename))
            throw new \Exception('Inaccessible template file');
        $this->filename = $filename;
        $this->values = $values;
    }

    public function __toString()
    {
        ob_start();
        $this->display();
        return ob_get_clean();
    }

    public function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function setAll($values)
    {
        $this->values = $values;
    }

    public function display()
    {
        extract($this->values);
        include $this->filename;
    }
}