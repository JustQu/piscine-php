<?php

require_once 'Vertex.class.php';

class Vector
{
	private $_x;
	private $_y;
	private $_z;
	private $_w = 0.0;
	static $verbose;

	static public function doc()
	{
		echo "\n";
		echo file_get_contents("Vector.doc.txt");
		echo "\n";
	}

	public function __construct(array $kwargs)
	{
		if (!array_key_exists('orig', $kwargs))
			$kwargs['orig'] = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
		$this->_x = $kwargs['dest']->x - $kwargs['orig']->x;
		$this->_y = $kwargs['dest']->y - $kwargs['orig']->y;
		$this->_z = $kwargs['dest']->z - $kwargs['orig']->z;

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
		return sprintf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f )", $this->x, $this->y, $this->z, $this->w);
	}

	public function magnitude()
	{
		return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z);
	}

	public function normalize()
	{
		$norm = 1.0 / $this->magnitude();
		$array['x'] = $this->x * $norm;
		$array['y'] = $this->y * $norm;
		$array['z'] = $this->z * $norm;		
		return new Vector(array('dest' => new Vertex($array)));
	}

	public function add(Vector $rhs)
	{
		$array['x'] = $this->x + $rhs->x;
		$array['y'] = $this->y + $rhs->y;
		$array['z'] = $this->z + $rhs->z;		
		return new Vector(array('dest' => new Vertex($array)));
	}

	public function sub(Vector $rhs)
	{
		$array['x'] = $this->x - $rhs->x;
		$array['y'] = $this->y - $rhs->y;
		$array['z'] = $this->z - $rhs->z;
		return new Vector(array('dest' => new Vertex($array)));
	}

	public function opposite()
	{
		$array['x'] = $this->x * -1;
		$array['y'] = $this->y * -1;
		$array['z'] = $this->z * -1;
		return new Vector(array('dest' => new Vertex($array)));
	}

	public function scalarProduct($k)
	{
		$array['x'] = $this->x * $k;
		$array['y'] = $this->y * $k;
		$array['z'] = $this->z * $k;
		return new Vector(array('dest' => new Vertex($array)));
	}

	public function dotProduct(Vector $rhs)
	{
		return $this->x * $rhs->x + $this->y * $rhs->y + $this->z * $rhs->z;
	}

	public function cos(Vector $rhs)
	{
		$a = $this->magnitude() * $rhs->magnitude();
		if ($a == 0) {
			return 0;
		}
		$inv = 1.0 / ($this->magnitude() * $rhs->magnitude());
		return $this->dotProduct($rhs) * $inv;
	}

	public function crossProduct(Vector $rhs)
	{
		$array['x'] = $this->y * $rhs->z - $this->z * $rhs->y;
		$array['y'] = -$this->x * $rhs->z + $this->z * $rhs->x;
		$array['z'] = $this->x * $rhs->y - $this->y * $rhs->x;
		return new Vector(array('dest' => new Vertex($array)));
	}
}

require_once 'Vertex.class.php';
require_once 'Vector.class.php';


Vertex::$verbose = False;

print( Vector::doc() );
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

print( 'Magnitude is ' . $vtc2->magnitude() . PHP_EOL );

$nVtc2 = $vtc2->normalize();
print( 'Normalized $vtc2 is ' . $nVtc2 . PHP_EOL );
print( 'Normalized $vtc2 magnitude is ' . $nVtc2->magnitude() . PHP_EOL );

print( '$vtc1 + $vtc2 is ' . $vtc1->add( $vtc2 ) . PHP_EOL );
print( '$vtc1 - $vtc2 is ' . $vtc1->sub( $vtc2 ) . PHP_EOL );
print( 'opposite of $vtc1 is ' . $vtc1->opposite() . PHP_EOL );
print( 'scalar product of $vtc1 and 42 is ' . $vtc1->scalarProduct( 42 ) . PHP_EOL );
print( 'dot product of $vtc1 and $vtc2 is ' . $vtc1->dotProduct( $vtc2 ) . PHP_EOL );
print( 'cross product of $vtc1 and $vtc2 is ' . $vtc1->crossProduct( $vtc2 ) . PHP_EOL );
print( 'cross product of $vtcXunit and $vtcYunit is ' . $vtcXunit->crossProduct( $vtcYunit ) . 'aka $vtcZunit' . PHP_EOL );
print( 'cosinus of angle between $vtc1 and $vtc2 is ' . $vtc1->cos( $vtc2 ) . PHP_EOL );
print( 'cosinus of angle between $vtcXunit and $vtcYunit is ' . $vtcXunit->cos( $vtcYunit ) . PHP_EOL );
?>