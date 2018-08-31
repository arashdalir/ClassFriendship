<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 07-May-18
 * Time: 15:29
 */

namespace ArashDalir\ClassFriendship;

use ArashDalir\ClassFriendship\Exceptions\InvalidPropertyException;
use ArashDalir\ClassFriendship\Exceptions\NotFriendsException;

trait Friends{
	static protected $friends_list = array();

	static function addFriendship($class, $friendship_type)
	{
		static::$friends_list[$class] = $friendship_type;
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 * @throws NotFriendsException
	 */
	function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 * @throws NotFriendsException
	 */
	function get($key)
	{
		$a = static::getCallerClass();
		if(static::isFriendsWith($a, FriendshipTypes::CAN_READ))
		{
			return $this->$key;
		}
		else
		{
			throw new NotFriendsException(static::class, $a);
		}
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return Friends
	 * @throws InvalidPropertyException
	 * @throws NotFriendsException
	 */
	function __set($key, $value)
	{
		return $this->set($key, $value);
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return Friends
	 * @throws NotFriendsException
	 * @throws InvalidPropertyException
	 */
	function set($key, $value)
	{
		$a = static::getCallerClass();
		if(static::isFriendsWith($a, FriendshipTypes::CAN_WRITE))
		{
			if($key != "friends_list" && property_exists($this, $key))
			{
				$this->$key = $value;
				return $this;
			}
			else
			{
				throw new InvalidPropertyException($key, static::class);
			}
		}
		else
		{
			throw new NotFriendsException(static::class, $a);
		}
	}

	/**
	 *
	 * @param int $depth - indicates which caller in call-stack has to be considered for friendship -
	 *                   DEFAULT: 3 -> getCaller() is called in __set and __get functions, which go through set() and get(), which means the real caller was 3 levels higher than current backtrace location
	 *
	 * @return mixed
	 */
	function getCallerClass($depth = 3)
	{
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $depth + 1);
		return $backtrace[$depth]["class"];
	}

	function isFriendsWith($class, $friendship_type)
	{
		if ($class === static::class)
		{
			return true;
		}

		if(is_array(static::$friends_list))
		{
			foreach(static::$friends_list as $friend => $type)
			{
				if($friend === $class || is_subclass_of($class, $friend))
				{
					if(static::$friends_list[$friend]&$friendship_type)
					{
						return true;
					}
				}
			}
		}

		return false;
	}
}