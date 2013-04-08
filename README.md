jsconcat
========

*A PHP function that concatenates JavaScript files and compresses them by removing comments, line breaks and unnecessary spaces.*

Usage
-----
Useful when you have multiple internal JS files in the same directory, for example a bunch of modules.

Include the file and run the function using these params:

* $relpath (*string*) Relative path where your js files are located.
* $files (*array*) JavaScript file names, excluding path.
* $fname (*string*) [optional] Name of the concatenated file, excluding file extension. Default value is "combined".

Please note that the combined JS file will end up in the same directory as the rest of the JS files. I might transform jsconcat into a Class later on, but for now I'll just keep it simple.