<?php

require_once 'Color.class.php';

class Vertex
{
	private $_x;
	private $_y;
	private $_z;
	private $_w = 1;
	private $_color;
	static $verbose;

	static public function doc()
	{
		return file_get_contents("./Vertex.doc.txt");
	}

	public function __construct($kwargs)
	{
		$this->_x = floatval($kwargs['x']);
		$this->_y = floatval($kwargs['y']);
		$this->_z = floatval($kwargs['z']);
		if (isset($kwargs['w'])){
			$this->_w = floatval($kwargs['w']);
		}
		if(isset($kwargs['color']) && $kwargs['color'] instanceof Color){
			$this->_color = $kwargs['color'];
		}else{
			$this->_color = new Color(array('red' => 255, 'green' => 255, 'blue' => 255));
		}
		
		if(Self::$verbose)
			printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, " . $this->_color . " ) constructed\n",
				$this->_x, $this->_y, $this->_z, $this->_w);
	}

	function __destruct()
	{
		if (Self::$verbose)
			printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, " 	. $this->_color . " ) destructed\n",
				$this->_x, $this->_y, $this->_z, $this->_w);
	}

	public function __toString()
	{
		if(Self::$verbose)
			return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, ", $this->_x, $this->_y, $this->_z, $this->_w) . $this->_color . " )";
		return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f )",
			$this->_x, $this->_y, $this->_z, $this->_w);
	}
}

require_once 'Color.class.php';
require_once 'Vertex.class.php';

Color::$verbose = False;

print( Vertex::doc() );
Vertex::$verbose = True;

$vtxO  = new Vertex( array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0 ) );
print( $vtxO  . PHP_EOL );

$red   = new Color( array( 'red' => 255, 'green' =>   0, 'blue' =>   0 ) );
$green = new Color( array( 'red' =>   0, 'green' => 255, 'blue' =>   0 ) );
$blue  = new Color( array( 'red' =>   0, 'green' =>   0, 'blue' => 255 ) );

$unitX = new Vertex( array( 'x' => 1.0, 'y' => 0.0, 'z' => 0.0, 'color' => $green ) );
$unitY = new Vertex( array( 'x' => 0.0, 'y' => 1.0, 'z' => 0.0, 'color' => $red   ) );
$unitZ = new Vertex( array( 'x' => 0.0, 'y' => 0.0, 'z' => 1.0, 'color' => $blue  ) );

print( $unitX . PHP_EOL );
print( $unitY . PHP_EOL );
print( $unitZ . PHP_EOL );

Vertex::$verbose = False;

$sqrA = new Vertex( array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0 ) );
$sqrB = new Vertex( array( 'x' => 4.2, 'y' => 0.0, 'z' => 0.0 ) );
$sqrC = new Vertex( array( 'x' => 4.2, 'y' => 4.2, 'z' => 0.0 ) );
$sqrD = new Vertex( array( 'x' => 0.0, 'y' => 4.2, 'z' => 0.0 ) );

print( $sqrA . PHP_EOL );
print( $sqrB . PHP_EOL );
print( $sqrC . PHP_EOL );
print( $sqrD . PHP_EOL );

$A = new Vertex( array( 'x' => 3.0, 'y' => 3.0, 'z' => 3.0 ) );
print( $A . PHP_EOL );
$equA = new Vertex( array( 'x' => 9.0, 'y' => 9.0, 'z' => 9.0, 'w' => 3.0 ) );
print( $equA . PHP_EOL );

Vertex::$verbose = True;
?>