JSConcat
========

*A PHP class that helps concatenating JavaScript files and compresses them by removing comments and line breaks.*

Requirements
------------
PHP 5 should be enough. Additionally, PHP must have write permissions for the directory in which to create the concatenated JS file.

When to use
-----------
Useful when you have multiple internal JS files in the same directory, for example a bunch of modules. Use JSConcat.php in a development environment and then just deploy the combined file to production and let the individual JS files stay on your dev env. There's no point of having the production server concatenate a bunch of files in every request.

How to use
----------
Include the file and run the static ```init``` method using these params:

* ```$rel_path``` (string) Relative path where your js files are located.
* ```$files``` (array) JavaScript file names, excluding path but including file extension.
* ```$fname``` (string) [optional] Name of the concatenated file, including file extension. Default value is "combined.js".

### Example

```php
require_once('JSConcat.php');
$filesToConcat = array('NiftyModule.js', 'AwesomeModule.js', 'ChuckNorrisModule.js');
JSConcat::init('js/modules', $filesToConcat, 'modules.js');
```

TODO
----
* Make param ```$files``` optional - would concatenate all .js files in a directory except ```$fname```.

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
