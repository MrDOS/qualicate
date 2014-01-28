<?php

/* * * * * * * * * * * * * * * * * * * * * *
 *            Q U A L I C A T E            *
 *                                         *
 * User verification by knowledge testing. *
 * * * * * * * * * * * * * * * * * * * * * */

require_once 'engine/qualicate/Autoloader.php';
spl_autoload_register(array(new \qualicate\Autoloader('engine'), 'load'));
spl_autoload_register(array(new \qualicate\Autoloader('tests'), 'load'));

$test_manager = new \qualicate\TestManager('tests.json');
$current_test = $test_manager->currentTest();

$page = new \qualicate\Template('templates/page.html');

if (!empty($_POST))
{
    if ($current_test->validate($_POST))
    {
        $success_message = $current_test->successMessage();
        $body = new \qualicate\Template('templates/success.html',
                    ['message' => $success_message]);

        if ($test_manager->hasNextTest())
        {
            $body->set('has_next', true);
            $test_manager->nextTest();

            if (empty($success_message))
                header('Location: ' . $_SERVER['PHP_SELF']);
        }
        else
        {
            $body->set('has_next', false);
            session_destroy();
        }
    }
    else
    {
        $body = new \qualicate\Template('templates/failure.html',
                    ['message' => $current_test->failureMessage()]);
    }
}
else
{
    $body = $current_test->description($_SERVER['PHP_SELF']);
}

$page->set('body', $body);
$page->display();