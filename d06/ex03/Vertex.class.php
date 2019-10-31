<?php

require_once 'Color.class.php';

class Vertex
{
	private $_x;
	private $_y;
	private $_z;
	private $_w = 1;
	private $_color;
	static	$verbose;

	static public function doc()
	{
		echo "\n";
		echo file_get_contents("Vertex.doc.txt");
		echo "\n";
	}

	public function __construct($kwargs)
	{
		$this->_x = floatval($kwargs['x']);
		$this->_y = floatval($kwargs['y']);
		$this->_z = floatval($kwargs['z']);;
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
			printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, " . $this->_color . " ) destructed\n",
				$this->_x, $this->_y, $this->_z, $this->_w);
	}

	public function __ToString()
	{
		if(Self::$verbose)
			return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, ", $this->_x, $this->_y, $this->_z, $this->_w) . $this->_color . " )";
		return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f )",
			$this->_x, $this->_y, $this->_z, $this->_w);
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
		if ($property === 'w')
			return $this->_w;
		if ($property === 'color')
			return $this->_color;
	}

	public function toAffine()
	{ 
		return new Vertex(array(
			'x' => $this->_x / $this->_w,
			'y' => $this->_y / $this->_w,
			'z' => $this->_z / $this->_w,
			'w' => $this->_w / $this->_w
		));
	}

	public function getX() { return $this->_x; }

	public function getY() { return $this->_y; }

	public function getZ() { return $this->_z; }

	public function getW() { return $this->_w; }

	public function getColor() { return $this->_color; }

	public function setX($x) { $this->_x = $x;}

	public function setY($y) { $this->_y = $y; }

	public function setZ($z) { $this->_z = $z; }
	
	public function setW($w) { $this->_w = $w;}

	public function setColor(Color $color) { $this->_color = $color; }

}
?>