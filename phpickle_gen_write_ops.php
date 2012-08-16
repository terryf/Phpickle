<?php 
class phpickle_write_ops
{
		// generated for OP: MARK	// ( push special markobject on stack)
		function op_MARK($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: STOP	// ( every pickle ends with STOP)
		function op_STOP($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: POP	// ( discard topmost stack item)
		function op_POP($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: POP_MARK	// ( discard stack top through topmost markobject)
		function op_POP_MARK($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: DUP	// ( duplicate top stack item)
		function op_DUP($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: FLOAT	// ( push float object; decimal string argument)
		function op_FLOAT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: INT	// ( push integer or bool; decimal string argument)
		function op_INT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BININT	// ( push four-byte signed int)
		function op_BININT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BININT1	// ( push 1-byte unsigned int)
		function op_BININT1($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: LONG	// ( push long; decimal string argument)
		function op_LONG($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BININT2	// ( push 2-byte unsigned int)
		function op_BININT2($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: NONE	// ( push None)
		function op_NONE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: PERSID	// ( push persistent object; id is taken from string arg)
		function op_PERSID($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BINPERSID	// (  "       "         "  ;  "  "   "     "  stack)
		function op_BINPERSID($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: REDUCE	// ( apply callable to argtuple, both on stack)
		function op_REDUCE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: STRING	// ( push string; NL-terminated string argument)
		function op_STRING($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BINSTRING	// ( push string; counted binary string argument)
		function op_BINSTRING($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: SHORT_BINSTRING	//  "     "   ;    "      "       "      " < 256 bytes
		function op_SHORT_BINSTRING($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: UNICODE	// ( push Unicode string; raw-unicode-escaped'd argument)
		function op_UNICODE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BINUNICODE	// (   "     "       "  ; counted UTF-8 string argument)
		function op_BINUNICODE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: APPEND	// ( append stack top to list below it)
		function op_APPEND($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BUILD	// ( call __setstate__ or __dict__.update())
		function op_BUILD($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: GLOBAL	// ( push self.find_class(modname, name); 2 string args)
		function op_GLOBAL($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: DICT	// ( build a dict from stack items)
		function op_DICT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: EMPTY_DICT	// ( push empty dict)
		function op_EMPTY_DICT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: APPENDS	// ( extend list on stack by topmost stack slice)
		function op_APPENDS($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: GET	// ( push item from memo on stack; index is string arg)
		function op_GET($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BINGET	// (   "    "    "    "   "   "  ;   "    " 1-byte arg)
		function op_BINGET($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: INST	// ( build & push class instance)
		function op_INST($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: LONG_BINGET	// ( push item from memo on stack; index is 4-byte arg)
		function op_LONG_BINGET($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: LIST	// ( build list from topmost stack items)
		function op_LIST($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: EMPTY_LIST	// ( push empty list)
		function op_EMPTY_LIST($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: OBJ	// ( build & push class instance)
		function op_OBJ($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: PUT	// ( store stack top in memo; index is string arg)
		function op_PUT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BINPUT	// (   "     "    "   "   " ;   "    " 1-byte arg)
		function op_BINPUT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: LONG_BINPUT	// (   "     "    "   "   " ;   "    " 4-byte arg)
		function op_LONG_BINPUT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: SETITEM	// ( add key+value pair to dict)
		function op_SETITEM($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: TUPLE	// ( build tuple from topmost stack items)
		function op_TUPLE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: EMPTY_TUPLE	// ( push empty tuple)
		function op_EMPTY_TUPLE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: SETITEMS	// ( modify dict by adding topmost key+value pairs)
		function op_SETITEMS($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: BINFLOAT	// ( push float; arg is 8-byte float encoding)
		function op_BINFLOAT($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: PROTO	// identify pickle protocol
		function op_PROTO($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: NEWOBJ	// build object by applying cls.__new__ to argtuple
		function op_NEWOBJ($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: EXT1	// push object from extension registry; 1-byte index
		function op_EXT1($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: EXT2	// ditto, but 2-byte index
		function op_EXT2($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: EXT4	// ditto, but 4-byte index
		function op_EXT4($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: TUPLE1	// build 1-tuple from stack top
		function op_TUPLE1($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: TUPLE2	// build 2-tuple from two topmost stack items
		function op_TUPLE2($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: TUPLE3	// build 3-tuple from three topmost stack items
		function op_TUPLE3($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: NEWTRUE	// push True
		function op_NEWTRUE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: NEWFALSE	// push False
		function op_NEWFALSE($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: LONG1	// push long from < 256 bytes
		function op_LONG1($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: LONG4	// push really big long
		function op_LONG4($stream, $stack, $memo, $debug)
		{
			
			
			// Protocol 3 (Python 3.x)
			

		}
		// generated for OP: BINBYTES	// ( push bytes; counted binary string argument)
		function op_BINBYTES($stream, $stack, $memo, $debug)
		{
			

		}
		// generated for OP: SHORT_BINBYTES	// (  "     "   ;    "      "       "      " < 256 bytes)
		function op_SHORT_BINBYTES($stream, $stack, $memo, $debug)
		{
			
			

		}

}