<?php

require_once('Vector.class.php');
require_once('Vertex.class.php');

class Matrix
{
	const	IDENTITY	=	1;
	const	SCALE		=	2;
	const	RX			=	3;
	const	RY			=	4;
	const	RZ			=	5;
	const	TRANSLATION	=	6;
	const	PROJECTION	=	7;

	private $_vtcX;
	private $_vtcY;
	private $_vtcZ;
	private $_vtxO;
	static	$verbose;

	static public function doc()
	{
		return file_get_contents("Matrix.doc.txt");
	}

	public function __construct(array $kwargs)
	{
		switch($kwargs['preset'])
		{
			case Self::IDENTITY:
				$this->setIdentityMatrix();
				if (Self::$verbose)
					print("Matrix IDENTITY instance constructed\n");
				break;
			case Self::SCALE:
				$this->setIdentityMatrix();
				if (array_key_exists('scale', $kwargs)){
					$this->_vtcX = $this->_vtcX->scalarProduct($kwargs['scale']);
					$this->_vtcY = $this->_vtcY->scalarProduct($kwargs['scale']);
					$this->_vtcZ = $this->_vtcZ->scalarProduct($kwargs['scale']);
					$this->_vtxO->setW(1.0);
				}
				if (Self::$verbose)
					print("Matrix SCALE preset instance constructed\n");
				break;
			case Self::RX:
				$this->setRotationMatrixX($kwargs['angle']);
				if (Self::$verbose)
					print("Matrix Ox ROTATION preset instance constructed\n");
				break;
			case Self::RY:
				$this->setRotationMatrixY($kwargs['angle']);
				if(Self::$verbose)
					print("Matrix Oy ROTATION preset instance constructed\n");
				break;
			case Self::RZ:
				if (Self::$verbose)
					print("Matrix Oz ROTATION preset instance constructed\n");
				$this->setRotationMatrixZ($kwargs['angle']);
				break;
			case Self::TRANSLATION:
				$this->setIdentityMatrix();
				$this->_vtxO->setX($kwargs['vtc']->getX());
				$this->_vtxO->setY($kwargs['vtc']->getY());
				$this->_vtxO->setZ($kwargs['vtc']->getZ());
				$this->_vtxO->setW(1.0);
				if (Self::$verbose)
					print("Matrix TRANSLATION preset instance constructed\n");
				break;
			case Self::PROJECTION:
				$this->setProjection($kwargs['fov'], $kwargs['ratio'], $kwargs['near'], $kwargs['far']);
				if (Self::$verbose)
					print("Matrix PROJECTION preset instance constructed\n");
				break;
		}
	}

	function __destruct()
	{
		if (Self::$verbose)
			print("Matrix instance destructed\n");
	}

	function __ToString()
	{
		return sprintf("M | vtcX | vtcY | vtcZ | vtxO\n" . 
						"-----------------------------\n" . 
						"x | %.2f | %.2f | %.2f | %.2f\n" .
						"y | %.2f | %.2f | %.2f | %.2f\n" .
						"z | %.2f | %.2f | %.2f | %.2f\n" .
						"w | %.2f | %.2f | %.2f | %.2f\n",
						$this->_vtcX->getX(), $this->_vtcY->getX(), $this->_vtcZ->getX(), $this->_vtxO->getX(),
						$this->_vtcX->getY(), $this->_vtcY->getY(), $this->_vtcZ->getY(), $this->_vtxO->getY(),
						$this->_vtcX->getZ(), $this->_vtcY->getZ(), $this->_vtcZ->getZ(), $this->_vtxO->getZ(),
						$this->_vtcX->getW(), $this->_vtcY->getW(), $this->_vtcZ->getW(), $this->_vtxO->getW());
	}

	public function getElement($column, $row)
	{
		switch ($column)
		{
			case 1:
				if ($row == 1) return $this->_vtcX->getX();
				elseif ($row == 2) return $this->_vtcX->getY();
				elseif ($row == 3) return $this->_vtcX->getZ();
				elseif ($row == 4) return $this->_vtcX->getW();
				break;
			case 2:
				if ($row == 1) return $this->_vtcY->getX();
				elseif ($row == 2) return $this->_vtcY->getY();
				elseif ($row == 3) return $this->_vtcY->getZ();
				elseif ($row == 4) return $this->_vtcY->getW();
				break;
			case 3:
				if ($row == 1) return $this->_vtcZ->getX();
				elseif ($row == 2) return $this->_vtcZ->getY();
				elseif ($row == 3) return $this->_vtcZ->getZ();
				elseif ($row == 4) return $this->_vtcZ->getW();
				break;
			case 4:
				if ($row == 1) return $this->_vtxO->getX();
				elseif ($row == 2) return $this->_vtxO->getY();
				elseif ($row == 3) return $this->_vtxO->getZ();
				elseif ($row == 4) return $this->_vtxO->getW();
				break;
		}
	}

