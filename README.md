JSConcat
========

*A PHP class that helps concatenating JavaScript files and compresses them by removing comments and line breaks.*

Requirements
------------
PHP 5 should be enough. Additionally, PHP must have write permissions for the directory in which to create the concatenated JS file.

Usage
-----
Useful when you have multiple internal JS files in the same directory, for example a bunch of modules.

Include the file and run the static init method using these params:

* $relpath (string) Relative path where your js files are located.
* $files (array) JavaScript file names, excluding path but including file extension.
* $fname (string) [optional] Name of the concatenated file, including file extension. Default value is "combined.js".

### Example

```php
require_once('JSConcat.php');
jsconcat::init('js/modules', array('module1.js', 'module2.js', 'module3.js'), 'modules.js');
```

License
-------
Copyright 2013 Andreas Larsson.

This project is released under the WTFPL license: http://www.wtfpl.net/

```
DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
Version 2, December 2004

Copyright (C) 2004 Sam Hocevar <sam@hocevar.net>

Everyone is permitted to copy and distribute verbatim or modified copies of this license document, and changing it is allowed as long as the name is changed.

	DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

	0. You just DO WHAT THE FUCK YOU WANT TO.
```
