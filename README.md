Transformist
============

Transformist is a PHP file conversion library.
It provides a high level API to convert files into different formats painlessly.

It is also designed to be easily extended, just by adding custom converters.

Example
-------

First, we need to create a Document object, which will hold informations about the file we want to convert.

```php
<?php

$Document = new Transformist_Document(
	new Transformist_FileInfo( '/path/to/input/file.doc' ),
	new Transformist_FileInfo( '/path/to/output/file.pdf', 'application/pdf' )
);

?>
```

A FileInfo object represents a file on the file system, associated to its MIME types.
In the above example, the type of the the input file can be detected automatically,
but we have to specify the output file type, as this file doesn't exists for now.

Document constructor takes two FileInfo objects, representing input and output files.
Here, we want to convert an Office file to a PDF.

Now, we just have to let Transformist do the hard work for us:

```php
<?php

Transformist_Transformist::convert( $Document );

if ( $Document->isConverted( )) {
	// That's all !
}

?>
```

Available conversions
---------------------

Before going anywhere, you may want to know about the conversions that Transformist can handle.
There's a method for that:

```php
<?php

$conversions = Transformist_Transformist::availableConversions( );

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

$canBeConverted = Transformist_Transformist::canConvert( $Document );

?>
```

Multistep conversions
---------------------

To take full advantage of converters, Transformist can chain them together to enlarge its panel of conversions.

For example, according to the result of Transformist::availableConversions( ) shown above,
we can convert _image/jpeg_ to _image/png_, and _image/png_ to _image/tiff_.
With multistep conversions enabled, those two converters would be chained together,
allowing a conversion from _image/jpeg_ to _image/tiff_.

This is of course slower, as it takes multiple conversions for one file, but it can be really useful in some cases.

To turn on this mechanism, just call this method:

```php
<?php

Transformist_Transformist::enableMultistepConversions( true );

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
