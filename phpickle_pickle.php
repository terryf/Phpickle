<?php
require_once "phpickle_stack.php";
require_once "phpickle_memo.php";
require_once "phpickle_stream.php";
require_once "phpickle_gen_write_ops.php";
require_once "phpickle_op_mapper.php";

class phpickle_pickle
{
	private $_stream;
	private $_ops;
	private $_debug = false;

	public function set_debug($state)
	{
		$this->_debug = $state;
	}

	/** pickles the data given in $data **/
	public function dumps($data, $proto = -1)
	{
		$this->_stream = new phpickle_stream("data://text/plain;base64,".base64_encode(""));
		$this->_ops = new phpickle_write_ops();
		$this->_stack = new phpickle_stack();
		$this->_memo = new phpickle_memo();
		$this->_mapper = new phpickle_op_mapper();
		$this->_proto = ($proto == -1 ? 2 : $proto);

		if ($this->_proto >= 2)
		{
			$this->_call_op("PROTO", 2, $this->_stream);
		}

		$this->_pickle($data, $this->_stream);
		return $this->_stream->get_contents().".";
	}

	private function _pickle($data, &$stream)
	{
		$type = gettype($data);
		if ($type == "unknown type")
		{
			return;
		}
		$op = "_pickle_".$type;
		$this->$op($data, $stream);
	}

	private function _pickle_boolean($data, &$stream)
	{
		if ($data == true)
		{
			$this->_call_op($this->_proto >= 2 ? "NEWTRUE" : "TRUE", null, $stream);
		}
		else
		{
			$this->_call_op($this->_proto >= 2 ? "NEWFALSE" : "FALSE", null, $stream);
		}
	}

	private function _pickle_integer($data, &$stream)
	{
		if ($this->_proto >= 1 && $data >= 0 && $data <= 0xffff)
		{
			if ($data <= 0xff)
			{
				$this->_call_op("BININT1", $data, $stream);
			}
			else
			{
				$this->_call_op("BININT2", $data, $stream);
			}
		}
		else
		if ($this->_proto >= 2)
		{
			$this->_call_op("LONG1", $data, $stream);
		}
		else
		if ($this->_proto >= 1)
		{
			$this->_call_op("BININT", $data, $stream);
		}
		else
		{
			$this->_call_op("INT", $data, $stream);
		}
	}

	private function _pickle_double($data, &$stream)
	{
		if ($this->_proto >= 1)
		{
			$this->_call_op("BINFLOAT", $data, $stream);
		}
		else
		{
			$this->_call_op("FLOAT", $data, $stream);
		}
	}

	private function _pickle_string($data, &$stream)
	{
		if ($this->_str_has_bin($data))
		{
			// if string has binary data, save to SHORT_BINBYTES or BINBYTES
			if (strlen($data) < 0xff)
			{
				$this->_call_op("SHORT_BINBYTES", $data, $stream);
			}
			else
			{
				$this->_call_op("BINBYTES", $data, $stream);
			}
		}
		else
		{
			if ($this->_proto > 0)
			{
				if (($idx = $this->_memo->has($data)) !== false)
				{
					$this->_call_op("BINGET", $idx, $stream);
				}
				else
				{
					if (strlen($data) < 0xff)
					{
						$this->_call_op("SHORT_BINSTRING", $data, $stream);
					}
					else
					{
						$this->_call_op("BINSTRING", $data, $stream);
					}
					$this->_call_op("BINPUT", $this->_memo->put($data), $stream);
				}
			}
			else
			{
				if (($idx = $this->_memo->has($data)) !== false)
				{
					$this->_call_op("GET", $idx, $stream);
				}
				else
				{
					$this->_call_op("STRING", $data, $stream);
					$this->_call_op("PUT", $this->_memo->put($data), $stream);
				}
			}
		}
	}

	private function _pickle_array($data, &$stream)
	{
		if ($this->_array_has_keys($data))
		{
			$this->_pickle_dict($data, $stream);
		}
		else
		{
			$this->_pickle_list($data, $stream);
		}
	}