	public function mult(Matrix $rhs)
	{
		$dest1 = new Vertex(array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0));
		$dest2 = new Vertex(array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0));
		$dest3 = new Vertex(array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0));
		$dest4 = new Vertex(array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0));
		$a00 = $this->getElement(1, 1); $a01 = $this->getElement(1, 2); $a02 = $this->getElement(1, 3); $a03 = $this->getElement(1, 4);
        $a10 = $this->getElement(2, 1); $a11 = $this->getElement(2, 2); $a12 = $this->getElement(2, 3); $a13 = $this->getElement(2, 4);
        $a20 = $this->getElement(3, 1); $a21 = $this->getElement(3, 2); $a22 = $this->getElement(3, 3); $a23 = $this->getElement(3, 4);
        $a30 = $this->getElement(4, 1); $a31 = $this->getElement(4, 2); $a32 = $this->getElement(4, 3); $a33 = $this->getElement(4, 4);
        $b00 = $rhs->getElement(1, 1); $b01 = $rhs->getElement(1, 2); $b02 = $rhs->getElement(1, 3); $b03 = $rhs->getElement(1, 4);
        $b10 = $rhs->getElement(2, 1); $b11 = $rhs->getElement(2, 2); $b12 = $rhs->getElement(2, 3); $b13 = $rhs->getElement(2, 4);
        $b20 = $rhs->getElement(3, 1); $b21 = $rhs->getElement(3, 2); $b22 = $rhs->getElement(3, 3); $b23 = $rhs->getElement(3, 4);
        $b30 = $rhs->getElement(4, 1); $b31 = $rhs->getElement(4, 2); $b32 = $rhs->getElement(4, 3); $b33 = $rhs->getElement(4, 4);

		$dest1->setX($a00 * $b00 + $a10 * $b01 + $a20 * $b02 + $a30 * $b03);
		$dest1->setY($a01 * $b00 + $a11 * $b01 + $a21 * $b02 + $a31 * $b03);
		$dest1->setZ($a02 * $b00 + $a12 * $b01 + $a22 * $b02 + $a32 * $b03);
		$dest1->setW($a03 * $b00 + $a13 * $b01 + $a23 * $b02 + $a33 * $b03);
		$dest2->setX($a00 * $b10 + $a10 * $b11 + $a20 * $b12 + $a30 * $b13);
		$dest2->setY($a01 * $b10 + $a11 * $b11 + $a21 * $b12 + $a31 * $b13);
		$dest2->setZ($a02 * $b10 + $a12 * $b11 + $a22 * $b12 + $a32 * $b13);
		$dest2->setW($a03 * $b10 + $a13 * $b11 + $a23 * $b12 + $a33 * $b13);
		$dest3->setX($a00 * $b20 + $a10 * $b21 + $a20 * $b22 + $a30 * $b23);
		$dest3->setY($a01 * $b20 + $a11 * $b21 + $a21 * $b22 + $a31 * $b23);
		$dest3->setZ($a02 * $b20 + $a12 * $b21 + $a22 * $b22 + $a32 * $b23);
		$dest3->setW($a03 * $b20 + $a13 * $b21 + $a23 * $b22 + $a33 * $b23);
		$dest4->setX($a00 * $b30 + $a10 * $b31 + $a20 * $b32 + $a30 * $b33);
		$dest4->setY($a01 * $b30 + $a11 * $b31 + $a21 * $b32 + $a31 * $b33);
		$dest4->setZ($a02 * $b30 + $a12 * $b31 + $a22 * $b32 + $a32 * $b33);
		$dest4->setW($a03 * $b30 + $a13 * $b31 + $a23 * $b32 + $a33 * $b33);
		if ($dest1->getW() !== 0.0){
			$dest1 = $dest1->toAffine();
		}
		if ($dest2->getW() !== 0.0){
			$dest2 = $dest2->toAffine();
		}
		if ($dest3->getW() !== 0.0){
			$dest3 = $dest3->toAffine();
		}
		if ($dest4->getW() !== 0.0){
			$dest4 = $dest4->toAffine();
		}
		$f = Self::$verbose;
		Self::$verbose = false;
		$s = new Matrix(array('preset' => Self::IDENTITY));
		Self::$verbose = $f;
		$s->_vtcX = new Vector(array('dest' => $dest1, 'orig' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 0.0))));
		$s->_vtcY = new Vector(array('dest' => $dest2, 'orig' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 0.0))));
		$s->_vtcZ = new Vector(array('dest' => $dest3, 'orig' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 0.0))));
		$s->_vtxO = $dest4;
		return $s;
	}

	public function transformVertex(Vertex $vtx)
	{
		$res = new Vertex(array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 0.0));
		$res->setX($this->getElement(1, 1) * $vtx->getX() + $this->getElement(2, 1) * $vtx->getY() + $this->getElement(3, 1) * $vtx->getZ() + $this->getElement(4, 1) * $vtx->getW());
		$res->setY($this->getElement(1, 2) * $vtx->getX() + $this->getElement(2, 2) * $vtx->getY() + $this->getElement(3, 2) * $vtx->getZ() + $this->getElement(4, 2) * $vtx->getW());
		$res->setZ($this->getElement(1, 3) * $vtx->getX() + $this->getElement(2, 3) * $vtx->getY() + $this->getElement(3, 3) * $vtx->getZ() + $this->getElement(4, 3) * $vtx->getW());
		$res->setW($this->getElement(1, 4) * $vtx->getX() + $this->getElement(2, 4) * $vtx->getY() + $this->getElement(3, 4) * $vtx->getZ() + $this->getElement(4, 4) * $vtx->getW());
		return $res;
	}

	private function setIdentityMatrix()
	{
		$this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => 1.0, 'y' => 0.0, 'z' => 0.0))));
		$this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 1.0, 'z' => 0.0))));
		$this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 1.0))));
		$this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
	}

	private function setRotationMatrixX($angle)
	{
		$this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => 1.0, 'y' => 0.0, 'z' => 0.0))));
		$this->_vtcY = new Vector(array('dest' => new Vertex(array(
				'x' => 0.0,
				'y' => cos($angle),
				'z' => sin($angle)))));
		$this->_vtcZ = new Vector(array('dest' => new Vertex(array(
				'x' => 0.0,
				'y' => -sin($angle),
				'z' => cos($angle)))));
		$this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
	}

	private function setRotationMatrixY($angle)
	{
		$this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 1.0, 'z' => 0.0))));
		$this->_vtcZ = new Vector(array('dest' => new Vertex(array(
				'x' => sin($angle),
				'z' => cos($angle),
				'y' => 0.0))));
		$this->_vtcX = new Vector(array('dest' => new Vertex(array(
				'x' => cos($angle),
				'y' => 0.0,
				'z' => -sin($angle)))));
		$this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
	}

	private function setRotationMatrixZ($angle)
	{
		$this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 1.0))));
		$this->_vtcX = new Vector(array('dest' => new Vertex(array(
				'x' => cos($angle),
				'y' => sin($angle),
				'z' => 0.0))));
		$this->_vtcY = new Vector(array('dest' => new Vertex(array(
				'x' => -sin($angle),
				'y' => cos($angle),
				'z' => 0.0))));
		$this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
	}

	private function setProjection($fov, $aspect, $near, $far)
	{
		$this->_vtcX = new Vector(array('dest' => new Vertex(array(
				'x' => 1.0 / ($aspect * tan(deg2rad($fov) / 2.0)),
				'y' => 0.0,
				'z' => 0.0,
		))));
		$this->_vtcY = new Vector(array('dest' => new Vertex(array(
				'x' => 0.0,
				'y' => 1.0 / (tan(deg2rad($fov)  / 2.0)),
				'z' => 0.0,
		))));
		$this->_vtcZ = new Vector(array('dest' => new Vertex(array(
				'x' => 0.0,
				'y' => 0.0,
				'z' => -($far + $near) / ($far - $near),
				'w' => 0.0
		))));
		$this->_vtxO = new Vertex(array(
				'x' => 0.0,
				'y' => 0.0,
				'z' => - 2 * $far * $near / ($far - $near),
				'w' => 0.0
		));
	}
}

