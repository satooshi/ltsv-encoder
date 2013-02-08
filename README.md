LTSV
====

LTSV serializer implementation in PHP.

[Labeled Tab-separated Values](http://ltsv.org/)


# Installation

To install LTSV-Serializer with Composer just add the following to your composer.json file:

```js
// composer.json
{
    // ...
    require: {
        // ...
        "satooshi/ltsv-serializer": "dev-master"
    }
}
```

Then, you can install the new dependencies by running Composer’s update command from the directory where your composer.json file is located:

```sh
# install
$ php composer.phar install
# update
$ php composer.phar update satooshi/ltsv-serializer

# or you can simply execute composer command if you set composer command to
# your PATH environment variable
$ composer install
$ composer update satooshi/ltsv-serializer
```

Packagist page for this library is [https://packagist.org/packages/satooshi/ltsv-serializer](https://packagist.org/packages/satooshi/ltsv-serializer)

Or you can use git clone

```sh
# HTTP
$ git clone https://github.com/satooshi/LTSV-Serializer.git
# SSH
$ git clone git@github.com:satooshi/LTSV-Serializer.git
```

# Usage

```php
<?php
// parse line
$line = "label1:value1\tlabel2:value2";
$parser = new LTSV();
$data1 = $parse->paraseLine();

/*
$data1 ->
[
  'label1' => "value1",
  'label2' => "value2"
]
 */

// parse LTSV file
$path = '/path/to/file.ltsv';
$data2 = $parser->parseFile();

/*
$data2 ->
[
  [
    'label1' => "value1",
    'label2' => "value2"
  ],
  [
    'label1' => "value1",
    'label2' => "value2"
  ]
]
 */

// dump line
$line1 = $parser->asLtsvLine($data1);

/*
$line1 -> 
"label1:value1\tlabel2:value2"
 */

// dump lines
$line2 = $parser->asLtsvLines($data2);
/*
$line2 ->
"label1:value1\tlabel2:value2\nlabel1:value1\tlabel2:value2"
 */
```
