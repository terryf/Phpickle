<?php
require_once "phpickle_unpickle.php";
require_once "phpickle_pickle.php";

class phpickle
{
	/** unpickles data from string $str, returns it **/
	static public function loads($str)
	{
		$i = new phpickle_unpickle();
		return $i->loads($str);
	}

	/** unpickles data from stream with url $url, returns it **/
	static public function load_stream($url)
	{
		$i = new phpickle_unpickle();
		return $i->unpickle_stream(new phpickle_stream($url));
	}

	/** unpickles data serialized to django session **/
	static public function loads_django_session($str)
	{
		$i = new phpickle_unpickle();
		return $i->loads_django_session($str);
	}

	/** pickles data given in $data into returned string 
	* $proto, optional, specifies the pickle format to use. defaults to latest. 0 is non-binary. 
	**/
	static public function dumps($data, $proto = -1)
	{
		$i = new phpickle_pickle();
		return $i->dumps($data, $proto);
	}
}

