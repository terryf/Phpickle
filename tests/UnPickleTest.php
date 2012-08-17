<?php
include "../phpickle.php";

class phpickle_unpickleTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider data
	**/
	public function test1($pickle, $expected)
	{
//		echo "pickle: '$pickle', expected: '",var_dump($expected),"'\r\n\r\n";
//		$d = phpickle::loads($pickle);
		$u = new phpickle_unpickle();
//		$u->set_debug(true);
		$d = $u->loads($pickle);
//		echo " result: ",var_dump($d)," \r\n\r\n--------------\r\n\r\n";
		$this->assertEquals($d, $expected);
	}

	/**
	* @dataProvider data
	**/
	public function test_if($pickle, $expected)
	{
		$d = phpickle::loads($pickle);
		$this->assertEquals($d, $expected);

		file_put_contents("test.tmp", $pickle);
		$d = phpickle::load_stream("test.tmp");
		unlink("test.tmp");
		$this->assertEquals($d, $expected);

		$d = phpickle::loads_django_session($this->djangofy($pickle));
		$this->assertEquals($d, $expected);

	}

	public function djangofy($str)
	{
		$hash = md5($str);
		return base64_encode($hash.":".$str);
	}

	/**
	* @dataProvider data2
	**/
	public function test2($pickle, $expected)
	{
/*		echo "pickle: '$pickle', expected: '",var_dump($expected),"'\r\n\r\n";
		$u = new phpickle_unpickle();
//		$u->set_debug(true);
		$d = $u->loads_django_session($pickle);
//		echo " result: ",var_dump($d)," \r\n\r\n--------------\r\n\r\n";
		$this->assertEquals($d, $expected);*/
	}

	public function data()
	{
		$inst = new stdClass();
		$i2 = new stdClass();
		$i2->__python_class__ = "__main__.test";
		$i2->__python_construct_args__ = array();
		$i2->b = "in f";
	
		$inst->__python_class__ = "__main__.test";
		$inst->__python_construct_args__ = array();
		$inst->a = 5;
		$inst->c = array(1,2,3,4,5,6);
		$inst->b = "a";
		$inst->ref = $i2;

		return array(
		/*1*/	array("I1\n.", 1),
		/*2*/	array("K\x01.", 1),
		/*3*/	array("\x80\x02K\x01.", 1),
		/*4*/	array("S'a'\np0\n.", "a"),
		/*5*/	array("U\x01aq\x00.", "a"),
		/*6*/	array("\x80\x02U\x01aq\x00.", "a"),
		/*7*/	array("(lp0\nI1\naI2\naS'a'\np1\na.", array(1,2,'a')),
		/*8*/	array("]q\x00(K\x01K\x02U\x01aq\x01e.", array(1,2,'a')),
		/*9*/	array("\x80\x02]q\x00(K\x01K\x02U\x01aq\x01e.", array(1,2,'a')),
		/*10*/	array("(dp0\nS'a'\np1\nS'b'\np2\nsS'c'\np3\nS'd'\np4\ns.", array("a" => "b", "c" => "d")),
		/*11*/	array("}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03U\x01dq\x04u.", array("a" => "b", "c" => "d")),
		/*12*/	array("\x80\x02}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03U\x01dq\x04u.", array("a" => "b", "c" => "d")),
		/*13*/	array("\x80\x02}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03}q\x04(U\x01dq\x05U\x01eq\x06U\x01fq\x07U\x01gq\x08uu.", array("a" => "b", "c" => array("d" => "e", "f" => "g"))),
		/*14*/	array("}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03}q\x04(U\x01dq\x05U\x01eq\x06U\x01fq\x07U\x01gq\x08uu.", array("a" => "b", "c" => array("d" => "e", "f" => "g"))),
		/*15*/	array("(dp0\nS'a'\np1\nS'b'\np2\nsS'c'\np3\n(dp4\nS'd'\np5\nS'e'\np6\nsS'f'\np7\nS'g'\np8\nss.", array("a" => "b", "c" => array("d" => "e", "f" => "g"))),
		/*16*/	array("(dp0\nS'a'\np1\nI1\nsS'b'\np2\n(dp3\ng1\nI1\nsg2\n(dp4\ng1\nI2\nsss.", array("a" => 1, "b" => array("a" => 1, "b" => array("a" => 2)))),
		/*17*/	array("}q\x00(U\x01aq\x01K\x01U\x01bq\x02}q\x03(h\x01K\x01h\x02}q\x04h\x01K\x02suu.", array("a" => 1, "b" => array("a" => 1, "b" => array("a" => 2)))),
		/*18*/	array("\x80\x02}q\x00(U\x01aq\x01K\x01U\x01bq\x02}q\x03(h\x01K\x01h\x02}q\x04h\x01K\x02suu.", array("a" => 1, "b" => array("a" => 1, "b" => array("a" => 2)))),
		/*19*/	array("(I1\nI2\nI3\nI4\ntp0\n.", array(1, 2, 3, 4)),
		/*20*/	array("(K\x01K\x02K\x03K\x04tq\x00.", array(1, 2, 3, 4)),
		/*21*/	array("\x80\x02(K\x01K\x02K\x03K\x04tq\x00.", array(1, 2, 3, 4)),
		/*22*/	array("\x80\x02(K\x01K\x02K\x03K\x04]q\x00(K\x05K\x06}q\x01K\x07K\x08setq\x02.", array(1,2,3,4,array(5,6,array(7 => 8)))),
		/*23*/	array("(I1\nI2\nI3\nI4\n(lp0\nI5\naI6\na(dp1\nI7\nI8\nsatp2\n.", array(1,2,3,4,array(5,6,array(7 => 8)))),
		/*24*/	array("F9.1234000000000002\n.", 9.1234),
		/*25*/	array("\x80\x02G@\"?.H\xe8\xa7\x1e.", 9.1234),
		/*26*/	array("G@\"?.H\xe8\xa7\x1e.", 9.1234),
		/*27*/	array("J]\xd1\x12\x00.", 1233245),
		/*28*/	array("]q\x00(I01\nI00\nK\x01e.", array(true, false, 1)),
		/*29*/	array("L1233245L\n.", 1233245),
		/*30*/	array("\x80\x02\x8a\x03]\xd1\x12.", 1233245),
		/*31*/	array("\x80\x02M`\xea.", 60000),
		/*32*/	array("M`\xea.", 60000),
		/*33*/	array("I60000\n.", 60000),
		/*34*/	array("N.", null),
		/*35*/	array("\x80\x02U\x0fbinary \x00 stringq\x00.", "binary \x00 string"),
		/*36*/	array("U\x0fbinary \x00 stringq\x00.", "binary \x00 string"),
		/*37*/	array("S'binary \\x00 string'\np0\n.", "binary \x00 string"),
		/*38*/	array("(dp0\nS'a'\np1\nS'sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj'\np2\nsI1\nI2\nsI3\nI4\nsI5\nI6\ns.", array(1 => 2, 3 => 4, 5 => 6, "a" => "sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj")),
		/*39*/	array("}q\x00(U\x01aq\x01U(sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkjq\x02K\x01K\x02K\x03K\x04K\x05K\x06u.", array(1 => 2, 3 => 4, 5 => 6, "a" => "sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj")),
		/*40*/	array("\x80\x02}q\x00(U\x01aq\x01U(sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkjq\x02K\x01K\x02K\x03K\x04K\x05K\x06u.", array(1 => 2, 3 => 4, 5 => 6, "a" => "sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj")),
		/*41*/	array("(i__main__\ntest\np0\n(dp1\nS'a'\np2\nI5\nsS'c'\np3\n(I1\nI2\nI3\nI4\nI5\nI6\ntp4\nsS'b'\np5\ng2\nsS'ref'\np6\n(i__main__\ntest\np7\n(dp8\ng5\nS'in f'\np9\nsbsb.", $inst),
		);
	}

	public function data2()
	{
		return array(
			array("NDk5ODVmYTVhY2Q4YThiMmZjOTZmY2Y5OGJmMWUzZmY3OWE4Zjg5YTqAAn1xAVUTcXVlc3Rpb25fdmlld190aW1lc3ECfXEDSwNjZGF0ZXRpbWUKZGF0ZXRpbWUKcQRVCgfcCA4BOwwL1OaFUnEFc3Mu", array()),
			array("Mzc3ZjJkODc3ZDBlZjY0YTEyMzU5ZTYwMzRhZWMwMmUyNmE4MTMzNTqAAn1xAShVEl9hdXRoX3VzZXJfYmFja2VuZHECVRdteC53ZWIuYXV0aC5BdXRoQmFja2VuZHEDVQ1fYXV0aF91c2VyX2lkcQRLA1UJX21lc3NhZ2VzcQVdcQYoY2RqYW5nby5jb250cmliLm1lc3NhZ2VzLnN0b3JhZ2UuYmFzZQpNZXNzYWdlCnEHKYFxCH1xCShVCmV4dHJhX3RhZ3NxCk5VB21lc3NhZ2VxC1V2VGhlIHBvc3QgIkhvdyBmYXN0IGlzIHNvbGFyIHBvd2VyIGVmZmljaWVuY3kgZHJvcHBpbmcgb24gYSBidW95IGR1ZSB0byBwYW5lbCBjb250YW1pbmF0aW9uPyIgd2FzIGNoYW5nZWQgc3VjY2Vzc2Z1bGx5LnEMVQVsZXZlbHENSxR1YmgHKYFxDn1xDyhoClgAAAAAaAtYDQEAAFRoZSBwb3N0ICJXaGF0IG9mZmxpbmUgdG9vbHMgYXJlIHV0aWxpemVkIGJ5IHRoZSBtYXJpbmUgdGVjaG5vbG9neSBhbmQgc2NpZW50aWZpYyBjb21tdW5pdGllcyBmb3IgZGF0YSBhZ2dyZWdhdGlvbiwgYW5hbHlzaXMsIGFuZCB2aXN1YWxpemF0aW9uPyBXaGF0IGRhdGEgZm9ybWF0cyBhcmUgbW9zdCBjb21tb24gbm93PyBXaGF0IGRhdGEgZm9ybWF0cyBhcmUgbGlrZWx5IHRvIGJlIG1vc3QgY29tbW9uIGluIDItMyB5cnM/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucRBoDUsUdWJoBymBcRF9cRIoVQpleHRyYV90YWdzcRNYAAAAAFUHbWVzc2FnZXEUWG4AAABUaGUgcG9zdCAiSG93IGNhbiB3ZSBpbXByb3ZlIHRoZSBvYnNlcnZhdGlvbiBvZiByZWdpb25zIG9mIGRpdmVyZ2VuY2UgaW4gdGhlIG9jZWFuPyIgd2FzIGNoYW5nZWQgc3VjY2Vzc2Z1bGx5LnEVVQVsZXZlbHEWSxR1YmgHKYFxF31xGChVCmV4dHJhX3RhZ3NxGVgAAAAAVQdtZXNzYWdlcRpYTwAAAFRoZSBwb3N0ICJIb3cgZG8geW91IGhhbmRsZSBtaXNzaW5nIGRhdGEgZnJvbSBidW95cz8iIHdhcyBjaGFuZ2VkIHN1Y2Nlc3NmdWxseS5xG1UFbGV2ZWxxHEsUdWJoBymBcR19cR4oVQpleHRyYV90YWdzcR9YAAAAAFUHbWVzc2FnZXEgWEMAAABUaGUgcG9zdCAiSG93IGFyZSByb2d1ZSB3YXZlcyBwcmVkaWN0ZWQ/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucSFVBWxldmVscSJLFHViaAcpgXEjfXEkKFUKZXh0cmFfdGFnc3ElWAAAAABVB21lc3NhZ2VxJlhmAAAAVGhlIHBvc3QgIldoYXQgaXMgdGhlIHZhbHVlIG9mIG9jZWFuIGZvcmVjYXN0cyBpbiBvcGVyYXRpb25hbCBvY2Vhbm9ncmFwaHk/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucSdVBWxldmVscShLFHViaAcpgXEpfXEqKFUKZXh0cmFfdGFnc3ErWAAAAABVB21lc3NhZ2VxLFhmAAAAVGhlIHBvc3QgIldoYXQgaXMgdGhlIHZhbHVlIG9mIG9jZWFuIGZvcmVjYXN0cyBpbiBvcGVyYXRpb25hbCBvY2Vhbm9ncmFwaHk/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucS1VBWxldmVscS5LFHViZXUu", array())
		);
	}
}
