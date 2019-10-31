<?php

require_once 'Vertex.class.php';

class Vector
{
	private $_x;
	private $_y;
	private $_z;
	private $_w = 0;
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
		$this->_w = $kwargs['dest']->w - $kwargs['orig']->w;
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

	function __ToString()
	{
		return sprintf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f )", $this->x, $this->y, $this->z, $this->w);
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

	public function getX() { return $this->_x; }

	public function getY() { return $this->_y; }

	public function getZ() { return $this->_z; }

	public function getW() { return $this->_w; }

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
?>