Transformist
============

Transformist is a PHP file conversion library.
It provides a high level API to convert files into different formats painlessly.

It is also designed to be easily extended, just by adding custom converters.

Example
-------

You can use this fluent interface to convert a document in seconds:

```php
<?php

$converted = Transformist::convert( '/path/to/input/file.doc', 'application/msword' )
	->to( '/path/to/output/file.pdf', 'application/pdf' );

if ( $converted ) {
	// You're good to go !
}

?>
```

The _convert( )_ and _to( )_ methods both accept two parameters: a file path and a MIME type.
Note that if the input file type is omitted, then it is detected automatically.

Available conversions
---------------------

Before going any further, you may want to know about the conversions that Transformist can handle.
There's a method for that:

```php
<?php

$conversions = Transformist::availableConversions( );

?>
```

This method returns an array of all possible conversions.
Each of its key represents an input type, and points to an array of output types.

Typically, it looks like this:

```php
<?php

array(
	'image/jpeg' => array(
		'image/png'
	),
	'image/png' => array(
		'image/tiff'
	)
);

?>
```

Here you can convert JPG images to PNG, and PNG images to TIFF.

Multistep conversions
---------------------

To take full advantage of converters, Transformist can chain them together to enlarge its panel of conversions.

For example, according to the result of _Transformist::availableConversions( )_ shown above,
we can convert files from _image/jpeg_ to _image/png_, and from _image/png_ to _image/tiff_.
With multistep conversions enabled, those two converters would be chained together,
allowing a conversion from _image/jpeg_ to _image/tiff_.

This is of course slower, as it takes multiple conversions for one file, but it can be really useful in some cases.

To turn on this mechanism, use the _configure( )_ method:

```php
<?php

Transformist::configure( array( 'multistep' => true ));

/**
 *	If you want more control, you can also set the maximum number of intermediate
 *	conversions, to avoid endless converter chains.
 *	For example, the following line allows chaining of 3 converters maximum.
 */

Transformist::configure( array( 'multistep' => 2 ));

?>
```

After that, a call to _Transformist::availableConversions( )_ will return:

```php
<?php

array(
	'image/jpeg' => array(
		'image/png',
		'image/tiff'
	),
	'image/png' => array(
		'image/tiff'
	)
);

?>
```

Test
----

Transformist provides a way to check all converters for validity.
Some could be runnable without further configuration, while others could rely on external librairies that must be installed for the converter to work.

```php
<?php

$results = Transformist::testConverters( );

?>
```

$results now looks like this:

```php
<?php

array(
	'Transformist_Converter_Office_Pdf' => true,
	'Transformist_Converter_Office_Png' => 'An external library is missing!',
	'Transformist_Converter_Office_Tiff' => true
);

?>
```

You should run this function only once when configuring your system or troubleshooting errors,
as some converters could do some heavy computation to test their environment.
