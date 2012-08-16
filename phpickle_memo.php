<?php
class phpickle_memo
{
	private $data;

	public function __construct()
	{
		$this->data = array();
	}

	public function set($k, $v)
	{
		$this->data[$k] = $v;
	}

	public function get($k)
	{
		return $this->data[$k];
	}
}
