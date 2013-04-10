<?php
/***
 * Concatenates JavaScript files and compresses them
 * by removing comments, line breaks and unnecessary spaces.
 * Copyright 2013 Andreas Larsson <andreas@chromawoods.com> - http://chromawoods.com/
 * Released under the WTFPL license: http://www.wtfpl.net/
 * 
 * @version 1.1
 * @author Andreas Larsson
 */

class JSConcat {
	
	public static $status = "uninitialized";
	
    /**
     * Replaces last occurance of a string with another string within a string.
     * 
     * @param string $search The string to search for.
     * @param string $replace The replacement.
     * @param string $subject The string to search within.
     * @return string The new string.
     */
	private function replace_last($search, $replace, $subject) {
		$pos = strrpos($subject, $search);
		if($pos !== false) {
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}
	

    /**
     * Primary method. Concatenates JS files and minifies them.
     * 
     * @param string $rel_path Relative path where the files are located.
     * @param type $files Filenames, not including path but including file extension.
     * @param type $fname Name of the combined file, including file extension.
     */
	public static function init($rel_path, $files, $fname = "combined.js") {
		self::$status = "processing";
        
		$rel_path = trim($rel_path, "/") . "/";
		$furl = $rel_path . $fname;
		$temp_content = "";
		$final_content = "";
		$prepend = "/* " . $fname . " was created by JSConcat on " . date('M j Y H:i:s') . " by combining " . self::replace_last(',', ' and', implode(", ", $files)) . " */\n";
		
        if (!is_writable($rel_path)) {
            self::$status = "error";
            die('JSConcat needs write permissions for directory ' . $rel_path);
        }
        
		file_put_contents($furl, $prepend);
		
		foreach ($files as $f) {
			$temp_content = file_get_contents($rel_path . $f); // Fetch contents of next file
			$temp_content = trim(preg_replace('/\s+/', ' ', // Remove line breaks
				preg_replace('#\s*//.+$#m', "", // Strip single line comments
				preg_replace('#/\*[^*]*\*+([^/][^*]*\*+)*/#', "", // Strip multi line comments
				$temp_content))));
			
			$final_content .= $temp_content;
		}
		
		// Append to combined file
		file_put_contents($furl, $final_content, FILE_APPEND | LOCK_EX);
		self::$status = "done";
	}
}
?>
