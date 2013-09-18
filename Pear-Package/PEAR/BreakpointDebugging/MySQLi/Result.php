<?php

/**
 * This file can make error handling of MySQLi_Result without writing a code by including.
 *
 * Note: I ignore error of following of "PHP_CodeSniffer" because this class is overriding.
 *       Method name "<class name>::<method name>" is not in camel caps format
 *
 * PHP version 5.3
 *
 * LICENSE OVERVIEW:
 * 1. Do not change license text.
 * 2. Copyrighters do not take responsibility for this file code.
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
 * @package  BreakpointDebugging_MySQLi
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/BreakpointDebugging/MySQLi
 */

namespace BreakpointDebugging;

require_once __DIR__ . '/../MySQLi.php'; // This set php.ini of MySQLi.
/**
 * This is wrapper class of MySQLi_Result class.
 *
 * @category PHP
 * @package  BreakpointDebugging_MySQLi
 * @author   Hidenori Wasa <public@hidenori-wasa.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/BreakpointDebugging/MySQLi
 */
class MySQLi_Result_InAllCase extends \BreakpointDebugging_OverrideClass
{
    /**
     * @var string Native class name ( This fixes the variable name ). This is using a delay lexical binding for purpose that class objects becomes separate names in basic class.
     */
    protected static $pr_nativeClassName = '\MySQLi_Result';

    /**
     * @var int The change pointer to "MySQLi" class object. (ID)
     */
    private $_pr_pMySqlI;

    /**
     * @var bool Did this close?
     */
    protected $pr_isClose = false;

    /**
     * Constructor for override.
     *
     * @param object $pNativeClass "\MySQLi_Result" native class.
     * @param object $pMySqlI      "\BreakpointDebugging\MySQLi" class.
     */
    function __construct($pNativeClass, $pMySqlI)
    {
        // This will be able to override without inheriting to a native class.
        parent::__construct($pNativeClass);
        $this->_pr_pMySqlI = $pMySqlI;
    }

    /**
     * Destructor for close.
     */
    function __destruct()
    {
        // When not closed.
        if (!$this->pr_isClose) {
            $this->close();
        }
    }

    private function _throwError()
    {
        throw new MySQLi_Error_Exception(B::convertMbString($this->_pr_pMySqlI->pNativeClass->error), $this->_pr_pMySqlI->pNativeClass->errno);
    }

    /**
     * Rapper method of "MySQLi_Result::close()" for error handling.
     *
     * @return Same.
     */
    function close()
    {
        $this->pNativeClass->close();
        // Enable close flag.
        $this->pr_isClose = true;
    }

    /**
     * Rapper method of "MySQLi_Result::free()" for error handling.
     *
     * @return Same.
     */
    function free()
    {
        $this->close();
    }

    /**
     * Rapper method of "MySQLi_Result::free_result()" for error handling.
     *
     * @return Same.
     */
    function free_result()
    {
        $this->close();
    }

    /**
     * Rapper method of "MySQLi_Result::data_seek()" for error handling.
     *
     * @param int $offset Same.
     *
     * @return void
     */
    function data_seek($offset)
    {
        if (!$this->pNativeClass->data_seek($offset)) {
            $this->_throwError();
        }
    }

    /**
     * Rapper method of "MySQLi_Result::fetch_field_direct()" for error handling.
     *
     * @param int $fieldNumber Same.
     *
     * @return Same.
     */
    function fetch_field_direct($fieldNumber)
    {
        $return = $this->pNativeClass->fetch_field_direct($fieldNumber);
        if (!$return) {
            $this->_throwError();
        }
        return $return;
    }

    /**
     * Rapper method of "MySQLi_Result::fetch_fields()" for error handling.
     *
     * @return Same.
     */
    function fetch_fields()
    {
        $return = $this->pNativeClass->fetch_fields();
        if (!$return) {
            $this->_throwError();
        }
        return $return;
    }

    /**
     * Rapper method of "MySQLi_Result::field_seek()" for error handling.
     *
     * @param int $fieldNumber Same.
     *
     * @return void
     */
    function field_seek($fieldNumber)
    {
        if (!$this->pNativeClass->field_seek($fieldNumber)) {
            $this->_throwError();
        }
    }

}

use \BreakpointDebugging as B;

if (B::getStatic('$exeMode') & B::RELEASE) { // In case of release.
    /**
     * This is empty class for release mode.
     * This class detail is 'Result_InDebug.php' file.
     *
     * @category PHP
     * @package  BreakpointDebugging_MySQLi
     * @author   Hidenori Wasa <public@hidenori-wasa.com>
     * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
     * @version  Release: @package_version@
     * @link     http://pear.php.net/package/BreakpointDebugging/MySQLi
     */

    class MySQLi_Result extends MySQLi_Result_InAllCase
    {

    }

} else { // In case of not release.
    include_once __DIR__ . '/Result_InDebug.php';
}

?>
