<?php

// This is a sample which create MySQL database and table.

namespace Your_Name;

// Create MySQL class object.
$pMySqlI = new \BreakpointDebugging\MySQLi('localhost', 'root', 'wasapass');
// Create database.
$pMySqlI->query('CREATE DATABASE IF NOT EXISTS `example_db`');
// Create another database.
$pMySqlI->query('CREATE DATABASE IF NOT EXISTS `example_db2`');
// Connect with created database.
$pMySqlI->change_user('root', 'wasapass', 'example_db');
// Create table.
$pMySqlI->query(
    'CREATE TABLE IF NOT EXISTS `country_language` ( ' .
    '`Id` INT AUTO_INCREMENT, PRIMARY KEY ( `Id` ASC), ' .
    '`Percentage` TINYINT, ' .
    '`CountryCode` TINYINT, ' .
    '`CustomerName` CHAR( 6), ' .
    '`binary_large_object` LONGBLOB) ' .
    'ENGINE = MyISAM ' .
    'ROW_FORMAT = FIXED ');
// Create table data.
$pMySqlI->query('INSERT `country_language` SET `Id` = 1, `Percentage` = 49, `CountryCode` = 11, `CustomerName` = \'α\', `binary_large_object` = \'A\' ON DUPLICATE KEY UPDATE `Id` = 1');
$pMySqlI->query('INSERT `country_language` SET `Id` = 2, `Percentage` = 50, `CountryCode` = 22, `CustomerName` = \'β\', `binary_large_object` = \'AB\' ON DUPLICATE KEY UPDATE `Id` = 2');
$pMySqlI->query('INSERT `country_language` SET `Id` = 3, `Percentage` = 51, `CountryCode` = 33, `CustomerName` = \'∞\', `binary_large_object` = \'ABC\' ON DUPLICATE KEY UPDATE `Id` = 3');
// Close database connection.
$pMySqlI->close();

?>
