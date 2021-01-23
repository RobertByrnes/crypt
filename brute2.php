<?php
function BruteForce($testChars, $startLength, $endLength, $testCallback)
{
	for ($len = $startLength; $len <= $endLength; ++$len)
	{
		$chars = array();

		for ($i = 0; $i < $len; ++$i)
			$chars[$i] = $testChars[0];

		if ($testCallback($chars))
			return true;

		for ($i1 = $len - 1; $i1 > -1; --$i1)
		{
			$i2 = 0;
			$testCharsLen = strlen($testChars);
			
			for ($i2 = strpos($testChars, $chars[$i1]) + 1; $i2 < $testCharsLen; ++$i2)
			{
				$chars[$i1] = $testChars[$i2];

				if ($testCallback($chars))
					return true;

				for ($i3 = $i1 + 1; $i3 < $len; ++$i3)
				{
					if ($chars[$i3] != $testChars[$testCharsLen - 1])
					{
						$i1 = $len;
						goto outerBreak;
					}
				}
			}

			outerBreak:
			if ($i2 == $testCharsLen)
				$chars[$i1] = $testChars[0];
		}
	}

	return false;
}

								


// Example
									
$BruteForceTest = function ($testChars) {
	return strcmp(implode($testChars), "bbc") == 0;
};

$result = BruteForce("abcde", 1, 5, $BruteForceTest);
echo $result;
				