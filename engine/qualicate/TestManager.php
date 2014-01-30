<?php namespace qualicate;

class TestManager
{
    private $tests;

    public function __construct($tests_filename)
    {
        if (!is_readable($tests_filename))
            throw new \Exception('Inaccessible tests file');

        $this->tests = json_decode(file_get_contents('tests.json'));
        if (!is_array($this->tests))
            throw new \Exception('Tests file contained bobcat, not tests');

        session_start();

        if (!isset($_SESSION['_q_test']) && count($this->tests) > 0)
            $this->instantiateCurrentTest($this->tests[0]);
    }

    private function instantiateCurrentTest($test_name)
    {
        $_SESSION['_q_test'] = new $test_name;
    }

    public function currentTest()
    {
        return $_SESSION['_q_test'];
    }

    private function currentTestIndex()
    {
        return array_search(get_class($_SESSION['_q_test']), $this->tests);
    }

    public function hasNextTest()
    {
        $current_test_index = $this->currentTestIndex();
        return ($current_test_index !== false
            && $current_test_index < count($this->tests) - 1);
    }

    public function nextTest()
    {
        $current_test_index = $this->currentTestIndex();
        if ($current_test_index === false
            || $current_test_index >= count($this->tests) - 1)
            return null;

        $this->instantiateCurrentTest($this->tests[$current_test_index + 1]);
        return $this->currentTest();
    }
}