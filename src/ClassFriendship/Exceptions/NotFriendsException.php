<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 08-May-18
 * Time: 10:57
 */

namespace ArashDalir\ClassFriendship\Exceptions;

class NotFriendsException extends \Exception{
	function __construct($class_a, $class_b)
	{
		parent::__construct("Class \"{$class_b}\" is not a friend of class \"{$class_a}\".", 0);
	}
}