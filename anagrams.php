<?php
/* 
 * returns the list of anagrams of the given string
 * function get_anagrams
 * @param string $needle
 * @param string $filename
 * @return array
 */
function get_anagrams($needle, $filename)
{
	$result = array();
	if(!file_exists($filename) || !is_string($needle) || strlen(trim($needle)) > 0) 
		return $result;
		
	$res = file_get_contents($filename);
	if(!$res) 
		return $result;
		
	$res = explode("\n", $res);
	$l = strlen(trim($needle)); //length of the string for which we are finding anagrams
	
	for($i = 0; $i < count($res); $i++) //go through all of the words in the opened file
	{
		if($l != strlen(trim($res[$i]))) //if length of the needle is different than the current word, skip to the next word
			continue;
		
		$word = $res[$i]; //getting a copy of the currently examined word, because we will be making some changes on it
		$is_anagram = true; //let's be optimistic and assume that the word is an anagram =)
		for($j = 0; $j < $l; $j++) //checking if every letter in $needle is present in currently examined word, which would mean that they are anagrams since they have the same length
		{
			$pos = strpos($word, $needle[$j]); //checking if the letter referenced by $j counter in needle is present in currently examined word
			if($pos !== false)
				$word = substr_replace($word, '', $pos, 1); //remove this letter from the examined word, and continue to inspect the remaining letters
			else {
				$is_anagram = false; //this word is not an anagram, move on to the next one
				break;
			}
		}

		if($is_anagram)
			$result[] = $res[$i]; //if we found an anagram, add it to the results array
	}
	
	return $result;
}

//testing the function
echo '<pre>';
print_r(get_anagrams("horse", "anagrams_file.txt"));
echo '</pre>';