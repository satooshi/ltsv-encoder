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

## unserialize($str)

```php
<?php

use Contrib\Component\Serializer\LtsvSerializer;

// deserialize
$str = "label1:value1\tlabel2:value2";
$serializer = new LtsvSerializer();
$data = $serializer->deserialize($str);

```

result in:

```php
// $data
[
  'label1' => "value1",
  'label2' => "value2",
]
```

## serialize($data)

```php
<?php

use Contrib\Component\Serializer\LtsvSerializer;

// serialize
$serializer = new LtsvSerializer();
$str = $serializer->serialize($data);
```

result in:

```php
// $str
"label1:value1\tlabel2:value2"
```

## options
You can pass options to constructor.

```php
<?php

use Contrib\Component\Data\Serializer\LtsvSerializer;

$serializer = new LtsvSerializer(
    // default options
    [
        'to_encoding' =>'UTF-8',
        'from_encodeing' => 'auto',
        'strict' => false,
    ]
);
```