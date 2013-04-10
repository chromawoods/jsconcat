jsconcat
========

*A PHP function that concatenates JavaScript files and compresses them by removing comments, line breaks and unnecessary spaces.*

Requirements
------------
PHP 5.3, because the script has an anonymous function baked into it. :) I'm going to fix this later by classifying jsconcat.

Usage
-----
Useful when you have multiple internal JS files in the same directory, for example a bunch of modules.

Include the file and run the function using these params:

* $relpath (string) Relative path where your js files are located.
* $files (array) JavaScript file names, excluding path but including file extension.
* $fname (string) [optional] Name of the concatenated file, including file extension. Default value is "combined.js".

### Example

```php
require_once('jsconcat.php');
jsconcat('js', array('module1.js', 'module2.js', 'module3.js'), 'modules.js');
```

Please note that the combined JS file will end up in the same directory as the rest of the JS files. I might transform jsconcat into a Class later on, but for now I'll just keep it simple.