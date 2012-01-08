<?php

/**
 * This class override a class without inheritance, but only public member can be inherited.
 * 
 * If you use IntelliSense, should not you extend native class because it is c class. Then debugger may freeze.
 * Also a class like "MySQLi_Result" should not extend because __construct() signature is fixed, and it is difficult to make derived class.
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

/* ### Sample code ###
<?php

namespace Your_Name;

require_once './BreakpointDebugging_MySetting.php';

// This defines an override class in namespace by the class name ( For example: NativeClass ) which is the same as the native class.
class NativeClass extends \Validate_MySQLi_OverrideClass
{
    protected static $pr_nativeClassName = '\NativeClass'; // Native class name ( Variable name is fixed ).
    public static $staticProperty; // The static property must code by the same name.
    
    function __construct()
    {
        // This creates a native class object.
        $pNativeClass = self::newArray(self::$pr_nativeClassName, func_get_args());
        // This is the code to override a class without inheritance.
        parent::__construct($pNativeClass);
        // This refers to a static property.
        self::$staticProperty = &self::$pr_nativeClassName::$staticProperty;
    }
}
*/

/* ### How to override method which takes reference parameter arguments of variable length. ###
For example, how to call function. => $retValue = override_function_name(array (&$param1, &$param2));
Then, function definition. =>
function override_function_name()
{
    $refParams = func_get_arg(0);
    assert(func_num_args() == 1);
    assert(is_array($refParams));
    
    // How to call a function by parameter array.
    $return = call_user_func_array('override_function_name'), $refParams);
    assert($return !== false);
    
    // How to call an parent object ( dynamic ) method by parameter array.
    $return = call_user_func_array(array ('parent', 'override_function_name'), $refParams);
    assert($return !== false);
    
    // How to call a parent static method by parameter array.
    $return = forward_static_call_array(array ('parent', 'override_function_name'), $refParams);
    assert($return !== false);
    
    // How to call a parent constructor by parameter array.
    $return = forward_static_call_array(array ('parent', '__construct'), func_get_args());
    assert($return !== false);
}
*/

require_once './BreakpointDebugging_MySetting.php';

/**
 * This class override a class without inheritance, but only public member can be inherited.
 * 
 * @category PHP
 * @package  Validate_MySQLi
 * @author   Hidenori Wasa <wasa_@nifty.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD 2-Clause
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Validate/MySQLi
 */
class Validate_MySQLi_OverrideClass
{
    /**
     * @var object Native class object
     */
    public $pr_pNativeClass;
    
    /**
     * @var array This sends parameters to eval().
     */
    static $tmpParams;
    
    /**
     * This constructor holds native class object.
     * 
     * @param object $pNativeClass Native class object
     * 
     * @return void
     */
    function __construct($pNativeClass)
    {
        $this->pr_pNativeClass = $pNativeClass;
    }
    
    /**
     * This is magic method which gets auto property to have been not defined.
     * 
     * @param string $propertyName Property name
     * 
     * @return mixed Property value
     */
    final function __get($propertyName)
    {
        assert(property_exists($this->pr_pNativeClass, $propertyName));
        return $this->pr_pNativeClass->$propertyName;
    }
    
    /**
     * This is magic method which sets auto property to have been not defined.
     * 
     * @param string $propertyName Property name
     * @param mixed  $setValue     Value to set
     * 
     * @return void
     */
    final function __set($propertyName, $setValue)
    {
        assert(property_exists($this->pr_pNativeClass, $propertyName));
        $this->pr_pNativeClass->$propertyName = $setValue;
    }
    
    /**
     * This is magic method which calls auto method not to have been defined.
     * 
     * @param string $methodName Method name
     * @param array  $params     Parameter array
     * 
     * @return mixed Method return value
     */
    final function __call($methodName, $params)
    {
        // caution: Method taking reference parameter must code because those method cannot handle.
        //          Then, in case of the variable length parameter, method must change signature.
        //          For example, How to call MySQLi_STMT::bind_param().
        //              bind_param(array ($format, &$variable1, &$variable2));
        return call_user_func_array(array ($this->pr_pNativeClass, $methodName), $params);
    }
    
    /**
     * This is magic method which calls static method to have been not defined.
     * 
     * @param string $methodName Method name
     * @param array  $params     Parameter array
     * 
     * @return mixed Method return value
     */
    final static function __callStatic($methodName, $params)
    {
        static $nativeClassName;
        
        $nativeClassName = static::$pr_nativeClassName;
        if (count($params) < 2) {
            return $nativeClassName::$methodName($params);
        }
        return $nativeClassName::$methodName(explode(',', $params));
    }
    
    /**
     * This executes "new" by parameter array.
     * 
     * @param string $className Class name
     * @param array  $params    Parameter array
     * 
     * @return object Created object
     * 
     * @example $pNativeClass = self::newArray('\class_name', func_get_args());
     *           $pNativeClass = self::newArray('\class_name', array ($object, $resource, &$reference));
     */
    final static function newArray($className, $params)
    {
        assert(is_string($className));
        
        self::$tmpParams = $params;
        $paramNumber = count($params);
        $paramString = array ();
        $propertyNameToSend = 'Validate_MySQLi_OverrideClass::$tmpParams';
        for ($count = 0; $count < $paramNumber; $count++) {
            $paramString[] = $propertyNameToSend . '[' . $count . ']';
        }
        return eval('return new ' . $className . '(' . implode(',', $paramString) . ');');
    }
}

?>