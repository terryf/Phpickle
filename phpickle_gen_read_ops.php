<?php 
class phpickle_read_ops
{
		// generated for OP: MARK	// ( push special markobject on stack)
		function op_MARK($stream, $stack, $memo, $debug)
		{
			$stack->push_mark();

		}
		// generated for OP: STOP	// ( every pickle ends with STOP)
		function op_STOP($stream, $stack, $memo, $debug)
		{
			throw new Exception("STOP");

		}
		// generated for OP: POP	// ( discard topmost stack item)
		function op_POP($stream, $stack, $memo, $debug)
		{
			$stack->pop();

		}
		// generated for OP: POP_MARK	// ( discard stack top through topmost markobject)
		function op_POP_MARK($stream, $stack, $memo, $debug)
		{
			$stack->pop_until_mark();

		}
		// generated for OP: DUP	// ( duplicate top stack item)
		function op_DUP($stream, $stack, $memo, $debug)
		{
			$stack->push($stack->get_top());

		}
		// generated for OP: FLOAT	// ( push float object; decimal string argument)
		function op_FLOAT($stream, $stack, $memo, $debug)
		{
			$stack->push(floatval($stream->get_line()));

		}
		// generated for OP: INT	// ( push integer or bool; decimal string argument)
		function op_INT($stream, $stack, $memo, $debug)
		{
			$line = trim($stream->get_line());
			if ($line === "01")
			{
				$stack->push(true);
			}
			else
			if ($line === "00")
			{
				$stack->push(false);
			}
			else
			{
				$stack->push(intval(trim($line)));
			}

		}
		// generated for OP: BININT	// ( push four-byte signed int)
		function op_BININT($stream, $stack, $memo, $debug)
		{
			$av = unpack("lint", $stream->get_bytes(4));
			$stack->push($av["int"]);

		}
		// generated for OP: BININT1	// ( push 1-byte unsigned int)
		function op_BININT1($stream, $stack, $memo, $debug)
		{
			$av = unpack("Cint", $stream->get_byte());
			$stack->push($av["int"]);
			if ($debug)
			{
				echo "BININT1: val: $av[int] \r\n";
			}

		}
		// generated for OP: LONG	// ( push long; decimal string argument)
		function op_LONG($stream, $stack, $memo, $debug)
		{
			$line = trim($stream->get_line());
			if (substr($line, -1) == "L")
			{
				$line = substr($line, 0, -1);
			}
			$stack->push(intval(trim($line)));

		}
		// generated for OP: BININT2	// ( push 2-byte unsigned int)
		function op_BININT2($stream, $stack, $memo, $debug)
		{
			$av = unpack("lint", $stream->get_bytes(2)."\x00\x00");
			$stack->push($av["int"]);

		}
		// generated for OP: NONE	// ( push None)
		function op_NONE($stream, $stack, $memo, $debug)
		{
			$stack->push(null);

		}
		// generated for OP: PERSID	// ( push persistent object; id is taken from string arg)
		function op_PERSID($stream, $stack, $memo, $debug)
		{
			// TODO: we are not handling persistent load handlers
			$stream->get_line();
			$stack->push(NULL);

		}
		// generated for OP: BINPERSID	// (  "       "         "  ;  "  "   "     "  stack)
		function op_BINPERSID($stream, $stack, $memo, $debug)
		{
			$stack->pop();
			$stack->push(null);

		}
		// generated for OP: REDUCE	// ( apply callable to argtuple, both on stack)
		function op_REDUCE($stream, $stack, $memo, $debug)
		{
			// TODO: not supported
			$d1 = $stack->pop();
			$d2 = $stack->pop();
			$stack->push(null);
			if ($debug)
			{
				echo "REDUCE: arg1(",var_dump($d1),"), arg2(",var_dump($d2),") \r\n";
			}

		}
		// generated for OP: STRING	// ( push string; NL-terminated string argument)
		function op_STRING($stream, $stack, $memo, $debug)
		{
			// TODO: almost
			$s = trim($stream->get_line());
			if ($s[0] == substr($s, -1))
			{
				$s = substr($s, 1, -1);
			}
			else
			{
				throw new Exception("incorrectly quoted string in pickle: $s");
			}
			$stack->push($s);

		}
		// generated for OP: BINSTRING	// ( push string; counted binary string argument)
		function op_BINSTRING($stream, $stack, $memo, $debug)
		{
			$av = unpack("Lval", $stream->get_bytes(4));
			$len = $av["val"];
			$stack->push($stream->get_bytes($len));

		}
		// generated for OP: SHORT_BINSTRING	//  "     "   ;    "      "       "      " < 256 bytes
		function op_SHORT_BINSTRING($stream, $stack, $memo, $debug)
		{
			$len = ord($stream->get_char());
			$stack->push($stream->get_bytes($len));
			if ($debug)
			{
				echo "SHORT_BINSTRING: len: $len, str: ".$stack->get_top()." \r\n";
			}

		}
		// generated for OP: UNICODE	// ( push Unicode string; raw-unicode-escaped'd argument)
		function op_UNICODE($stream, $stack, $memo, $debug)
		{
			// TODO: not quite
			$stack->push($stream->get_line());

		}
		// generated for OP: BINUNICODE	// (   "     "       "  ; counted UTF-8 string argument)
		function op_BINUNICODE($stream, $stack, $memo, $debug)
		{
			$av = unpack("Lval", $stream->get_bytes(4));
			$len = $av["val"];
			$stack->push($stream->get_bytes($len));

		}
		// generated for OP: APPEND	// ( append stack top to list below it)
		function op_APPEND($stream, $stack, $memo, $debug)
		{
			$item = $stack->pop();
			$list = $stack->pop();
			$list[] = $item;
			$stack->push($list);

		}
		// generated for OP: BUILD	// ( call __setstate__ or __dict__.update())
		function op_BUILD($stream, $stack, $memo, $debug)
		{
			// TODO: not complete
			$stack->pop();

		}
		// generated for OP: GLOBAL	// ( push self.find_class(modname, name); 2 string args)
		function op_GLOBAL($stream, $stack, $memo, $debug)
		{
			$module = $stream->get_line();
			$name = $stream->get_line();
			$stack->push($module."::".$name);
			if ($debug)
			{
				echo "GLOBAL: module($module), name($name) \r\n";
			}

		}
		// generated for OP: DICT	// ( build a dict from stack items)
		function op_DICT($stream, $stack, $memo, $debug)
		{
			$vals = $stack->pop_until_mark();
			$d = array();
			$len = count($vals);
			for ($i = 0; $i < $len; $i+=2)
			{
				$d[$vals[$i]] = $vals[$i+1];
			}
			$stack->push($d);

		}
		// generated for OP: EMPTY_DICT	// ( push empty dict)
		function op_EMPTY_DICT($stream, $stack, $memo, $debug)
		{
			$stack->push(array());

		}
		// generated for OP: APPENDS	// ( extend list on stack by topmost stack slice)
		function op_APPENDS($stream, $stack, $memo, $debug)
		{
			$items = $stack->pop_until_mark();
			$list = $stack->pop();
			foreach($items as $item)
			{
				$list[] = $item;
			}
			$stack->push($list);

		}
		// generated for OP: GET	// ( push item from memo on stack; index is string arg)
		function op_GET($stream, $stack, $memo, $debug)
		{
			$index = intval(trim($stream->get_line()));
			$stack->push($memo->get($index));

		}
		// generated for OP: BINGET	// (   "    "    "    "   "   "  ;   "    " 1-byte arg)
		function op_BINGET($stream, $stack, $memo, $debug)
		{
			$index = ord($stream->get_byte());
			$stack->push($memo->get($index));

		}
		// generated for OP: INST	// ( build & push class instance)
		function op_INST($stream, $stack, $memo, $debug)
		{
			$module = $stream->get_line();
			$name = $stream->get_line();
			$cl = new stdClass;
			$cl->module = $module;
			$cl->name = $name;
			$stack->push($cl);

		}
		// generated for OP: LONG_BINGET	// ( push item from memo on stack; index is 4-byte arg)
		function op_LONG_BINGET($stream, $stack, $memo, $debug)
		{
			$av = unpack("Lval", $stream->get_bytes(4));
			$index = $av["val"];
			$stack->push($memo->get($index));
			

		}
		// generated for OP: LIST	// ( build list from topmost stack items)
		function op_LIST($stream, $stack, $memo, $debug)
		{
			$vals = $stack->pop_until_mark();
			$stack->push($vals);

		}
		// generated for OP: EMPTY_LIST	// ( push empty list)
		function op_EMPTY_LIST($stream, $stack, $memo, $debug)
		{
			$stack->push(array());

		}
		// generated for OP: OBJ	// ( build & push class instance)
		function op_OBJ($stream, $stack, $memo, $debug)
		{
			// TODO: not quite
			$d = $stack->pop_until_mark();
			$stack->push(new stdClass);

		}
		// generated for OP: PUT	// ( store stack top in memo; index is string arg)
		function op_PUT($stream, $stack, $memo, $debug)
		{
			$index = intval(trim($stream->get_line()));
			$memo->set($index, $stack->get_top());

		}
		// generated for OP: BINPUT	// (   "     "    "   "   " ;   "    " 1-byte arg)
		function op_BINPUT($stream, $stack, $memo, $debug)
		{
			$index = ord($stream->get_byte());
			$memo->set($index, $stack->get_top());
			if ($debug)
			{
				echo "BINPUT: setting memo index($index) to ",var_dump($stack->get_top())," \r\n";
			}

		}
		// generated for OP: LONG_BINPUT	// (   "     "    "   "   " ;   "    " 4-byte arg)
		function op_LONG_BINPUT($stream, $stack, $memo, $debug)
		{
			$av = unpack("Lval", $stream->get_bytes(4));
			$index = $av["val"];
			$memo->set($index, $stack->get_top());

		}
		// generated for OP: SETITEM	// ( add key+value pair to dict)
		function op_SETITEM($stream, $stack, $memo, $debug)
		{
			$value = $stack->pop();
			$key = $stack->pop();
			$dict = $stack->pop();
			$dict[$key] = $value;
			$stack->push($dict);
			if ($debug)
			{
				echo "SETITEM: adding key($key) => value($value) to dict ",var_dump($dict)," \r\n";
			}

		}
		// generated for OP: TUPLE	// ( build tuple from topmost stack items)
		function op_TUPLE($stream, $stack, $memo, $debug)
		{
			// find mark from stack, make numbered array from items until that
			$vals = $stack->pop_until_mark();
			$stack->push($vals);

		}
		// generated for OP: EMPTY_TUPLE	// ( push empty tuple)
		function op_EMPTY_TUPLE($stream, $stack, $memo, $debug)
		{
			$stack->push(array());

		}
		// generated for OP: SETITEMS	// ( modify dict by adding topmost key+value pairs)
		function op_SETITEMS($stream, $stack, $memo, $debug)
		{
			$vals = $stack->pop_until_mark();
			$d = $stack->pop();
			$len = count($vals);
			for ($i = 0; $i < $len; $i+=2)
			{
				$d[$vals[$i]] = $vals[$i+1];
			}
			$stack->push($d);

		}
		// generated for OP: BINFLOAT	// ( push float; arg is 8-byte float encoding)
		function op_BINFLOAT($stream, $stack, $memo, $debug)
		{
			$av = unpack("fval", $stream->get_bytes(8));
			$stack->push($av["val"]);

		}
		// generated for OP: PROTO	// identify pickle protocol
		function op_PROTO($stream, $stack, $memo, $debug)
		{
			$stack->proto = ord($stream->get_byte());
			if ($debug)
			{
				echo "read protocol version as ".$stack->proto." \r\n";
			}

		}
		// generated for OP: NEWOBJ	// build object by applying cls.__new__ to argtuple
		function op_NEWOBJ($stream, $stack, $memo, $debug)
		{
			// TODO: not quite
			$cl = new stdClass;
			$cl->args = $stack->pop();
			$cl->class = $stack->pop();
			$stack->push($cl);

		}
		// generated for OP: EXT1	// push object from extension registry; 1-byte index
		function op_EXT1($stream, $stack, $memo, $debug)
		{
			// TODO: not quite
			$code = $stream->get_byte();
			$stack->push(new stdClass);

		}
		// generated for OP: EXT2	// ditto, but 2-byte index
		function op_EXT2($stream, $stack, $memo, $debug)
		{
			// TODO: not quite
			$code = $stream->get_bytes(2);
			$stack->push(new stdClass);

		}
		// generated for OP: EXT4	// ditto, but 4-byte index
		function op_EXT4($stream, $stack, $memo, $debug)
		{
			// TODO: not quite
			$code = $stream->get_bytes(4);
			$stack->push(new stdClass);

		}
		// generated for OP: TUPLE1	// build 1-tuple from stack top
		function op_TUPLE1($stream, $stack, $memo, $debug)
		{
			if ($debug)
			{
				echo "TUPLE1: making tuple: array(".$stack->get_top().") \r\n";
			}
			$stack->push(array($stack->pop()));

		}
		// generated for OP: TUPLE2	// build 2-tuple from two topmost stack items
		function op_TUPLE2($stream, $stack, $memo, $debug)
		{
			$stack->push(array($stack->pop(), $stack->pop()));

		}
		// generated for OP: TUPLE3	// build 3-tuple from three topmost stack items
		function op_TUPLE3($stream, $stack, $memo, $debug)
		{
			$stack->push(array($stack->pop(), $stack->pop(), $stack->pop()));

		}
		// generated for OP: NEWTRUE	// push True
		function op_NEWTRUE($stream, $stack, $memo, $debug)
		{
			$stack->push(true);

		}
		// generated for OP: NEWFALSE	// push False
		function op_NEWFALSE($stream, $stack, $memo, $debug)
		{
			$stack->push(false);

		}
		// generated for OP: LONG1	// push long from < 256 bytes
		function op_LONG1($stream, $stack, $memo, $debug)
		{
			// TODO: not exact
			$len = ord($stream->get_char());
			$data = $stream->get_bytes($len);
			// push as string, because we can't handle long numbers
			$str = "";
			for($i = 0; $i < $len; $i++)
			{
				$str .= chr($data[$i]);
			}
			$stack->push($str);

		}
		// generated for OP: LONG4	// push really big long
		function op_LONG4($stream, $stack, $memo, $debug)
		{
			$av = unpack("Lval", $stream->get_bytes(4));
			$len = $av["val"];
			$data = $stream->get_bytes($len);
			// push as string, because we can't handle long numbers
			$str = "";
			for($i = 0; $i < $len; $i++)
			{
				$str .= chr($data[$i]);
			}
			$stack->push($str);

		}
		// generated for OP: BINBYTES	// ( push bytes; counted binary string argument)
		function op_BINBYTES($stream, $stack, $memo, $debug)
		{
			$av = unpack("Lval", $stream->get_bytes(4));
			$len = $av["val"];
			$stack->push($stream->get_bytes($len));

		}
		// generated for OP: SHORT_BINBYTES	// (  "     "   ;    "      "       "      " < 256 bytes)
		function op_SHORT_BINBYTES($stream, $stack, $memo, $debug)
		{
			$len = ord($stream->get_char());
			$stack->push($stream->get_bytes($len));

		}

}