<?php

// This is a sample which create MySQL database and table.

namespace Your_Name;

use \BreakpointDebugging as B;

// Create MySQL class object.
$pMySqlI = new B\MySQLi('localhost', 'root', 'wasapass');
// Create database.
$pMySqlI->query('CREATE DATABASE IF NOT EXISTS `example_db`');
// Create another database.
$pMySqlI->query('CREATE DATABASE IF NOT EXISTS `example_db2`');
// Connect with created database.
$pMySqlI->change_user('root', 'wasapass', 'example_db');
// Create table.
$pMySqlI->query(
    'CREATE TABLE IF NOT EXISTS `country_language` (' .
    '  `Id` int(11) NOT NULL AUTO_INCREMENT,' .
    '  `Percentage` tinyint(4) DEFAULT NULL,' .
    '  `CountryCode` tinyint(4) DEFAULT NULL,' .
    '  `CustomerName` char(6) DEFAULT NULL,' .
    '  `binary_large_object` longblob,' .
    '  PRIMARY KEY (`Id`)' .
    ') ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;');
// Create table data.
$pMySqlI->set_charset('utf8');
$pMySqlI->query('INSERT INTO `country_language` (`Id`, `Percentage`, `CountryCode`, `CustomerName`, `binary_large_object`) VALUES(1, 49, 11, \'α\', 0x41) ON DUPLICATE KEY UPDATE `Id` = 1;');
$pMySqlI->query('INSERT INTO `country_language` (`Id`, `Percentage`, `CountryCode`, `CustomerName`, `binary_large_object`) VALUES(2, 50, 22, \'β\', 0x4142) ON DUPLICATE KEY UPDATE `Id` = 2;');
$pMySqlI->query('INSERT INTO `country_language` (`Id`, `Percentage`, `CountryCode`, `CustomerName`, `binary_large_object`) VALUES(3, 51, 33, \'∞\', 0x414243) ON DUPLICATE KEY UPDATE `Id` = 3;');
// Close database connection.
$pMySqlI->close();
