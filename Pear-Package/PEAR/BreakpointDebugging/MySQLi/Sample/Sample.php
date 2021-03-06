<?php

namespace Your_Name;

use \BreakpointDebugging as B;

$projectDirPath = str_repeat('../', preg_match_all('`/`xX', $_SERVER['PHP_SELF'], $matches) - 2);
chdir(__DIR__ . '/' . $projectDirPath);
require_once './BreakpointDebugging_Inclusion.php';
require_once __DIR__ . '/ExampleDb.php';

B::checkExeMode(); // Checks the execution mode.

$htmlFileContent = <<<EOD
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>SAMPLE</title>
    </head>
    <body style="background-color: black; color: white; font-size: 25px">
        <pre></pre>
    </body>
</html>
EOD;
B::windowVirtualOpen('BreakpointDebugging_MySQLi', $htmlFileContent);
ob_start();

$testNumber = 1;

// Connect database.
$pMySqlI = new B\MySQLi('localhost', 'root', 'wasapass', 'example_db');
if ($testNumber === 1) {
    // Execute safe query, then display results.
    try {
        // $inputPercentage = '＋5０ OR 1=1'; // User input value ( DOS attack ). This quoted from MySQL manual.
        $inputPercentage = '＋5０';
        $inputCustomerName = 'β OR 1=1'; // User input value ( DOS attack ). This quoted from MySQL manual.
        // $inputCustomerName = 'β';
        $result = $pMySqlI->safeQuery('SELECT Percentage, CustomerName FROM country_language WHERE ( Percentage >= ?) OR ( CustomerName = ?)', 'is', $inputPercentage, $inputCustomerName);
    } catch (B\MySQLi_Query_Exception $exception) {
        echo 'Input value is mistake.';
        throw $exception;
    }
    while ($field = $result->fetch_array()) {
        var_dump($field);
    }
    $result->close();
} else if ($testNumber === 2) {
    // Creates prepared statement ( the SQL sentence which was prepared for the parameter embedding ).
    $pMySqlIStatement = $pMySqlI->prepare('SELECT Percentage, CustomerName FROM country_language WHERE Percentage >= ?');
    // User input value ( DOS attack ). This quoted from MySQL manual.
    // $inputPercentage = '＋5０ OR 1=1'; // User input value ( DOS attack ). This quoted from MySQL manual.
    $inputPercentage = '＋5０';
    // Bind up a parameter to prepared statement marker ('?').
    // $pMySqlIStatement->bind_param(array('i', &$inputPercentage));
    $pMySqlIStatement->safeBindParam(array ('i', &$inputPercentage));
    // $pMySqlIStatement->bind_param(array('i', &$inputPercentage));
    // Execute query.
    $pMySqlIStatement->execute();
    // Construct columns-attribute-results-set by prepared statement.
    echo 'mysqli_stmt::result_metadata()<br/>';
    $pResult = $pMySqlIStatement->result_metadata();
    // Return columns-attribute-results-set by prepared statement.
    echo 'mysqli_result::fetch_field()';
    while ($return = $pResult->fetch_field()) {
        var_dump($return);
    }
    // Close results-set.
    $pResult->close();
    // Store result to a buffer.
    $pMySqlIStatement->store_result();
    // Bind up the result columns to variables.
    $pMySqlIStatement->bind_result(array (&$resultPercentage, &$resultCustomerName));
    echo 'mysqli_stmt::fetch()';
    while (true) {
        // Acquires result per row.
        $pResult = $pMySqlIStatement->fetch();
        if ($pResult === true) { // In case of success.
            // Display result.
            var_dump($resultPercentage, $resultCustomerName);
        } else if ($pResult === null) { // When there is not result row of the remainder.
            break;
        } else {
            assert(false);
        }
    }
    // Free up result of buffer.
    $pMySqlIStatement->free_result();
    // Close prepared statement.
    $pMySqlIStatement->close();
}
// Close database connection.
$pMySqlI->close();
echo 'END';

B::windowHtmlAddition('BreakpointDebugging_MySQLi', 'pre', 0, ob_get_clean());

?>
