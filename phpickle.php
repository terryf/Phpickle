<?php
require_once "phpickle_unpickle.php";

class phpickle
{
	static public function loads($str)
	{
		$i = new phpickle_unpickle();
		return $i->loads($str);
	}

	static public function load_stream($url)
	{
		$i = new phpickle_unpickle();
		return $i->unpickle_stream(new phpickle_stream($url));
	}

	static public function loads_django_session($str)
	{
		$i = new phpickle_unpickle();
		return $i->loads_django_session($str);
	}
}

/*$i = new phpickle_unpickle();
$i->set_debug(true);
var_dump($i->loads("(i__main__\ntest\np0\n(dp1\nS'a'\np2\nI5\nsS'c'\np3\n(I1\nI2\nI3\nI4\nI5\nI6\ntp4\nsS'b'\np5\ng2\nsS'ref'\np6\n(i__main__\ntest\np7\n(dp8\ng5\nS'in f'\np9\nsbsb."));*/
