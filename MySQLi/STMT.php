<?php

/**
 * This file can make error handling of MySQLi_STMT without writing a code by including.
 * 
 * Note: I ignore error of following of "PHP_CodeSniffer" because this class is overriding.
 *       Method name "<class name>::<method name>" is not in camel caps format
 * 
 * PHP version 5.3
 * 
 * LICENSE:
 * Copyright (c) 2012, Hidenori Wasa
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the distribution.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Validate/MySQLi
 */

namespace Validate;

// File to have "use" keyword does not inherit scope into a file including itself,
// also it does not inherit scope into a file including,
// and moreover "use" keyword alias has priority over class definition,
// therefore "use" keyword alias does not be affected by other files.
use \BreakpointDebugging as B;

require_once __DIR__ . '/../MySQLi.php'; // This set php.ini of MySQLi.

global $_BreakpointDebugging_EXE_MODE;

/**
 * This is wrapper class of MySQLi_STMT class.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_STMT_For_Debug_And_Release extends \Validate_MySQLi_OverrideClass
{
    /**
     * @var string Native class name ( This fixes the variable name ). This is using a delay lexical binding for purpose that class objects becomes separate names in basic class.
     */
    protected static $pr_nativeClassName = '\MySQLi_STMT';
    
    /**
     * @var int The change pointer to "MySQLi" class object. (ID)
     */
    private $_pr_pMySqlI;
    
    /**
     * @var bool Did this close?
     */
    protected $pr_isClose = false;
    
    /**
     * This throws "MySQLi_Error_Exception".
     * 
     * @return void
     */
    private function _throwErrorException()
    {
        throw new MySQLi_Error_Exception(B::convertMbString($this->pr_pNativeClass->error), $this->pr_pNativeClass->errno);
    }
    
    /**
     * If there is a "MySQLi_STMT" query warning, it throw "MySQLi_Query_Warning_Exception".
     * 
     * @return void
     */
    private function _checkWarning()
    {
        $warnings = $this->pr_pNativeClass->get_warnings();
        if ($warnings !== false) {
            if ($result = $this->_pr_pMySqlI->query('SHOW WARNINGS')) {
                $warnings = $result->fetch_all(MYSQLI_ASSOC);
                $result->close();
                foreach ($warnings as $warning) {
                    if ($warning['Level'] === 'Note') {
                        continue;
                    } else if ($warning['Level'] === 'Warning') {
                        //throw new MySQLi_Query_Warning_Exception(B::convertMbString($warning['Message']), $warning['Code']);
                        MySQLi::throwException('\Validate\MySQLi_Query_Warning_Exception', $warning['Message'], (int)$warning['Code']);
                    } else {
                        assert(false);
                    }
                }
            }
        }
    }
    
    /**
     * Constructor for override
     * 
     * @param object $pNativeClass "\MySQLi_STMT" native class
     * @param object $pMySqlI      "\Validate\MySQLi" class
     */
    function __construct($pNativeClass, $pMySqlI)
    {
        // This will be able to override without inheriting to a native class.
        parent::__construct($pNativeClass);
        $this->_pr_pMySqlI = $pMySqlI;
    }
    
    /**
     * Destructor for close
     */
    function __destruct()
    {
        // In case of not closing
        if (!$this->pr_isClose) {
            $this->close();
        }
    }
    
    /**
     * Rapper method of "MySQLi_STMT::bind_param()" for a variable length reference parameter
     * The warning: Signature is different because this is a variable length reference parameter.
     * 
     * @param array $refParams Reference parameters
     * 
     * @return void
     */
    function bind_param($refParams)
    {
        return call_user_func_array(array($this->pr_pNativeClass, 'bind_param'), $refParams);
    }
    
    /**
     * Rapper method of "MySQLi_STMT::execute()" for error handling
     * 
     * @return void
     */
    function execute()
    {
        if (!$this->pr_pNativeClass->execute()) {
            $this->_throwErrorException();
        }
        $this->_checkWarning();
    }
    
    /**
     * Rapper method of "MySQLi_STMT::bind_result()" for a variable length reference parameter
     * The warning: Signature is different because this is a variable length reference parameter.
     * 
     * @param array $refParams Reference parameters
     * 
     * @return Same
     */
    function bind_result($refParams)
    {
        return call_user_func_array(array($this->pr_pNativeClass, 'bind_result'), $refParams);
    }
    
    /**
     * Rapper method of "MySQLi_STMT::fetch()" for error handling
     * 
     * @return Same
     */
    function fetch()
    {
        $row = $this->pr_pNativeClass->fetch();
        if ($row === false) {
            $this->_throwErrorException();
        }
        return $row;
    }
    
    /**
     * Rapper method of "MySQLi_STMT::close()" for verification
     * 
     * @return Same
     */
    function close()
    {
        // This closed.
        $this->pr_isClose = true;
        return $this->pr_pNativeClass->close();
    }
    
    /**
     * Rapper method of "MySQLi_STMT::store_result()" for error handling
     * 
     * @return void
     */
    function store_result()
    {
        if (!$this->pr_pNativeClass->store_result()) {
            $this->_throwErrorException();
        }
    }
    
    /**
     * Rapper method of "MySQLi_STMT::send_long_data()" for error handling
     * 
     * @param int    $paramNumber The prepared statement parameter number (0-)
     * @param string $sendData    Data to send to the prepared statement parameter
     * 
     * @return void
     */
    function send_long_data($paramNumber, $sendData)
    {
        static $maxAllowedPacket = null;
        
        if ($maxAllowedPacket === null) {
            // This acquires "max_allowed_packet" ( maximum packet size ) of MySQL system variable.
            $result = $this->_pr_pMySqlI->query('SHOW VARIABLES LIKE \'max_allowed_packet\'');
            $resultArray = $result->fetch_row();
            $maxAllowedPacket = (int)$resultArray[1];
            $result->close();
        }
        if (strlen($sendData) > $maxAllowedPacket) {
            $this->_throwErrorException();
        }
        if (!$this->pr_pNativeClass->send_long_data($paramNumber, $sendData)) {
            $this->_throwErrorException();
        }
    }
    
    /**
     * Rapper method of "MySQLi_STMT::result_metadata()" for error handling
     * 
     * @return \Validate\MySQLi_Result
     */
    function result_metadata()
    {
        // The change pointer to "\mysqli_result" class object. (=ID). It isn't possible to return a derivation class.
        $pMysqliResult = $this->pr_pNativeClass->result_metadata();
        if (!$pMysqliResult) {
            //throw new MySQLi_Query_Error_Exception(B::convertMbString($this->pr_pNativeClass->error), $this->pr_pNativeClass->errno);
            MySQLi::throwException('\Validate\MySQLi_Query_Error_Exception', $this->pr_pNativeClass->error, $this->pr_pNativeClass->errno);
        }
        return new MySQLi_Result($pMysqliResult, $this->_pr_pMySqlI);
    }
    
    /**
     * Rapper method of "MySQLi_STMT::reset()" for error handling
     * 
     * @return void
     */
    function reset()
    {
        if (!$this->pr_pNativeClass->reset()) {
            $this->_throwErrorException();
        }
    }
}

if ($_BreakpointDebugging_EXE_MODE & B::RELEASE) { // In case of release.
    /**
     * This is empty class for release mode.
     * This class detail is 'STMT_Option.php' file.
     * 
     * @category PHP
     * @package  Validate_MySQLi
     * @author   Hidenori Wasa <wasa_@nifty.com>
     * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
     * @version  Release: @package_version@
     * @link     http://pear.php.net/package/Validate/MySQLi
     */
    class MySQLi_STMT extends MySQLi_STMT_For_Debug_And_Release
    {
    }
} else { // In case of not release.
    include_once __DIR__ . '/STMT_Option.php';
}

?>
