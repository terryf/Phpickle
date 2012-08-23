<?php
require_once "../phpickle_stream.php";

class phpickle_streamTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider data
	**/
	public function testGetLine(phpickle_stream $stream)
	{
		$line = $stream->get_line();
		$this->assertTrue($line != false);

		$stream->unget_line();

		$line2 = $stream->get_line();
		$this->assertTrue($line2 != false);

		$this->assertEquals($line, $line2);
	}

	/**
	* @dataProvider data
	**/
	public function testGetChar(phpickle_stream $stream)
	{
		$c = $stream->get_char();
		$this->assertTrue($c != false);

		$stream->unget_char();

		$c2 = $stream->get_char();
		$this->assertTrue($c2 != false);

		$this->assertEquals($c, $c2);
	}

	public function testLine1()
	{
		$s = new phpickle_stream("data://text/plain;base64,".base64_encode("Line1\r\nLine2\r\nabc\r\nLine 15"));

		$this->assertEquals($s->get_line(), "Line1");
		$this->assertEquals($s->get_line(), "Line2");

		$this->assertEquals($s->get_char(), "a");
		$this->assertEquals($s->get_char(), "b");

		$this->assertEquals($s->get_line(), "c");

		$this->assertEquals($s->get_line(), "Line 15");

		$this->assertTrue($s->eof());

		$s->close();
		return $s;
	}

	/**
	* @depends testLine1
	**/
	public function testFail(phpickle_stream $s)
	{
		$this->assertEquals($s->get_line(), false);
		$this->assertEquals($s->unget_line(), false);
		$this->assertEquals($s->get_char(), false);
		$this->assertEquals($s->unget_char(), false);

		$this->assertTrue($s->eof());
		$this->assertTrue($s->open("data://text/plain;base64,".base64_encode("Line1\nLine2\nabc\r\nLine 15")));
		$this->assertFalse($s->eof());
		$this->assertEquals($s->get_line(), "Line1");
		$this->assertEquals($s->get_line(), "Line2");

		return $s;
	}

	/**
	* @depends testFail
	**/
	public function testFail2(phpickle_stream $s)
	{
		$this->assertTrue($s->open("data://text/plain;base64,".base64_encode("Line1\r\nLine2\r\nabc\r\nLine 15")));
		$s->close();
		$this->assertFalse($s->open("file:///__notexisting!"));
	}

	public function data()
	{
		return array(
			array(new phpickle_stream("data://text/plain;base64,".base64_encode("Line1\r\nLine2\r\nabc\r\nline 15"))),
			array(new phpickle_stream("data://text/plain;base64,".base64_encode("a\rb\rd\r"))),
		);
	}
}
