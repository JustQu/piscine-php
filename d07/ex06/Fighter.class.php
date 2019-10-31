<?php
abstract class Fighter
{
	private $type;

	public function __construct($type)
	{
		$this->type = $type;
	}

	abstract public function fight($target);

	public function getType()
	{
		return $this->type;
	}
}
?>