Vertex::$verbose = False;
Vector::$verbose = False;

print( Matrix::doc() );
Matrix::$verbose = True;

print( 'Let\'s start with an harmless identity matrix :' . PHP_EOL );
$I = new Matrix( array( 'preset' => Matrix::IDENTITY ) );
print( $I . PHP_EOL . PHP_EOL );

print( 'So far, so good. Let\'s create a translation matrix now.' . PHP_EOL );
$vtx = new Vertex( array( 'x' => 20.0, 'y' => 20.0, 'z' => 0.0 ) );
$vtc = new Vector( array( 'dest' => $vtx ) );
$T  = new Matrix( array( 'preset' => Matrix::TRANSLATION, 'vtc' => $vtc ) );
print( $T . PHP_EOL . PHP_EOL );

print( 'A scale matrix is no big deal.' . PHP_EOL );
$S  = new Matrix( array( 'preset' => Matrix::SCALE, 'scale' => 10.0 ) );
print( $S . PHP_EOL . PHP_EOL );

print( 'A Rotation along the OX axis :' . PHP_EOL );
$RX = new Matrix( array( 'preset' => Matrix::RX, 'angle' => M_PI_4 ) );
print( $RX . PHP_EOL . PHP_EOL );

print( 'Or along the OY axis :' . PHP_EOL );
$RY = new Matrix( array( 'preset' => Matrix::RY, 'angle' => M_PI_2 ) );
print( $RY . PHP_EOL . PHP_EOL );

