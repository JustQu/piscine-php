<?php
class UnholyFactory
{
	private $fighters = array();

	public function absorb($fighter)
	{
		if ($fighter instanceof Fighter){
			foreach ($this->fighters as $f){
				if ($f->getType() == $fighter->getType()){
					printf("(Factory already absorbed a fighter of type %s)\n", $fighter->getType());
					return ;
				}
			}
				$this->fighters[] = $fighter;
				printf("(Factory absorbed a fighter of type %s)\n", $fighter->getType());
		} else {
			print("(Factory can't absorb this, it's not a fighter)\n");
		}
	}

	public function fabricate($requested_fighter)
	{
		foreach ($this->fighters as $fighter){
			if ($fighter->getType() === $requested_fighter){
				print ("(Factory fabricates a fighter of type $requested_fighter)\n");
				return clone $fighter;
			}
		}
		print("(Factory hasn't absorbed any fighter of type $requested_fighter)\n");
		return null;
	}
}
?>