	private function _pickle_list($data, $stream)
	{
		// LIST
		if ($this->_proto == 0)
		{
			$this->_call_op("MARK", null, $stream);
			$this->_call_op("LIST", null, $stream);
			$this->_call_op("PUT", $this->_memo->put(array()), $stream);
		}
		else
		{
			$this->_call_op("EMPTY_LIST", null, $stream);
			$this->_call_op("BINPUT", $this->_memo->put(array()), $stream);
			$this->_call_op("MARK", null, $stream);
		}
		foreach($data as $v)
		{
			$this->_pickle($v, $stream);
			if ($this->_proto == 0)
			{
				$this->_call_op("APPEND", null, $stream);
			}
		}
		if ($this->_proto > 0)
		{
			$this->_call_op("APPENDS", null, $stream);
		}
	}

	private function _pickle_dict($data, &$stream)
	{
		// DICT
		if ($this->_proto == 0)
		{
			$this->_call_op("MARK", null, $stream);
			$this->_call_op("DICT", null, $stream);
			$this->_call_op("PUT", $this->_memo->put(array()), $stream);
		}
		else
		{
			$this->_call_op("EMPTY_DICT", null, $stream);
			$this->_call_op("BINPUT", $this->_memo->put(array()), $stream);
			if (count($data) > 1)
			{
				$this->_call_op("MARK", null, $stream);
			}
		}
		foreach($data as $k => $v)
		{
			$this->_pickle($k, $stream);
			$this->_pickle($v, $stream);
			if ($this->_proto == 0)
			{
				$this->_call_op("SETITEM", null, $stream);
			}
		}
		if ($this->_proto > 0 && count($data) > 0)
		{
			if (count($data) == 1)
			{
				$this->_call_op("SETITEM", null, $stream);
			}
			else
			{
				$this->_call_op("SETITEMS", null, $stream);
			}
		}
	}


	private function _pickle_object($data, &$stream)
	{
		// if unpickled from python object, then try to reconstruct the original stream
		// else just forget it
		if (isset($data->__python_class__))
		{
			if (isset($data->__python_pickle_op__) && $data->__python_pickle_op__ == "GLOBAL")
			{
				$this->_call_op("GLOBAL", $data, $stream);
			}
			else
			{
				// INST
				$this->_call_op("MARK", null, $stream);
				if (is_array($data->__python_construct_args__))
				{
					foreach($data->__python_construct_args__ as $v)
					{
						$this->_pickle($v, $stream);
					}
				}
				$this->_call_op("INST", $data, $stream);
			}
			// now, if the object has other properties, then add them as dict and then BUILD
			$d = get_object_vars($data);
			unset($d["__python_class__"]);
			unset($d["__python_pickle_op__"]);
			unset($d["__python_construct_args__"]);
			if (count($d) > 0)
			{
				$this->_pickle_dict($d, $stream);
				$this->_call_op("BUILD", $data, $stream);
			}
		}
		else
		{
			// regular php object, serialize to dict
			$d = array();
			foreach($data as $k => $v)
			{
				$d[$k] = $v;
			}
			return $this->_pickle_dict($d, $stream);
		}
	}

	private function _pickle_resource($data, &$stream)
	{
		// this just isn't happening. really.  
	}

	private function _pickle_NULL($data, &$stream)
	{
		$this->_call_op("NONE", null, $stream);
	}

	private function _call_op($op, $arg, &$stream)
	{
		$op = "op_".$op;
		$this->_ops->$op($arg, $stream, $this->_stack, $this->_memo, $this->_debug, $this->_mapper);
	}

	private function _array_has_keys($array)
	{
		$num = 0;
		foreach($array as $k => $v)
		{
			if ($k !== $num)
			{
				return true;
			}
			$num++;
		}
		return false;
	}

	private function _str_has_bin($str)
	{
		$r = ctype_print($str);
		return !$r;
	}
}
