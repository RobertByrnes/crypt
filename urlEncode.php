<?php
function DecimalToHexadecimal($dec)
{
	if ($dec < 1) return "0";

	$hex = $dec;
	$hexStr = "";

	while ($dec > 0)
	{
		$hex = $dec % 16;

		if ($hex < 10)
			$hexStr = substr_replace($hexStr, chr($hex + 48), 0, 0);
		else
			$hexStr = substr_replace($hexStr, chr($hex + 55), 0, 0);

		$dec = floor($dec / 16);
	}

	return $hexStr;
}

function EncodeURL($data, $count) {
	$result = "";
	
	for ($i = 0; $i < $count; $i++)
	{
		$c = $data[$i];

		if (('a' <= $c && $c <= 'z') || ('A' <= $c && $c <= 'Z') || ('0' <= $c && $c <= '9'))
		{
			$result .= $c;
		}
		else
		{
			$result .= "%";
			$result .= str_pad(DecimalToHexadecimal(ord($c)), 2, "0", STR_PAD_LEFT);
		}
	}
	
	return $result;
}
$data = "jdfgsdhfsdfsd 6445dsfsd7fg/*/+bfjsdgf%$^";
$value = EncodeURL($data, strlen($data));
echo $data.'<br>';
echo $value.'<br>';

function HexadecimalToDecimal($hex) {
	$hex = strtoupper($hex);

	$hexLength = strlen($hex);
	$dec = 0.0;

	for ($i = 0; $i < $hexLength; $i++)
	{
		$b = ord($hex[$i]);
		
		if ($b >= 48 && $b <= 57)
			$b -= 48;
		else if ($b >= 65 && $b <= 70)
			$b -= 55;

		$dec += $b * pow(16, (($hexLength - $i) - 1));
	}

	return (int)$dec;
}

function DecodeURL($data, $count) {
	$j = 0;

	for ($i = 0; $i < $count; $i++, $j++)
	{
		if ($data[$i] == '%')
		{
			$h = $data[$i + 1] . $data[$i + 2];
			$result[$j] = chr(HexadecimalToDecimal($h));
			$i += 2;
		}
		else
		{
			$result[$j] = $data[$i];
		}
	}

	return implode("", $result);
}
$value = DecodeURL($value, strlen($value));
echo $value.'<br>';