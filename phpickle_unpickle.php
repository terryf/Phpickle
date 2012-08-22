<?php
require_once "phpickle_stack.php";
require_once "phpickle_memo.php";
require_once "phpickle_stream.php";
require_once "phpickle_gen_read_ops.php";
require_once "phpickle_op_mapper.php";

class phpickle_unpickle
{
	private $debug = false;

	public function set_debug($onoff)
	{
		$this->debug = $onoff;
	}

	/** unpickle from string **/
	public function loads($str)
	{
		$stream = new phpickle_stream("data://text/plain;base64,".base64_encode($str));
		return $this->unpickle_stream($stream);
	}

	/** unpickle from string "encrypted" as django session **/
	public function loads_django_session($str)
	{
		$str = base64_decode($str);
		//echo "str = $str  \r\n";
		list($hash, $pickle) = explode(":", $str, 2);
		//echo "hash: $hash, pickle: $pickle \r\n";
		return $this->loads($pickle);
	}

	public function unpickle_stream(phpickle_stream $stream)
	{
		$reader = new phpickle_read_ops();
		$stack = new phpickle_stack();
		$memo = new phpickle_memo();
		$ops = new phpickle_op_mapper();

		if ($this->debug)
		{
			echo "start unpickle \r\n";
		}
		while (!$stream->eof())
		{
			$byte = $stream->get_byte();
			if ($this->debug)
			{
				echo "read command as $byte (".ord($byte).") \r\n";
			}
			$op_str = $ops->bin2str($byte);
			if ($this->debug)
			{
				echo "op_str = $op_str \r\n";
			}
			if ($op_str == "STOP")
			{
				break;
			}
			$fn = "op_".$op_str;
			if ($this->debug)
			{
				echo "calling $fn \r\n";
			}
			$reader->$fn($stream, $stack, $memo, $this->debug);
		}

		return $stack->pop();
	}

	private function _string_op($bin_op)
	{
		return array_search($bin_op, $this->pickle_op_codes);
	}
}

