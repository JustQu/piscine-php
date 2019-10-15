<?php

require_once 'Vertex.class.php';

class Vector
{
	private $_x;
	private $_y;
	private $_z;
	private $_w = 0;
	static $verbose;

	public function __construct(array $args)
	{
		if (!array_key_exists('orig', $args))
			$args['orig'] = new Vertex( array( 'x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
		$this->_x = $args['dest']->_x - $args['orig']->_x;
		$this->_y = $args['dest']->_y - $args['orig']->_y;
		$this->_z = $args['dest']->_z - $args['orig']->_z;

		if (Self::$verbose){
			print($this . " constructed\n");
		}
	}

	function __destruct()
	{
		if (Self::$verbose){
			print($this . " destructed\n");
		}
	}

	function __get($property)
	{
		if (property_exists($this, $property))
			return $this->$property;
		if ($property === 'x')
			return $this->_x;
		if ($property === 'y')
			return $this->_y;
		if ($property === 'z')
			return $this->_z;
	}

	public function __ToString()
	{
		return sprintf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f )", $this->_x, $this->_y, $this->_z, $this->_w);
	}

	public function magnitude()
	{
		return sqrt($this->_x * $this->_x + $this->_y * $this->_y + $this->_z * $this->_z);
	}

	public function normalize()
	{
		$norm = 1 / $this->magnitude;
		return new Vector($this->_x * $norm, $this->_y * $norm, $this->_z * $norm);
	}

	public function add(Vector $rhs)
	{
		return new Vector($this->x + $rhs->x, $this->y + $rhs->y, $this->z + $rhs->z);
	}

	public function sub(Vector $rhs)
	{
		return new Vector($this->x - $rhs->x, $this->y - $rhs->y, $this->z - $rhs->z);
	}

	public function opposite()
	{
		return new Vector($this->x * -1, $this->y * -1, $this->z * -1);
	}

	public function scalarProduct($k)
	{
		return new Vector($this->x * $k, $this->y * $k, $this->z * $k);
	}

	public function dotProduct(Vector $rhs)
	{
		return new Vector($this->x * $rhs->x, $this->y * $rhs->y, $this->z * $rhs->z);
	}

	public function cos(Vector $rhs)
	{
		$inv = $this->magnitude() * $rhs->magnitude();
		return $this->dotProduct($rhs) * $inv;
	}
}

Vertex::$verbose = False;

Vector::$verbose = True;

$vtxO = new Vertex( array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0 ) );
$vtxX = new Vertex( array( 'x' => 1.0, 'y' => 0.0, 'z' => 0.0 ) );
$vtxY = new Vertex( array( 'x' => 0.0, 'y' => 1.0, 'z' => 0.0 ) );
$vtxZ = new Vertex( array( 'x' => 0.0, 'y' => 0.0, 'z' => 1.0 ) );

$vtcXunit = new Vector( array( 'orig' => $vtxO, 'dest' => $vtxX ) );
$vtcYunit = new Vector( array( 'orig' => $vtxO, 'dest' => $vtxY ) );
$vtcZunit = new Vector( array( 'orig' => $vtxO, 'dest' => $vtxZ ) );

print( $vtcXunit . PHP_EOL );
print( $vtcYunit . PHP_EOL );
print( $vtcZunit . PHP_EOL );

$dest1 = new Vertex( array( 'x' => -12.34, 'y' => 23.45, 'z' => -34.56 ) );
Vertex::$verbose = True;
$vtc1  = new Vector( array( 'dest' => $dest1 ) );
Vertex::$verbose = False;

$orig2 = new Vertex( array( 'x' => 23.87, 'y' => -37.95, 'z' => 78.34 ) );
$dest2 = new Vertex( array( 'x' => -12.34, 'y' => 23.45, 'z' => -34.56 ) );
$vtc2  = new Vector( array( 'orig' => $orig2, 'dest' => $dest2 ) );
?>