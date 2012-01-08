<?php

/**
 * This file can make error handling of MySQLi without writing a code by including.
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

require_once __DIR__ . '/MySQLi/OverrideClass.php';

global $_BreakpointDebugging_EXE_MODE;

B::iniCheck('mysqli.max_persistent', '-1', 'This is different from the default. This is recommended to set "php.ini" file to "mysqli.max_persistent = -1".');
B::iniCheck('mysqli.allow_local_infile', '1', 'This is different from the default. This is recommended to set "php.ini" file to "mysqli.allow_local_infile = On".');
B::iniCheck('mysqli.allow_persistent', '1', 'This is different from the default. This is recommended to set "php.ini" file to "mysqli.allow_persistent = On".');
B::iniCheck('mysqli.max_links', '-1', 'This is different from the default. This is recommended to set "php.ini" file to "mysqli.max_links = -1".');
// "mysqli.cache_size" follows it because it is server setting.
// "mysqli.default_port" follows setting of server so as not to catch on fire wall.
// "mysqli.default_socket" follows it because it is server setting.
// "mysqli.default_host" follows it because it is server setting.
// "mysqli.default_user" follows it because it is server setting.
B::iniSet('mysqli.default_pw', ''); // This doesn't use because "mysqli.default_pw" is stolen.
B::iniCheck('mysqli.reconnect', '', 'This is different from the default. This is recommended to set "mysqli.reconnect = Off" inside of "php.ini" file.');

/**
 * This class is own package exception.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_Exception extends \BreakpointDebugging_Exception
{
}

/**
 * This class is own package query exception.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_Query_Exception extends MySQLi_Exception
{
}

/**
 * This class is own package query warning exception.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_Query_Warning_Exception extends MySQLi_Query_Exception
{
}

/**
 * This class is own package query error exception.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_Query_Error_Exception extends MySQLi_Query_Exception
{
}

/**
 * This class is own package connect exception.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_Connect_Exception extends MySQLi_Exception
{
}

/**
 * This class is own package warning exception.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_Warning_Exception extends MySQLi_Exception
{
}

/**
 * This class is own package error exception.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_Error_Exception extends MySQLi_Exception
{
}

/**
 * This is wrapper class of MySQLi class for error handling.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class MySQLi_InAllCase extends \Validate_MySQLi_OverrideClass
{
    /**
     * @var string Native class name( Variable name is fixed ).
     */
    protected static $pr_nativeClassName = '\MySQLi';
    
    /**
     * @var bool Is this closed?
     */
    protected $pr_isClose = false;
    
    /**
     * This throws "MySQLi_Query_Error_Exception".
     * 
     * @return void
     */
    private function _throwQueryErrorException()
    {
        throw new MySQLi_Query_Error_Exception(B::convertMbString($this->pr_pNativeClass->error), $this->pr_pNativeClass->errno);
    }
    
    /**
     * This throws "MySQLi_Error_Exception".
     * 
     * @return void
     */
    function throwErrorException()
    {
        throw new MySQLi_Error_Exception(B::convertMbString($this->pr_pNativeClass->error), $this->pr_pNativeClass->errno);
    }
    
    /**
     * If there is a "MySQLi" query warning, it throw "MySQLi_Query_Warning_Exception".
     * 
     * @return void
     */
    private function _checkWarning()
    {
        // The number of warnings which except connection of MySQLi class
        if ($this->pr_pNativeClass->warning_count) {
            if ($pResult = $this->pr_pNativeClass->query('SHOW WARNINGS')) {
                $warnings = $pResult->fetch_all(MYSQLI_ASSOC);
                $pResult->close();
                foreach ($warnings as $warning) {
                    if ($warning['Level'] == 'Note') {
                        continue;
                    } else if ($warning['Level'] == 'Warning') {
                        throw new MySQLi_Query_Warning_Exception(B::convertMbString($warning['Message']), $warning['Code']);
                    } else {
                        assert(false);
                    }
                }
            }
        }
    }
    
    /**
     * Constructor for override
     */
    function __construct()
    {
        // This creates a native class object.
        $pNativeClass = self::newArray(self::$pr_nativeClassName, func_get_args());
        // Connection check
        if ($pNativeClass->connect_errno) {
            throw new MySQLi_Connect_Exception(B::convertMbString($pNativeClass->connect_error), $pNativeClass->connect_errno);
        }
        // This becomes overriding without inheritance of native class ( extension module class ).
        parent::__construct($pNativeClass);
    }
    
    /**
     * Destructor for close
     */
    function __destruct()
    {
        // When not closed
        if (!$this->pr_isClose) {
            $this->close();
        }
    }
    
    /**
     * Rapper method of "MySQLi::query()" for error handling
     * 
     * @param string $query      Same
     * @param int    $resultMode Same
     * 
     * @return object \Validate\MySQLi_Result
     */
    function query($query, $resultMode = MYSQLI_STORE_RESULT)
    {
        $result = $this->pr_pNativeClass->query($query, $resultMode);
        if ($result === false) { // In case of error.
            $this->_throwQueryErrorException();
        }
        $this->_checkWarning();
        if ($result === true) {
            return true;
        }
        return new MySQLi_Result($result, $this);
    }
    
    /**
     * Rapper method of "MySQLi::close()" for error handling
     * 
     * @return void
     */
    function close()
    {
        if (!$this->pr_pNativeClass->close()) {
            $this->throwErrorException();
        }
        // This enables a close flag.
        $this->pr_isClose = true;
    }

    /**
     * Rapper method of "MySQLi::change_user()" for error handling
     * 
     * @param string $user     Same
     * @param string $password Same
     * @param string $database Same
     * 
     * @return void
     */
    function change_user($user, $password, $database)
    {
        if (!$this->pr_pNativeClass->change_user($user, $password, $database)) {
            $this->throwErrorException();
        }
    }
    
    /**
     * Rapper method of "MySQLi::real_connect()" for error handling
     * 
     * @return void
     */
    function real_connect()
    {
        call_user_func_array(array($this->pr_pNativeClass, 'real_connect'), func_get_args());
        // Connection check
        if ($this->pr_pNativeClass->connect_errno) {
            throw new MySQLi_Connect_Exception(B::convertMbString($this->pr_pNativeClass->connect_error), $this->pr_pNativeClass->connect_errno);
        }
    }
    
    /**
     * Rapper method of "MySQLi::kill()" for error handling
     * 
     * @param int $processid Same
     * 
     * @return void
     */
    function kill($processid)
    {
        if (!$this->pr_pNativeClass->kill($processid)) {
            $this->throwErrorException();
        }
    }
    
    /**
     * Rapper method of "MySQLi::ping()" for error handling
     * 
     * @return void
     */
    function ping()
    {
        if (!$this->pr_pNativeClass->ping()) {
            $this->throwErrorException();
        }
    }
    
    /**
     * Rapper method of "MySQLi::poll()" for reference parameter
     * 
     * @param array &$read   Same.
     * @param array &$error  Same.
     * @param array &$reject Same.
     * @param int   $sec     Same.
     * @param int   $usec    Same.
     * 
     * @return Same.
     */
    function poll(&$read, &$error, &$reject, $sec, $usec = 0)
    {
        return $this->pr_pNativeClass->poll($read, $error, $reject, $sec, $usec);
    }
    
    /**
     * Rapper method of "MySQLi::reap_async_query()" for error handling
     * 
     * @return object \Validate\MySQLi_Result
     */
    function reap_async_query()
    {
        $pResult = $this->pr_pNativeClass->reap_async_query();
        if ($pResult === false) {
            $this->_throwQueryErrorException();
        }
        return new MySQLi_Result($pResult, $this);
    }
    
    /**
     * Rapper method of "MySQLi::prepare()" for error handling
     * 
     * @param string $query Same
     * 
     * @return object \Validate\MySQLi_STMT
     */
    function prepare($query)
    {
        $pStmt = $this->pr_pNativeClass->prepare($query);
        assert($pStmt !== false);
        return new MySQLi_STMT($pStmt, $this);
    }
    
    /**
     * Rapper method of "MySQLi::select_db()" for error handling
     * 
     * @param string $database Same
     * 
     * @return void
     */
    function select_db($database)
    {
        if (!$this->pr_pNativeClass->select_db($database)) {
            $this->throwErrorException();
        }
    }
    
    /**
     * Rapper method of "MySQLi::stmt_init()" for error handling
     * 
     * @return object \Validate\MySQLi_STMT
     */    
    function stmt_init()
    {
        return new MySQLi_STMT($this->pr_pNativeClass->stmt_init(), $this);
    }
    
    /**
     * Rapper method of "MySQLi::store_result()" for error handling
     * 
     * @return object \Validate\MySQLi_Result
     */
    function store_result()
    {
        if (!$this->pr_pNativeClass->field_count) {
            return false;
        }
        $result = $this->pr_pNativeClass->store_result();
        if ($result === false) {
            $this->_throwQueryErrorException();
        }
        return new MySQLi_Result($result, $this);
    }
    
    /**
     * Rapper method of "MySQLi::use_result()" for error handling
     * 
     * @return object \Validate\MySQLi_Result
     */
    function use_result()
    {
        if (!$this->pr_pNativeClass->field_count) {
            return false;
        }
        $result = $this->pr_pNativeClass->use_result();
        if ($result === false) {
            $this->_throwQueryErrorException();
        }
        return new MySQLi_Result($result, $this);
    }
}

if ($_BreakpointDebugging_EXE_MODE & B::RELEASE) { // In case of release.
    /**
     * This is empty class for release mode.
     * This class detail is 'MySQLi_Option.php' file.
     * 
     * @category PHP
     * @package  Validate_MySQLi
     * @author   Hidenori Wasa <wasa_@nifty.com>
     * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
     * @version  Release: @package_version@
     * @link     http://pear.php.net/package/Validate/MySQLi
     */
    class MySQLi extends MySQLi_InAllCase
    {
    }
} else { // In case of not release.
    include_once __DIR__ . '/MySQLi_Option.php';
}

?>