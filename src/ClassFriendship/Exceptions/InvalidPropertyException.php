<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 16-May-18
 * Time: 11:47
 */

namespace ArashDalir\ClassFriendship\Exceptions;

class InvalidPropertyException extends \Exception{
	function __construct($property_name, $class)
	{
		parent::__construct("Invalid property \"{$property_name}\" for config of type \"{$class}\".");
	}
}