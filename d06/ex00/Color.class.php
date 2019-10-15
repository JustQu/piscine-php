<?php
class Color
{
	public $red;
	public $green;
	public $blue;

	public function __consruct(array $args)
	{
		if (array_key_exists('rgb', $args)){
			$this->red = $args['rgb']['red'];
			$this->red = $args['rgb']['green'];
			$this->red = $args['rgb']['blue'];
		} else if ($args['red'] !== NULL &&
					$args['green'] !== NULL &&
					$args['blue'] !== NULL){
			$this->red = intval($args['red']);
			$this->blue = intval($args['blue']);
			$this->green = intval($args['green']);
		}
		function($a = array($red, $green, $blue)){
			foreach ($a)
		};
	}
}
?>