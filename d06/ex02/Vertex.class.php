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
		echo "\n";
		echo file_get_contents("./Vertex.doc.txt");
		echo "\n";
	}

	public function __construct($args)
	{
		$this->_x = $args['x'];
		$this->_y = $args['y'];
		$this->_z = $args['z'];
		if (isset($args['w'])){
			$this->_w = intval($args['w']);
		}
		if(isset($args['color']) && $args['color'] instanceof Color){
			$this->_color = $args['color'];
		}else{
			$this->_color = new Color(array('red' => 255, 'green' => 255, 'blue' => 255));
		}
		
		if(Self::$verbose)
			printf("Vertex( x: %.2f, y: %.2f, z: %.2f, w: %.2f, " . $this->_color . " ) constructed\n",
				$this->_x, $this->_y, $this->_z, $this->_w);
	}

	function __destruct()
	{
		if (Self::$verbose)
			printf("Vertex( x: %.2f, y: %.2f, z: %.2f, w: %.2f, " 	. $this->_color . " ) destructed\n",
				$this->_x, $this->_y, $this->_z, $this->_w);
	}

	public function __ToString()
	{
		if(Self::$verbose)
			return sprintf("Vertex( x: %.2f, y: %.2f, z: %.2f, w: %.2f, ", $this->_x, $this->_y, $this->_z, $this->_w) . $this->_color . " )";
		return sprintf("Vertex( x: %.2f, y: %.2f, z: %.2f, w: %.2f )",
			$this->_x, $this->_y, $this->_z, $this->_w);
	}

	function __get($property)
	{
		if (property_exists($this, $property))
			return $this->$property;
	}
}
?>