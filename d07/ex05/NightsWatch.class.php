<?php
class NightsWatch implements IFighter
{
	private $warriors;

	public function fight()
	{
		if (is_array($this->warriors)){
			foreach ($this->warriors as $a){
				if ($a instanceof IFighter){
					$a->fight();
				}
			}
		}
	}

	public function recruit($new_warrior)
	{
		$this->warriors[] = $new_warrior;
	}
}
?>