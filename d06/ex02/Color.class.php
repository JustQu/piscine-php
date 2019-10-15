<?php
class Color
{
	public $red;
	public $green;
	public $blue;
	static $verbose = false;

	static public function doc()
	{
		echo "\n";
		echo file_get_contents("./Color.doc.txt");
		echo "\n";
	}

	public function __construct($a)
	{
		if (isset($a['rgb'])){
			$rgb = intval($a['rgb']);
			$this->red = ($rgb >> 16) & 0xff;
			$this->green = ($rgb >> 8) & 0xff;
			$this->blue = $rgb & 0xff;
		} else if (isset($a['red']) && isset($a['green']) && isset($a['blue'])){
			$this->red = intval($a['red']);
			$this->blue = intval($a['blue']);
			$this->green = intval($a['green']);
		}
		
		if (Self::$verbose)
			printf("Color( red: %3d, green: %3d, blue: %3d ) constructed.\n", $this->red, $this->green, $this->blue);
	}

	function __destruct()
	{
		if (Self::$verbose)
			printf("Color( red: %3d, green: %3d, blue: %3d ) destructed.\n", $this->red, $this->green, $this->blue);
	}

	public function __ToString()
	{
		return (vsprintf("Color( red: %3d, green: %3d, blue: %3d )", array($this->red, $this->green, $this->blue)));

	}

	public function add($Color)
	{
		$newColor = new Color(array('red' => $this->red + $Color->red,
								'green' => $this->green + $Color->green,
								'blue' => $this->blue + $Color->blue));
		return $newColor;
	}

	public function sub($Color)
	{
		$newColor = new Color(array('red' => $this->red - $Color->red,
								'green' => $this->green - $Color->green,
								'blue' => $this->blue - $Color->blue));
		return $newColor;
	}

	public function mult($cf)
	{
		$newColor = new Color(array('red' => $this->red * $cf,
								'green' => $this->green * $cf,
								'blue' => $this->blue * $cf));
		return $newColor;
	}
}
?>