print( 'Do a barrel roll !' . PHP_EOL );
$RZ = new Matrix( array( 'preset' => Matrix::RZ, 'angle' => 2 * M_PI ) );
print( $RZ . PHP_EOL . PHP_EOL );

print( 'The bad guy now, the projection matrix : 3D to 2D !' . PHP_EOL );
print( 'The values are arbitray. We\'ll decipher them in the next exercice.' . PHP_EOL );
$P = new Matrix( array( 'preset' => Matrix::PROJECTION,
						'fov' => 60,
						'ratio' => 640/480,
						'near' => 1.0,
						'far' => -50.0 ) );
print( $P . PHP_EOL . PHP_EOL );

print( 'Matrices are so awesome, that they can be combined !' . PHP_EOL );
print( 'This is a model matrix that scales, then rotates around OY axis,' . PHP_EOL );
print( 'then rotates around OX axis and finally translates.' . PHP_EOL );
print( 'Please note the reverse operations order. It\'s not an error.' . PHP_EOL );
$M = $T->mult( $RX )->mult( $RY )->mult( $S );
print( $M . PHP_EOL . PHP_EOL );

print( 'What can you do with a matrix and a vertex ?' . PHP_EOL );
$vtxA = new Vertex( array( 'x' => 1.0, 'y' => 1.0, 'z' => 0.0 ) );
print( $vtxA . PHP_EOL );
print( $M . PHP_EOL );
print( 'Transform the damn vertex !' . PHP_EOL );
$vtxB = $M->transformVertex( $vtxA );
print( $vtxB . PHP_EOL . PHP_EOL );

Vertex::$verbose = False;
Vector::$verbose = False;

print( Matrix::doc() );
Matrix::$verbose = True;

print( 'Let\'s start with an harmless identity matrix :' . PHP_EOL );
$I = new Matrix( array( 'preset' => Matrix::IDENTITY ) );
print( $I . PHP_EOL . PHP_EOL );

print( 'So far, so good. Let\'s create a translation matrix now.' . PHP_EOL );
$vtx = new Vertex( array( 'x' => 20.0, 'y' => 20.0, 'z' => 0.0 ) );
$vtc = new Vector( array( 'dest' => $vtx ) );
$T  = new Matrix( array( 'preset' => Matrix::TRANSLATION, 'vtc' => $vtc ) );
print( $T . PHP_EOL . PHP_EOL );

print( 'A scale matrix is no big deal.' . PHP_EOL );
$S  = new Matrix( array( 'preset' => Matrix::SCALE, 'scale' => 10.0 ) );
print( $S . PHP_EOL . PHP_EOL );

print( 'A Rotation along the OX axis :' . PHP_EOL );
$RX = new Matrix( array( 'preset' => Matrix::RX, 'angle' => M_PI_4 ) );
print( $RX . PHP_EOL . PHP_EOL );

print( 'Or along the OY axis :' . PHP_EOL );
$RY = new Matrix( array( 'preset' => Matrix::RY, 'angle' => M_PI_2 ) );
print( $RY . PHP_EOL . PHP_EOL );

print( 'Do a barrel roll !' . PHP_EOL );
$RZ = new Matrix( array( 'preset' => Matrix::RZ, 'angle' => 2 * M_PI ) );
print( $RZ . PHP_EOL . PHP_EOL );

print( 'The bad guy now, the projection matrix : 3D to 2D !' . PHP_EOL );
print( 'The values are arbitray. We\'ll decipher them in the next exercice.' . PHP_EOL );
$P = new Matrix( array( 'preset' => Matrix::PROJECTION,
						'fov' => 60,
						'ratio' => 640/480,
						'near' => 1.0,
						'far' => -50.0 ) );
print( $P . PHP_EOL . PHP_EOL );

print( 'Matrices are so awesome, that they can be combined !' . PHP_EOL );
print( 'This is a model matrix that scales, then rotates around OY axis,' . PHP_EOL );
print( 'then rotates around OX axis and finally translates.' . PHP_EOL );
print( 'Please note the reverse operations order. It\'s not an error.' . PHP_EOL );
$M = $T->mult( $RX )->mult( $RY )->mult( $S );
print( $M . PHP_EOL . PHP_EOL );

print( 'What can you do with a matrix and a vertex ?' . PHP_EOL );
$vtxA = new Vertex( array( 'x' => 1.0, 'y' => 1.0, 'z' => 0.0 ) );
print( $vtxA . PHP_EOL );
print( $M . PHP_EOL );
print( 'Transform the damn vertex !' . PHP_EOL );
$vtxB = $M->transformVertex( $vtxA );
print( $vtxB . PHP_EOL . PHP_EOL );
?>