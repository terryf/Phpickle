<?php

class test_data
{
	public static function get()
	{
		$inst = new stdClass();
		$i2 = new stdClass();
		$i2->__python_class__ = "__main__.test";
		$i2->__python_construct_args__ = array();
		$i2->b = "in f";
	
		$inst->__python_class__ = "__main__.test";
		$inst->__python_construct_args__ = array();
		$inst->a = 5;
		$inst->c = array(1,2,3,4,5,6);
		$inst->b = "a";
		$inst->ref = $i2;

		return array(
		/*1*/	array("I1\n.", 1, 0),
		/*2*/	array("K\x01.", 1, 1),
		/*3*/	array("\x80\x02K\x01.", 1, 2),
		/*4*/	array("S'a'\np0\n.", "a", 0),
		/*5*/	array("U\x01aq\x00.", "a", 1),
		/*6*/	array("\x80\x02U\x01aq\x00.", "a", 2),
		/*7*/	array("(lp0\nI1\naI2\naS'a'\np1\na.", array(1,2,'a'), 0),
		/*8*/	array("]q\x00(K\x01K\x02U\x01aq\x01e.", array(1,2,'a'), 1),
		/*9*/	array("\x80\x02]q\x00(K\x01K\x02U\x01aq\x01e.", array(1,2,'a'), 2),
		/*10*/	array("(dp0\nS'a'\np1\nS'b'\np2\nsS'c'\np3\nS'd'\np4\ns.", array("a" => "b", "c" => "d"), 0),
		/*11*/	array("}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03U\x01dq\x04u.", array("a" => "b", "c" => "d"), 1),
		/*12*/	array("\x80\x02}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03U\x01dq\x04u.", array("a" => "b", "c" => "d"), 2),
		/*13*/	array("\x80\x02}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03}q\x04(U\x01dq\x05U\x01eq\x06U\x01fq\x07U\x01gq\x08uu.", array("a" => "b", "c" => array("d" => "e", "f" => "g")),2),
		/*14*/	array("}q\x00(U\x01aq\x01U\x01bq\x02U\x01cq\x03}q\x04(U\x01dq\x05U\x01eq\x06U\x01fq\x07U\x01gq\x08uu.", array("a" => "b", "c" => array("d" => "e", "f" => "g")), 1),
		/*15*/	array("(dp0\nS'a'\np1\nS'b'\np2\nsS'c'\np3\n(dp4\nS'd'\np5\nS'e'\np6\nsS'f'\np7\nS'g'\np8\nss.", array("a" => "b", "c" => array("d" => "e", "f" => "g")), 0),
		/*16*/	array("(dp0\nS'a'\np1\nI1\nsS'b'\np2\n(dp3\ng1\nI1\nsg2\n(dp4\ng1\nI2\nsss.", array("a" => 1, "b" => array("a" => 1, "b" => array("a" => 2))), 0),
		/*17*/	array("}q\x00(U\x01aq\x01K\x01U\x01bq\x02}q\x03(h\x01K\x01h\x02}q\x04h\x01K\x02suu.", array("a" => 1, "b" => array("a" => 1, "b" => array("a" => 2))), 1),
		/*18*/	array("\x80\x02}q\x00(U\x01aq\x01K\x01U\x01bq\x02}q\x03(h\x01K\x01h\x02}q\x04h\x01K\x02suu.", array("a" => 1, "b" => array("a" => 1, "b" => array("a" => 2))), 2),
		/*19*/	array("(I1\nI2\nI3\nI4\ntp0\n.", array(1, 2, 3, 4), 0),
		/*20*/	array("(K\x01K\x02K\x03K\x04tq\x00.", array(1, 2, 3, 4), 1),
		/*21*/	array("\x80\x02(K\x01K\x02K\x03K\x04tq\x00.", array(1, 2, 3, 4), 2),
		/*22*/	array("\x80\x02(K\x01K\x02K\x03K\x04]q\x00(K\x05K\x06}q\x01K\x07K\x08setq\x02.", array(1,2,3,4,array(5,6,array(7 => 8))), 1),
		/*23*/	array("(I1\nI2\nI3\nI4\n(lp0\nI5\naI6\na(dp1\nI7\nI8\nsatp2\n.", array(1,2,3,4,array(5,6,array(7 => 8))), 0),
		/*24*/	array("F9.1234000000000002\n.", 9.1234, 0),
		/*25*/	array("\x80\x02G@\"?.H\xe8\xa7\x1e.", 9.1234, 2),
		/*26*/	array("G@\"?.H\xe8\xa7\x1e.", 9.1234, 1),
		/*27*/	array("J]\xd1\x12\x00.", 1233245, 1),
		/*28*/	array("]q\x00(I01\nI00\nK\x01e.", array(true, false, 1), 1),
		/*29*/	array("L1233245L\n.", 1233245, 0),
		/*30*/	array("\x80\x02\x8a\x03]\xd1\x12.", 1233245, 2),
		/*31*/	array("\x80\x02M`\xea.", 60000, 2),
		/*32*/	array("M`\xea.", 60000, 1),
		/*33*/	array("I60000\n.", 60000, 0),
		/*34*/	array("N.", null, 0),
		/*35*/	array("\x80\x02U\x0fbinary \x00 stringq\x00.", "binary \x00 string", 2),
		/*36*/	array("U\x0fbinary \x00 stringq\x00.", "binary \x00 string", 1),
		/*37*/	array("S'binary \\x00 string'\np0\n.", "binary \x00 string", 0),
		/*38*/	array("(dp0\nS'a'\np1\nS'sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj'\np2\nsI1\nI2\nsI3\nI4\nsI5\nI6\ns.", array(1 => 2, 3 => 4, 5 => 6, "a" => "sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj"), 0),
		/*39*/	array("}q\x00(U\x01aq\x01U(sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkjq\x02K\x01K\x02K\x03K\x04K\x05K\x06u.", array(1 => 2, 3 => 4, 5 => 6, "a" => "sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj"), 1),
		/*40*/	array("\x80\x02}q\x00(U\x01aq\x01U(sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkjq\x02K\x01K\x02K\x03K\x04K\x05K\x06u.", array(1 => 2, 3 => 4, 5 => 6, "a" => "sdoikjasdlkjaslkjaslkjalskdjalskdjalsdkj"),2),
		/*41*/	array("(i__main__\ntest\np0\n(dp1\nS'a'\np2\nI5\nsS'c'\np3\n(I1\nI2\nI3\nI4\nI5\nI6\ntp4\nsS'b'\np5\ng2\nsS'ref'\np6\n(i__main__\ntest\np7\n(dp8\ng5\nS'in f'\np9\nsbsb.", $inst, 0),
		);
	}
}