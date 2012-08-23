<?php
require_once "../phpickle_ops_generator.php";

class phpickle_ops_generatorTest extends PHPUnit_Framework_TestCase
{
	/**
	* @dataProvider data
	**/
	public function testgen_op_handlers($str)
	{
		$stream = new phpickle_stream("data://text/plain;base64,".base64_encode($str));
		$gen = new phpickle_ops_generator();
		list($read_ct, $write_ct) = $gen->gen_op_handlers($stream);
		$this->assertContains("readfunc", $read_ct);
		$this->assertContains("writefunc", $write_ct);

		$this->assertContains("readfunc2", $read_ct);
		$this->assertContains("writefunc2", $write_ct);
	}

	public function data()
	{
		return array(
			array(
				<<<EOD
OP: TEST	// yeeaaah
-- read:
readfunc
--write:
writefunc
OP: TEST2	// test2
-- read:
readfunc2
--write:
writefunc2
EOD
			),
		);
	}
}
