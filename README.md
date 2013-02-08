LTSV
====

Simple LTSV parser implementation in PHP.

[Labeled Tab-separated Values](http://ltsv.org/)


# Installation

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
