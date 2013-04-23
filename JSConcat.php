<?php
/***
 * Concatenates JavaScript files and compresses them
 * by removing comments and line breaks.
 * Copyright 2013 Andreas Larsson <andreas@chromawoods.com> - http://chromawoods.com/
 * Released under the WTFPL license: http://www.wtfpl.net/
 * 
 * @version 1.2
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
     * @param type $files (optional) Filenames, not including path but including file extension. If omitted, JSConcat will attempt to combine all .js files in the specified directory.
     * @param type $fname (optional) Name of the combined file, including file extension.
     */
	public static function init($rel_path, $files = array(), $fname = "combined.js") {
		self::$status = "processing";

		$rel_path = trim($rel_path, "/") . "/";
        
        if (!is_writable($rel_path) || !is_dir($rel_path)) {
            self::$status = "error";
            die('JSConcat directory error. Output directory "' . $rel_path . '" might not exist or does not have write permissions');
        }
        
        // No input files specified, attempt to combine all js files in directory.
        if (count($files) === 0) {
            $files = glob($rel_path . '*.js');
            $count = count($files);
            for($i = 0; $i < $count; $i++) :
                $f = $files[$i];
                if ($f === $fname) { // Do not include existing combined file.
                    unset($files[$i]);
                } else {
                    $files[$i] = basename($f);
                }
            endfor;
        }
        
		$furl = $rel_path . $fname;
		$temp_content = "";
		$final_content = "";
		$prepend = "/* " . $fname . " was created by JSConcat on " . date('M j Y H:i:s') . " by combining " . self::replace_last(',', ' and', implode(", ", $files)) . " */\n";
		
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
