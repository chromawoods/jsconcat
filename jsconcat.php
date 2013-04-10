<?php
/***
 * Concatenates JavaScript files and compresses them
 * by removing comments, line breaks and unnecessary spaces.
 * Copyright 2013 Andreas Larsson <andreas@chromawoods.com> - http://chromawoods.com/
 * Released under the WTFPL license: http://www.wtfpl.net/
 * 
 * @version 0.2
 * @author Andreas Larsson
 * 
 * @param string $relpath Relative path where the files are located.
 * @param array $files Filenames, not including path but including file extension.
 * @param string $fname Name of the combined file, including file extension.
 */
function jsconcat($relpath, $files, $fname = "combined.js") {
	$relpath = trim($relpath, "/") . "/";
	$furl = $relpath . $fname;
	$tempcontent = "";
	
	// Replaces last occurance of a string within another string.
	$replace_last = function ($search, $replace, $subject) {
		$pos = strrpos($subject, $search);
		if($pos !== false) {
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	};
	
	$prepend = "/* " . $fname . " was created by jsconcat on " . date('M j Y H:i:s') . " by combining " . $replace_last(',', ' and', implode(", ", $files)) . " */\n";
	
	file_put_contents($furl, $prepend);
	
	foreach ($files as $f) {
		// Fetch contents of next file
		$tempcontent = file_get_contents($relpath . $f);
		
		$tempcontent = trim(preg_replace('/\s+/', ' ', // Remove line breaks
			preg_replace('#\s*//.+$#m', "", // Strip single line comments
			preg_replace('#/\*[^*]*\*+([^/][^*]*\*+)*/#', "", // Strip multi line comments
			$tempcontent))));
		
		// Strip some spaces
		$tempcontent = str_replace(
			array(' }', '{ ', '; ', ', ', '} else', 'else {', 'if (', ' : function', ' = function', 'function (', ') {', ' = ', ' == ', ' === ', ' + ', ' += ', ' != ', ' !== ', ', '), // Replace these...
			array('}', '{', ';', ',', '}else', 'else{', 'if(', ':function', '=function', 'function(', '){', '=', '==', '===', '+', '+=', '!=', '!==', ','), // ..with these
			$tempcontent);
		
		// Append to combined file
		file_put_contents($furl, $tempcontent, FILE_APPEND | LOCK_EX);
	}
}
?>
