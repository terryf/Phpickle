<?php

class phpickle_stack
{
	private $_mark_cnt = 0;

	public function __construct()
	{
		$this->s = array();
	}

	public function push($v)
	{
		array_push($this->s, $v);
	}

	public function pop()
	{
		return array_pop($this->s);
	}

	public function push_mark()
	{
		$cl = new stdClass;
		$cl->__mark__ = 1;
		$this->_mark_cnt++;
		$cl->__mark_cnt = $this->_mark_cnt;
		$this->push($cl);
	}

	public function pop_until_mark()
	{
		$len = count($this->s);
		for ($i = ($len-1); $i >= 0; $i--)
		{
			if (is_object($this->s[$i]) && isset($this->s[$i]->__mark__) && $this->s[$i]->__mark__ == 1)
			{
				$rv = array_slice($this->s, $i+1);
				array_splice($this->s, $i);
				return $rv;
			}
		}
		//var_dump($this->s);
		throw new Exception("no mark found on stack!");
	}

	public function get_top()
	{
		return $this->s[count($this->s)-1];
	}
}