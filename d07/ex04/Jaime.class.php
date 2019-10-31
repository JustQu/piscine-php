<?php
class Jaime extends Lannister
{
	public function sleepWith($who)
	{
		if ($who instanceof Cersei){
			print ("With pleasure, but only in a tower in Winterfell, then." . PHP_EOL);
		} else {
			Lannister::sleepWith($who);
		}
	}
}
?>