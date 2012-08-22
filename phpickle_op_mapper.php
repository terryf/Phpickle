<?php

class phpickle_op_mapper
{
	private $_pickle_op_codes;

	public function __construct()
	{
		$this->_pickle_op_codes = array(
			"MARK"		=> "(",		// ( push special markobject on stack)
			"STOP"		=> ".",		// ( every pickle ends with STOP)
			"POP"		=> "0",		// ( discard topmost stack item)
			"POP_MARK"	=> "1",		// ( discard stack top through topmost markobject)
			"DUP"		=> "2",		// ( duplicate top stack item)
			"FLOAT"		=> "F",		// ( push float object; decimal string argument)
			"INT"		=> "I",		// ( push integer or bool; decimal string argument)
			"BININT"	=> "J",		// ( push four-byte signed int)
			"BININT1"	=> "K",		// ( push 1-byte unsigned int)
			"LONG"		=> "L",		// ( push long; decimal string argument)
			"BININT2"	=> "M",		// ( push 2-byte unsigned int)
			"NONE"		=> "N",		// ( push None)
			"PERSID"	=> "P",		// ( push persistent object; id is taken from string arg)
			"BINPERSID"	=> "Q",		// (  "       "         "  ;  "  "   "     "  stack)
			"REDUCE"	=> "R",		// ( apply callable to argtuple, both on stack)
			"STRING"	=> "S",		// ( push string; NL-terminated string argument)
			"BINSTRING"	=> "T",		// ( push string; counted binary string argument)
			"SHORT_BINSTRING" => "U",	//  "     "   ;    "      "       "      " < 256 bytes
			"UNICODE"	=> "V",		// ( push Unicode string; raw-unicode-escaped'd argument)
			"BINUNICODE"	=> "X",		// (   "     "       "  ; counted UTF-8 string argument)
			"APPEND"	=> "a",		// ( append stack top to list below it)
			"BUILD"		=> "b",		// ( call __setstate__ or __dict__.update())
			"GLOBAL"	=> "c",		// ( push self.find_class(modname, name); 2 string args)
			"DICT"		=> "d",		// ( build a dict from stack items)
			"EMPTY_DICT"	=> "}",		// ( push empty dict)
			"APPENDS"	=> "e",		// ( extend list on stack by topmost stack slice)
			"GET"		=> "g",		// ( push item from memo on stack; index is string arg)
			"BINGET"	=> "h",		// (   "    "    "    "   "   "  ;   "    " 1-byte arg)
			"INST"		=> "i",		// ( build & push class instance)
			"LONG_BINGET"	=> "j",		// ( push item from memo on stack; index is 4-byte arg)
			"LIST"		=> "l",		// ( build list from topmost stack items)
			"EMPTY_LIST"	=> "]",		// ( push empty list)
			"OBJ"		=> "o",		// ( build & push class instance)
			"PUT"		=> "p",		// ( store stack top in memo; index is string arg)
			"BINPUT"	=> "q",		// (   "     "    "   "   " ;   "    " 1-byte arg)
			"LONG_BINPUT"	=> "r",		// (   "     "    "   "   " ;   "    " 4-byte arg)
			"SETITEM"	=> "s",		// ( add key+value pair to dict)
			"TUPLE"		=> "t",		// ( build tuple from topmost stack items)
			"EMPTY_TUPLE"	=> ")",		// ( push empty tuple)
			"SETITEMS"	=> "u",		// ( modify dict by adding topmost key+value pairs)
			"BINFLOAT"	=> "G",		// ( push float; arg is 8-byte float encoding)

			"TRUE"		=> "I01\n",	// not an opcode; see INT docs in pickletools.py
			"FALSE"		=> "I00\n",	// not an opcode; see INT docs in pickletools.py

			// Protocol 2

			"PROTO"		=> "\x80",	// identify pickle protocol
			"NEWOBJ"	=> "\x81",	// build object by applying cls.__new__ to argtuple
			"EXT1"		=> "\x82",	// push object from extension registry; 1-byte index
			"EXT2"		=> "\x83",	// ditto, but 2-byte index
			"EXT4"		=> "\x84",	// ditto, but 4-byte index
			"TUPLE1"	=> "\x85",	// build 1-tuple from stack top
			"TUPLE2"	=> "\x86",	// build 2-tuple from two topmost stack items
			"TUPLE3"	=> "\x87",	// build 3-tuple from three topmost stack items
			"NEWTRUE"	=> "\x88",	// push True
			"NEWFALSE"	=> "\x89",	// push False
			"LONG1"		=> "\x8a",	// push long from < 256 bytes
			"LONG4"		=> "\x8b",	// push really big long

			// Protocol 3 (Python 3.x)

			"BINBYTES"	=> "B",		// ( push bytes; counted binary string argument)
			"SHORT_BINBYTES"=> "C",		// (  "     "   ;    "      "       "      " < 256 bytes)
		);
	}

	public function bin2str($op)
	{
		$val = array_search($op, $this->_pickle_op_codes);
		if ($val !== false)
		{
			return $val;
		}
		throw new Exception("op not found for op ".ord($op));
	}

	public function str2bin($op)
	{
		if (isset($this->_pickle_op_codes[$op]))
		{
			return $this->_pickle_op_codes[$op];
		}
		throw new Exception("op not found for op ".ord($op));
	}
}