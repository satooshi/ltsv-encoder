LTSV encoder
====

[![Build Status](https://travis-ci.org/satooshi/ltsv-encoder.png?branch=master)](https://travis-ci.org/satooshi/ltsv-encoder)

LTSV encoder implementation in PHP based on [Symfony Serializer component](http://symfony.com/doc/current/components/serializer.html).

[Labeled Tab-separated Values](http://ltsv.org/)

# Installation

To install ltsv-encoder with Composer just add the following to your composer.json file:

```js
// composer.json
{
    // ...
    require: {
        // ...
        "satooshi/ltsv-encoder": "dev-master"
    }
}
```

Then, you can install the new dependencies by running Composer’s update command from the directory where your composer.json file is located:

```sh
# install
$ php composer.phar install
# update
$ php composer.phar update satooshi/ltsv-encoder

# or you can simply execute composer command if you set composer command to
# your PATH environment variable
$ composer install
$ composer update satooshi/ltsv-encoder
```

Packagist page for this component is [https://packagist.org/packages/satooshi/ltsv-encoder](https://packagist.org/packages/satooshi/ltsv-encoder)

autoloader is installed ./vendor/autoloader.php. If you use LTSV encoder in your php script, just add:

```php
require_once 'vendor/autoload.php';
```

If you use Symfony2, autoloader has to be detected automatically.

Or you can use git clone command:

```sh
# HTTP
$ git clone https://github.com/satooshi/ltsv-encoder.git
# SSH
$ git clone git@github.com:satooshi/ltsv-encoder.git
```

# Usage

## decode($data, $format, array $context = array())

```php
<?php

use Contrib\Component\Serializer\Factory;

// deserialize
$str = "label1:value1\tlabel2:value2";
$serializer = Factory::createSerializer();
$data = $serializer->decode($str, 'ltsv');

```

result in:

```php
// $data
[
  'label1' => "value1",
  'label2' => "value2",
]
```

## encode($data, $format, array $context = array())

```php
<?php

use Contrib\Component\Serializer\Factory;

// encode
$serializer = Factory::createSerializer();
$str = $serializer->encode($data, 'ltsv');
```

result in:

```php
// $str
"label1:value1\tlabel2:value2"
```

## serialize($data, $format, array $context = array())

```php
<?php

use Contrib\Component\Serializer\Factory;

// encode
$data = new SerializableEntity(array('id' => 1, 'name' => 'hoge'));
$serializer = Factory::createSerializer();
$str = $serializer->serialize($data, 'ltsv');
```

result in:

```php
// $str
"id:1\tname:hoge"
```

## deserialize($data, $type, $format, array $context = array())

```php
<?php

use Contrib\Component\Serializer\Factory;

// deserialize
$str = "id:1\tname:hoge";
$serializer = Factory::createSerializer();
$data = $serializer->deserialize($str, 'SerializableEntity', 'ltsv');

```

result in:

```php
// $data
class SerializableEntity {
  protected $id =>
  int(1)
  protected $name =>
  string(4) "hoge"
}
```

## options
You can pass the serializer context options to the last argument in each method. This context was introduced in Symfony 2.2 Serializer component.

```php
<?php

use Contrib\Component\Serializer\Factory;

$format = 'ltsv';

// you can change these default options
$context =
[
    'to_encoding' =>'UTF-8',
    'from_encodeing' => 'auto',
    'strict' => false,
    'store_context' => false,
];

$serializer = Factory::createSerializer();
$serializer->decode($data, $format, $context);
$serializer->encode($data, $format, $context);
$serializer->serialize($data, $format, $context);
$serializer->deserialize($data, $type, $format, $context);

// change options
$context =
[
    'strict' => true,
];

// recreate serializer object
$serializer = Factory::createSerializer();
$serializer->decode($data, $format, $context);
$serializer->encode($data, $format, $context);
$serializer->serialize($data, $format, $context);
$serializer->deserialize($data, $type, $format, $context);
```
