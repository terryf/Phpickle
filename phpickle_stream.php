<?php

class phpickle_stream
{
	private $handle = 0;
	private $last_pos = 0;

	public function __construct($url = "")
	{
		if ($url != "")
		{
			$this->open($url);
		}
	}

	public function open($url)
	{
		if ($this->handle)
		{
			$this->close();
		}
		$this->handle = @fopen($url, "rb");
		if (!$this->handle)
		{
			return false;
		}
		$this->_update_pos();
		return true;
	}

	public function close()
	{
		if ($this->handle)
		{
			fclose($this->handle);
			$this->handle = false;
		}
	}

	public function get_line()
	{
		if (!$this->handle)
		{
			return false;
		}
		$this->_update_pos();
		$rv = fgets($this->handle);
		while (substr($rv, -1) == "\r" || substr($rv, -1) == "\n")
		{
			$rv = substr($rv, 0, -1);
		}
		return $rv;
	}

	public function unget_line()
	{
		if (!$this->handle)
		{
			return false;
		}
		fseek($this->handle, $this->last_pos);
		return true;
	}

	public function get_char()
	{
		if (!$this->handle)
		{
			return false;
		}
		$this->_update_pos();
		return fgetc($this->handle);
	}

	public function unget_char()
	{
		if (!$this->handle)
		{
			return false;
		}
		fseek($this->handle, $this->last_pos);
		return true;
	}

	public function get_byte()
	{
		if (!$this->handle)
		{
			return false;
		}
		$this->_update_pos();
		return fread($this->handle, 1);
	}

	public function get_bytes($num)
	{
		if ($num == 0) 
		{
			return "";
		}
		if (!$this->handle)
		{
			return false;
		}
		$this->_update_pos();
		return fread($this->handle, $num);
	}

	public function unget_byte()
	{
		return $this->unget_char();
	}

	public function write($bytes)
	{
		if (!$this->handle)
		{
			return false;
		}
		$this->_update_pos();
		return fwrite($this->handle, $bytes);
	}

	public function write_line($str)
	{
		if (!$this->handle)
		{
			return false;
		}
		$this->_update_pos();
		return fwrite($this->handle, $str."\n");
	}

	public function eof()
	{
		if (!$this->handle)
		{
			return true;
		}
		return feof($this->handle);
	}

	public function get_contents()
	{
		if (!$this->handle)
		{
			return false;
		}
		fseek($this->handle, 0);
		return fread($this->handle, 1000000);
	}

	private function _update_pos()
	{
		$this->last_pos = ftell($this->handle);
	}
}


