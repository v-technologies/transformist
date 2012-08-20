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
If the input file type is omitted, then it is detected automatically.

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

Here you can convert JPG images to PNG, and PNG images to TIFF. Alternatively, you can check if a particular Document can be converted:

```php
<?php

$canBeConverted = Transformist::canConvert( $Document );

?>
```

Multistep conversions
---------------------

To take full advantage of converters, Transformist can chain them together to enlarge its panel of conversions.

For example, according to the result of Transformist::availableConversions( ) shown above,
we can convert files from _image/jpeg_ to _image/png_, and from _image/png_ to _image/tiff_.
With multistep conversions enabled, those two converters would be chained together,
allowing a conversion from _image/jpeg_ to _image/tiff_.

This is of course slower, as it takes multiple conversions for one file, but it can be really useful in some cases.

To turn on this mechanism, just call this method:

```php
<?php

Transformist::enableMultistepConversions( true );

?>
```

After that, a call to Transformist::availableConversions( ) will return:

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
