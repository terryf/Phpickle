<?php
require_once "../phpickle.php";
require_once "test_data.php";

class phpickle_pickleTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider data
	**/
	public function test1($pickle, $data, $ver)
	{
		$u = new phpickle_pickle();
		$u->set_debug(true);
		$my_pickled = $u->dumps($data, $ver);

		$my_unpickled = phpickle::loads($my_pickled);
		if ($data != $my_unpickled)
		{
			echo "\r\npickle : ",var_dump($pickle),"\r\n";
			echo "result : ",var_dump($my_pickled),"\r\n";
			echo "data   : ",var_dump($data),"\r\n";
			echo "my_data: ",var_dump($my_unpickled),"\r\n";
			echo "proto : $ver\r\n";
			echo "\r\n\r\n--------------\r\n\r\n";
		}
		//$this->assertEquals($d, $pickle);
		$this->assertEquals($data, $my_unpickled);
	}

	public function data()
	{
		return test_data::get();
	}
}
