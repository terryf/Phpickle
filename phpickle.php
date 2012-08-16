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