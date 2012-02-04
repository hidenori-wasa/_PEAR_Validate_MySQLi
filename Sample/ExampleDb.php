<?php

// This is a sample which create MySQL database and table.

namespace Your_Name;

require_once './BreakpointDebugging_MySetting.php';

// Create MySQL class object.
$mySqlI = new \Validate\MySQLi();
// Set MySQL option.
$mySqlI->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
// Connect with MySQL.
$mySqlI->real_connect('localhost', 'root', 'wasapass');
// Create database.
$mySqlI->query('CREATE DATABASE IF NOT EXISTS `example_db`');
// Create another database.
$mySqlI->query('CREATE DATABASE IF NOT EXISTS `example_db2`');
// Connect with created database.
$mySqlI->change_user('root', 'wasapass', 'example_db');
// Create table.
$mySqlI->query(
    'CREATE TABLE IF NOT EXISTS `country_language` ( ' .
    '`Id` INT AUTO_INCREMENT, PRIMARY KEY ( `Id` ASC), ' .
    '`Percentage` TINYINT, ' .
    '`CountryCode` TINYINT, ' .
    '`CustomerName` CHAR( 6), ' .
    '`binary_large_object` LONGBLOB) ' .
    'ENGINE = MyISAM ' .
    'ROW_FORMAT = FIXED ');
// Create table data.
$mySqlI->query('INSERT `country_language` SET `Id` = 1, `Percentage` = 49, `CountryCode` = 11, `CustomerName` = \'α\', `binary_large_object` = \'A\' ON DUPLICATE KEY UPDATE `Id` = 1');
$mySqlI->query('INSERT `country_language` SET `Id` = 2, `Percentage` = 50, `CountryCode` = 22, `CustomerName` = \'β\', `binary_large_object` = \'AB\' ON DUPLICATE KEY UPDATE `Id` = 2');
$mySqlI->query('INSERT `country_language` SET `Id` = 3, `Percentage` = 51, `CountryCode` = 33, `CustomerName` = \'∞\', `binary_large_object` = \'ABC\' ON DUPLICATE KEY UPDATE `Id` = 3');
// Close database connection.
$mySqlI->close();

?>
