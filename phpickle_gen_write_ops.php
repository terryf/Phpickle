<?php 
class phpickle_write_ops
{
		// generated for OP: MARK	// ( push special markobject on stack)
		function op_MARK($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("MARK"));

		}
		// generated for OP: STOP	// ( every pickle ends with STOP)
		function op_STOP($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("STOP"));
			

		}
		// generated for OP: POP	// ( discard topmost stack item)
		function op_POP($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("POP"));
			

		}
		// generated for OP: POP_MARK	// ( discard stack top through topmost markobject)
		function op_POP_MARK($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("POP_MARK"));
			

		}
		// generated for OP: DUP	// ( duplicate top stack item)
		function op_DUP($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("DUP"));
			

		}
		// generated for OP: FLOAT	// ( push float object; decimal string argument)
		function op_FLOAT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("FLOAT"));
			$stream->write_line((string)$value);
			

		}
		// generated for OP: INT	// ( push integer or bool; decimal string argument)
		function op_INT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("INT"));
			$stream->write_line((string)$value);
			

		}
		// generated for OP: BININT	// ( push four-byte signed int)
		function op_BININT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BININT"));
			$stream->write(pack("l", $value));
			

		}
		// generated for OP: BININT1	// ( push 1-byte unsigned int)
		function op_BININT1($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BININT1"));
			$stream->write(pack("C", $value));
			

		}
		// generated for OP: LONG	// ( push long; decimal string argument)
		function op_LONG($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("LONG"));
			$stream->write_line(((string)$value)."L");
			

		}
		// generated for OP: BININT2	// ( push 2-byte unsigned int)
		function op_BININT2($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BININT2"));
			$v = pack("l", $value);
			$stream->write($v[0].$v[1]);
			

		}
		// generated for OP: NONE	// ( push None)
		function op_NONE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("NONE"));
			

		}
		// generated for OP: PERSID	// ( push persistent object; id is taken from string arg)
		function op_PERSID($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("PERSID"));
			$stream->write_line($value);
			

		}
		// generated for OP: BINPERSID	// (  "       "         "  ;  "  "   "     "  stack)
		function op_BINPERSID($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BINPERSID"));
			// TODO
			

		}
		// generated for OP: REDUCE	// ( apply callable to argtuple, both on stack)
		function op_REDUCE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("REDUCE"));
			// TODO 
			

		}
		// generated for OP: STRING	// ( push string; NL-terminated string argument)
		function op_STRING($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("STRING"));
			$stream->write_line("\"".addcslashes($value)."\"");
			

		}
		// generated for OP: BINSTRING	// ( push string; counted binary string argument)
		function op_BINSTRING($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BINSTRING"));
			$len = strlen($value);
			$stream->write(pack("L", $len));
			$stream->write($value);
			

		}
		// generated for OP: SHORT_BINSTRING	//  "     "   ;    "      "       "      " < 256 bytes
		function op_SHORT_BINSTRING($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("SHORT_BINSTRING"));
			$len = strlen($value);
			$stream->write(pack("C", $len));
			$stream->write($value);
			

		}
		// generated for OP: UNICODE	// ( push Unicode string; raw-unicode-escaped'd argument)
		function op_UNICODE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("UNICODE"));
			$stream->write_line($value);
			

		}
		// generated for OP: BINUNICODE	// (   "     "       "  ; counted UTF-8 string argument)
		function op_BINUNICODE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BINUNICODE"));
			$len = strlen($value);
			$stream->write(pack("L", $len));
			$stream->write($value);
			

		}
		// generated for OP: APPEND	// ( append stack top to list below it)
		function op_APPEND($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("APPEND"));
			

		}
		// generated for OP: BUILD	// ( call __setstate__ or __dict__.update())
		function op_BUILD($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BUILD"));
			

		}
		// generated for OP: GLOBAL	// ( push self.find_class(modname, name); 2 string args)
		function op_GLOBAL($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("GLOBAL"));
			list($module, $name) = explode(".", $value->__python_class__);
			$stream->write_line($module);
			$stream->write_line($name);
			

		}
		// generated for OP: DICT	// ( build a dict from stack items)
		function op_DICT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("DICT"));
			

		}
		// generated for OP: EMPTY_DICT	// ( push empty dict)
		function op_EMPTY_DICT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("EMPTY_DICT"));
			

		}
		// generated for OP: APPENDS	// ( extend list on stack by topmost stack slice)
		function op_APPENDS($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("APPENDS"));
			

		}
		// generated for OP: GET	// ( push item from memo on stack; index is string arg)
		function op_GET($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("GET"));
			$stream->write_line($value);
			

		}
		// generated for OP: BINGET	// (   "    "    "    "   "   "  ;   "    " 1-byte arg)
		function op_BINGET($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BINGET"));
			$stream->write(ord($value));
			

		}
		// generated for OP: INST	// ( build & push class instance)
		function op_INST($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("INST"));
			list($module, $name) = explode(".", $value->__python_class__);
			$stream->write_line($module);
			$stream->write_line($name);
			

		}
		// generated for OP: LONG_BINGET	// ( push item from memo on stack; index is 4-byte arg)
		function op_LONG_BINGET($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("LONG_BINGET"));
			$stream->write(pack("L", $value));
			

		}
		// generated for OP: LIST	// ( build list from topmost stack items)
		function op_LIST($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("LIST"));
			

		}
		// generated for OP: EMPTY_LIST	// ( push empty list)
		function op_EMPTY_LIST($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("EMPTY_LIST"));
			

		}
		// generated for OP: OBJ	// ( build & push class instance)
		function op_OBJ($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("OBJ"));
			

		}
		// generated for OP: PUT	// ( store stack top in memo; index is string arg)
		function op_PUT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("PUT"));
			$stream->write_line($value);
			

		}
		// generated for OP: BINPUT	// (   "     "    "   "   " ;   "    " 1-byte arg)
		function op_BINPUT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BINPUT"));
			$stream->write(pack("C", $value));
			

		}
		// generated for OP: LONG_BINPUT	// (   "     "    "   "   " ;   "    " 4-byte arg)
		function op_LONG_BINPUT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("LONG_BINPUT"));
			$stream->write(pack("L", $value));
			

		}
		// generated for OP: SETITEM	// ( add key+value pair to dict)
		function op_SETITEM($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("SETITEM"));
			

		}
		// generated for OP: TUPLE	// ( build tuple from topmost stack items)
		function op_TUPLE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("TUPLE"));
			

		}
		// generated for OP: EMPTY_TUPLE	// ( push empty tuple)
		function op_EMPTY_TUPLE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("EMPTY_TUPLE"));
			

		}
		// generated for OP: SETITEMS	// ( modify dict by adding topmost key+value pairs)
		function op_SETITEMS($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("SETITEMS"));
			

		}
		// generated for OP: BINFLOAT	// ( push float; arg is 8-byte float encoding)
		function op_BINFLOAT($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BINFLOAT"));
			$stream->write(strrev(pack("d", $value)));
			

		}
		// generated for OP: PROTO	// identify pickle protocol
		function op_PROTO($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("PROTO"));
			$stream->write(pack("C", $value));
			

		}
		// generated for OP: NEWOBJ	// build object by applying cls.__new__ to argtuple
		function op_NEWOBJ($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("NEWOBJ"));
			

		}
		// generated for OP: EXT1	// push object from extension registry; 1-byte index
		function op_EXT1($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("EXT1"));
			$stream->write(pack("C", $value));
			

		}
		// generated for OP: EXT2	// ditto, but 2-byte index
		function op_EXT2($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("EXT2"));
			$stream->write(substr(pack("L", $value), 0, 2));
			

		}
		// generated for OP: EXT4	// ditto, but 4-byte index
		function op_EXT4($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("EXT4"));
			$stream->write(pack("L", $value));
			

		}
		// generated for OP: TUPLE1	// build 1-tuple from stack top
		function op_TUPLE1($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("TUPLE1"));
			

		}
		// generated for OP: TUPLE2	// build 2-tuple from two topmost stack items
		function op_TUPLE2($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("TUPLE2"));
			

		}
		// generated for OP: TUPLE3	// build 3-tuple from three topmost stack items
		function op_TUPLE3($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("TUPLE3"));
			

		}
		// generated for OP: NEWTRUE	// push True
		function op_NEWTRUE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("NEWTRUE"));
			

		}
		// generated for OP: NEWFALSE	// push False
		function op_NEWFALSE($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("NEWFALSE"));
			

		}
		// generated for OP: LONG1	// push long from < 256 bytes
		function op_LONG1($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("LONG1"));
			// TODO: handle long numbers in string?
			$stream->write(pack("C", 4));
			$stream->write(pack("L", $value));
			

		}
		// generated for OP: LONG4	// push really big long
		function op_LONG4($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("LONG4"));
			// TODO: handle long numbers in string?
			$stream->write(pack("L", 4));
			$stream->write(pack("L", $value));
			
			
			// Protocol 3 (Python 3.x)
			

		}
		// generated for OP: BINBYTES	// ( push bytes; counted binary string argument)
		function op_BINBYTES($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("BINBYTES"));
			$stream->write(pack("L", strlen($value)));
			$stream->write($value);
			

		}
		// generated for OP: SHORT_BINBYTES	// (  "     "   ;    "      "       "      " < 256 bytes)
		function op_SHORT_BINBYTES($value, &$stream, $stack, $memo, $debug, $mapper)
		{
			$stream->write($mapper->str2bin("SHORT_BINBYTES"));
			$stream->write(pack("C", strlen($value)));
			$stream->write($value);
			
			

		}

}