#! /usr/bin/php
<?PHP
$i = 1;
while ($i < $argc)
{
	echo $argv[$i];
	if ($i + 1 == $argc)
	{
		echo "\n";
		return ;
	}
	echo " ";
	$i++;
}
?>

