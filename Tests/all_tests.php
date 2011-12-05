<?php
require_once('simpletest/unit_test.php');
require_once('simpletest/reporter.php');

$test= &new GroupTest('All tests');
$test->addTestFile('log_test.php');
$test->run(new HtmlReporter());


?>