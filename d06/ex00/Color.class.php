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
		if ($this->red < 0)
			$this->red = 0;
		if ($this->green < 0)
			$this->green = 0;
		if($this->blue < 0)
			$this->blue = 0;
		if($this->red > 255)
			$this->red = 255;
		if($this->green > 255)
			$this->green = 255;
		if($this->blue > 255)
			$this->blue = 255;

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

print( Color::doc() );
Color::$verbose = True;

$red     = new Color( array( 'red' => 0xff, 'green' => 0   , 'blue' => 0    ) );
$green   = new Color( array( 'rgb' => 255 << 8 ) );
$blue    = new Color( array( 'red' => 0   , 'green' => 0   , 'blue' => 0xff ) );

$yellow  = $red->add( $green );
$cyan    = $green->add( $blue );
$magenta = $blue->add( $red );

$white   = $red->add( $green )->add( $blue );

print( $red     . PHP_EOL );
print( $green   . PHP_EOL );
print( $blue    . PHP_EOL );
print( $yellow  . PHP_EOL );
print( $cyan    . PHP_EOL );
print( $magenta . PHP_EOL );
print( $white   . PHP_EOL );

Color::$verbose = False;

$black = $white->sub( $red )->sub( $green )->sub( $blue );
print( 'Black: ' . $black . PHP_EOL );

Color::$verbose = True;

$darkgrey = new Color( array( 'rgb' => (10 << 16) + (10 << 8) + 10 ) );
print( 'darkgrey: ' . $darkgrey . PHP_EOL );
$lightgrey = $darkgrey->mult( 22.5 );
print( 'lightgrey: ' . $lightgrey . PHP_EOL );

$random = new Color( array( 'red' => 12.3, 'green' => 31.2, 'blue' => 23.1 ) );
print( 'random: ' . $random . PHP_EOL );
?>