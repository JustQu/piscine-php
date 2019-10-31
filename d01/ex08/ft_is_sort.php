#! /usr/bin/php
<?PHP
function ft_is_sort($array)
{
	$default = $array;
	sort($array);
	foreach ($array as $key => $value)
	{
		if ($default[$key] != $value)
			return false;
	}
	return true;
}
?>