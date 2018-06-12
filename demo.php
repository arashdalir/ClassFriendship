<?php
namespace Test;

include "vendor/autoload.php";

use ArashDalir\ClassFriendship\Friends;
use ArashDalir\ClassFriendship\FriendshipTypes;

class A{
	use Friends;

	protected $parameter;

	function __construct() {
		static::addFriendship(B::class, FriendshipTypes::CAN_READ|FriendshipTypes::CAN_WRITE);
	}
}

class B{
	function testFriendship(){
		$a = new A();

		$a->parameter = "B can access this!";

		print_r($a);
	}
}

class C{
	function testFriendship()
	{
		$a = new A();

		$a->parameter = "C cannot access this! this will throw NotFriendsException";

		print_r($a);
	}
}

$b = new B();
$c = new C();

$b->testFriendship();
$c->testFriendship();