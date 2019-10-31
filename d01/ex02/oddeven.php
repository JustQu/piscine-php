#! /usr/bin/php
<?PHP
echo "Enter a number: ";
while(($a = fgets(STDIN)) != false){
	$a = str_replace("\n", "", "$a");
	if (is_numeric($a))
	{
		if ($a % 2 == 0)
			echo "The number " . $a . " is even\n";
		else
			echo "The number " . $a . " is odd\n";
	}
	else
	{
		echo "'" .$a . "' is not a number\n";
	}
	echo "Enter a number: ";
}
echo "\n";
?>
