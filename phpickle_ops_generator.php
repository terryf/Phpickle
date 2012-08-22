<?php
require_once "phpickle_stream.php";

class phpickle_ops_generator
{
	public function gen_op_handlers(phpickle_stream $stream)
	{
		// go over file lines, 
		// skip starting with //
		// skip empty
		// handle starting with OP and -- read: and --write:

		$read_ct = "";
		$write_ct = "";

		while (!$stream->eof())
		{
			$line = trim($stream->get_line());
			if ($line == "")
			{
				continue;
			}
			else
			if (substr($line, 0, 2) == "//")
			{
				continue;
			}
			else
			if (substr($line, 0, 3) == "OP:")
			{
				list($read, $write) = $this->_process_op($line, $stream);
				$read_ct .= $read;
				$write_ct .= $write;
			}
			else
			{
				throw "Unexpected line in op handlers! $line";
			}
		}

		$read_ct = <<<EOD
class phpickle_read_ops
{
$read_ct
}
EOD;

		$write_ct = <<<EOD
class phpickle_write_ops
{
$write_ct
}
EOD;
		return array($read_ct, $write_ct);
	}


	private function _process_read_op_content($op, $op_line, $stream)
	{
		$ct = $this->_read_op_content($stream);

$tmpl = <<<EOD
		// generated for $op_line
		function op_$op(\$stream, \$stack, \$memo, \$debug)
		{
$ct
		}

EOD;

		return $tmpl;
	}

	private function _read_op_content($stream)
	{
		$ct = "";
		while (!$stream->eof())
		{
			$line = $stream->get_line();
			if (substr($line, 0, 3) == "OP:")
			{
				// end of op
				$stream->unget_line();
				break;
			}
			else
			if (substr(trim($line), 0, strlen("--write:")) == "--write:")
			{
				// end of op
				$stream->unget_line();
				break;
			}
			else
			if (substr(trim($line), 0, strlen("-- read:")) == "-- read:")
			{
				// end of op
				$stream->unget_line();
				break;
			}
			$ct .= "\t\t\t".$line."\r\n";
		}
		return $ct;
	}

	private function _process_write_op_content($op, $op_line, $stream)
	{
		$ct = $this->_read_op_content($stream);


$tmpl = <<<EOD
		// generated for $op_line
		function op_$op(\$value, &\$stream, \$stack, \$memo, \$debug, \$mapper)
		{
			\$stream->write(\$mapper->str2bin("$op"));
$ct
		}

EOD;

		return $tmpl;
	}


	private function _process_op($op_line, $stream)
	{
		// parse op
		if (preg_match("/OP\: ([A-Z0-9_]*)/", $op_line, $mt))
		{
			$op = $mt[1];
		}
		else
		{
			throw "OP: line syntax error: $op_line";
		}

		$read = "";
		$write = "";

		while (!$stream->eof())
		{
			$line = trim($stream->get_line());
			if ($line == "")
			{
				continue;
			}
			else
			if (substr($line, 0, 2) == "//")
			{
				continue;
			}
			else
			if (substr($line, 0, 3) == "OP:")
			{
				// end of op
				$stream->unget_line();
				break;
			}
			else
			if (substr($line, 0, strlen("-- read:")) == "-- read:")
			{
				$read = $this->_process_read_op_content($op, $op_line, $stream);
			}
			else
			if (substr($line, 0, strlen("--write:")) == "--write:")
			{
				$write = $this->_process_write_op_content($op, $op_line, $stream);
			}
			else
			{
				throw "Unexpected line in op handler! $line";
			}
		}

		return array($read, $write);
	}

}

function make_defaults()
{
	$gen = new phpickle_ops_generator();
	$stream = new phpickle_stream("phpickle_op_handlers.pck");
	list($read, $write) = $gen->gen_op_handlers($stream);
	file_put_contents("phpickle_gen_read_ops.php", "<?"."php \r\n".$read);
	file_put_contents("phpickle_gen_write_ops.php", "<?"."php \r\n".$write);
}