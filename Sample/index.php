<?php

namespace Your_Name;

require_once './ExampleDb.php';

// Connect database.
$mySqlI = new \Validate\MySQLi('localhost', 'root', 'wasapass', 'example_db');
// Creates prepared statement ( the SQL sentence which was prepared for the parameter embedding ).
$mySqlIStatement = $mySqlI->prepare('SELECT Percentage, CustomerName FROM country_language WHERE ( Percentage >= ?) OR ( CustomerName LIKE ?)');
// User input value ( DOS attack )
$inputPercentage = '50 OR 1=1';
$inputCustomerName = '_ASA OR 1=1';
// Escapes ( SQL scripting attack measure ) the MySQL special character of user input value, and set value to the bound variables.
$percentage = $mySqlI->real_escape_string($inputPercentage);
$customerName = $mySqlI->real_escape_string($inputCustomerName);
// Bind up a parameter to prepared statement marker ('?').
$mySqlIStatement->bind_param(array('is', &$percentage, &$customerName));
// Execute query.
$mySqlIStatement->execute();
// Construct columns-attribute-results-set by prepared statement.
echo 'mysqli_stmt::result_metadata()<br/>';
$result = $mySqlIStatement->result_metadata();
// Return columns-attribute-results-set by prepared statement.
echo 'mysqli_result::fetch_field()';
while ($return = $result->fetch_field()) {
    var_dump($return);
}
// Close results-set.
$result->close();
// Store result to a buffer.
$mySqlIStatement->store_result();
// Bind up the result columns to variables.
$mySqlIStatement->bind_result(array(&$resultPercentage, &$resultCustomerName));
echo 'mysqli_stmt::fetch()';
while (true) {
    // Acquires result per row.
    $result = $mySqlIStatement->fetch();
    if ($result === true) { // In case of success
        // Display result.
        var_dump($resultPercentage, $resultCustomerName);
    } else if ($result === null) { // When there is not result row of the remainder
        break;
    } else if ($result === false) { // In case of error
        fn_trigger_error($mySqlIStatement->error);
    } else {
        assert(false);
    }
}
// Free up result of buffer.
$mySqlIStatement->free_result();
// Close prepared statement.
$mySqlIStatement->close();
// Close database connection.
$mySqlI->close();

?>
