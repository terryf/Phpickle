<?php
require_once "../phpickle.php";
require_once "test_data.php";

class phpickle_unpickleTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider data
	**/
	public function test1($pickle, $expected, $ver)
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
	public function test_if($pickle, $expected, $ver)
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
//		error_reporting(E_ALL);
//		ini_set("display_errors", "1");
//		echo "pickle: '$pickle', expected: '",var_dump($expected),"'\r\n\r\n";
		$u = new phpickle_unpickle();
//		$u->set_debug(true);
		$d = $u->loads_django_session($pickle);
//		echo " result: ",var_dump($d)," \r\n\r\n--------------\r\n\r\n";
//		echo "ser: ".serialize($d)."\r\n";;
		$this->assertEquals($d, $expected);
	}

	public function data()
	{
		return test_data::get();
	}

	public function data2()
	{
		return array(
			array("NDk5ODVmYTVhY2Q4YThiMmZjOTZmY2Y5OGJmMWUzZmY3OWE4Zjg5YTqAAn1xAVUTcXVlc3Rpb25fdmlld190aW1lc3ECfXEDSwNjZGF0ZXRpbWUKZGF0ZXRpbWUKcQRVCgfcCA4BOwwL1OaFUnEFc3Mu", unserialize('a:1:{s:19:"question_view_times";a:1:{i:3;N;}}')),
			array("Mzc3ZjJkODc3ZDBlZjY0YTEyMzU5ZTYwMzRhZWMwMmUyNmE4MTMzNTqAAn1xAShVEl9hdXRoX3VzZXJfYmFja2VuZHECVRdteC53ZWIuYXV0aC5BdXRoQmFja2VuZHEDVQ1fYXV0aF91c2VyX2lkcQRLA1UJX21lc3NhZ2VzcQVdcQYoY2RqYW5nby5jb250cmliLm1lc3NhZ2VzLnN0b3JhZ2UuYmFzZQpNZXNzYWdlCnEHKYFxCH1xCShVCmV4dHJhX3RhZ3NxCk5VB21lc3NhZ2VxC1V2VGhlIHBvc3QgIkhvdyBmYXN0IGlzIHNvbGFyIHBvd2VyIGVmZmljaWVuY3kgZHJvcHBpbmcgb24gYSBidW95IGR1ZSB0byBwYW5lbCBjb250YW1pbmF0aW9uPyIgd2FzIGNoYW5nZWQgc3VjY2Vzc2Z1bGx5LnEMVQVsZXZlbHENSxR1YmgHKYFxDn1xDyhoClgAAAAAaAtYDQEAAFRoZSBwb3N0ICJXaGF0IG9mZmxpbmUgdG9vbHMgYXJlIHV0aWxpemVkIGJ5IHRoZSBtYXJpbmUgdGVjaG5vbG9neSBhbmQgc2NpZW50aWZpYyBjb21tdW5pdGllcyBmb3IgZGF0YSBhZ2dyZWdhdGlvbiwgYW5hbHlzaXMsIGFuZCB2aXN1YWxpemF0aW9uPyBXaGF0IGRhdGEgZm9ybWF0cyBhcmUgbW9zdCBjb21tb24gbm93PyBXaGF0IGRhdGEgZm9ybWF0cyBhcmUgbGlrZWx5IHRvIGJlIG1vc3QgY29tbW9uIGluIDItMyB5cnM/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucRBoDUsUdWJoBymBcRF9cRIoVQpleHRyYV90YWdzcRNYAAAAAFUHbWVzc2FnZXEUWG4AAABUaGUgcG9zdCAiSG93IGNhbiB3ZSBpbXByb3ZlIHRoZSBvYnNlcnZhdGlvbiBvZiByZWdpb25zIG9mIGRpdmVyZ2VuY2UgaW4gdGhlIG9jZWFuPyIgd2FzIGNoYW5nZWQgc3VjY2Vzc2Z1bGx5LnEVVQVsZXZlbHEWSxR1YmgHKYFxF31xGChVCmV4dHJhX3RhZ3NxGVgAAAAAVQdtZXNzYWdlcRpYTwAAAFRoZSBwb3N0ICJIb3cgZG8geW91IGhhbmRsZSBtaXNzaW5nIGRhdGEgZnJvbSBidW95cz8iIHdhcyBjaGFuZ2VkIHN1Y2Nlc3NmdWxseS5xG1UFbGV2ZWxxHEsUdWJoBymBcR19cR4oVQpleHRyYV90YWdzcR9YAAAAAFUHbWVzc2FnZXEgWEMAAABUaGUgcG9zdCAiSG93IGFyZSByb2d1ZSB3YXZlcyBwcmVkaWN0ZWQ/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucSFVBWxldmVscSJLFHViaAcpgXEjfXEkKFUKZXh0cmFfdGFnc3ElWAAAAABVB21lc3NhZ2VxJlhmAAAAVGhlIHBvc3QgIldoYXQgaXMgdGhlIHZhbHVlIG9mIG9jZWFuIGZvcmVjYXN0cyBpbiBvcGVyYXRpb25hbCBvY2Vhbm9ncmFwaHk/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucSdVBWxldmVscShLFHViaAcpgXEpfXEqKFUKZXh0cmFfdGFnc3ErWAAAAABVB21lc3NhZ2VxLFhmAAAAVGhlIHBvc3QgIldoYXQgaXMgdGhlIHZhbHVlIG9mIG9jZWFuIGZvcmVjYXN0cyBpbiBvcGVyYXRpb25hbCBvY2Vhbm9ncmFwaHk/IiB3YXMgY2hhbmdlZCBzdWNjZXNzZnVsbHkucS1VBWxldmVscS5LFHViZXUu", unserialize('a:3:{s:18:"_auth_user_backend";s:23:"mx.web.auth.AuthBackend";s:13:"_auth_user_id";i:3;s:9:"_messages";a:7:{i:0;O:8:"stdClass":5:{s:4:"args";a:0:{}s:5:"class";O:8:"stdClass":2:{s:16:"__python_class__";s:44:"django.contrib.messages.storage.base.Message";s:20:"__python_pickle_op__";s:6:"GLOBAL";}s:10:"extra_tags";N;s:7:"message";s:118:"The post "How fast is solar power efficiency dropping on a buoy due to panel contamination?" was changed successfully.";s:5:"level";i:20;}i:1;O:8:"stdClass":5:{s:4:"args";a:0:{}s:5:"class";r:7;s:10:"extra_tags";s:0:"";s:7:"message";s:269:"The post "What offline tools are utilized by the marine technology and scientific communities for data aggregation, analysis, and visualization? What data formats are most common now? What data formats are likely to be most common in 2-3 yrs?" was changed successfully.";s:5:"level";i:20;}i:2;O:8:"stdClass":5:{s:4:"args";a:0:{}s:5:"class";r:7;s:10:"extra_tags";s:0:"";s:7:"message";s:110:"The post "How can we improve the observation of regions of divergence in the ocean?" was changed successfully.";s:5:"level";i:20;}i:3;O:8:"stdClass":5:{s:4:"args";a:0:{}s:5:"class";r:7;s:10:"extra_tags";s:0:"";s:7:"message";s:79:"The post "How do you handle missing data from buoys?" was changed successfully.";s:5:"level";i:20;}i:4;O:8:"stdClass":5:{s:4:"args";a:0:{}s:5:"class";r:7;s:10:"extra_tags";s:0:"";s:7:"message";s:67:"The post "How are rogue waves predicted?" was changed successfully.";s:5:"level";i:20;}i:5;O:8:"stdClass":5:{s:4:"args";a:0:{}s:5:"class";r:7;s:10:"extra_tags";s:0:"";s:7:"message";s:102:"The post "What is the value of ocean forecasts in operational oceanography?" was changed successfully.";s:5:"level";i:20;}i:6;O:8:"stdClass":5:{s:4:"args";a:0:{}s:5:"class";r:7;s:10:"extra_tags";s:0:"";s:7:"message";s:102:"The post "What is the value of ocean forecasts in operational oceanography?" was changed successfully.";s:5:"level";i:20;}}}'))
		);
	}
}
