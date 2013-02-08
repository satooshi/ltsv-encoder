<?php
namespace Contrib\Component\Data\Serializer;

/**
 * LTSV serializer.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvSerializer
{
    /**
     * Tab separator.
     *
     * @var string
     */
    const SEPARATOR = "\t";

    /**
     * Label-value delimiter.
     *
     * @var string
     */
    const DELIMITER = ':';

    /**
     * Strict label pattern.
     *
     * @var string
     */
    const STRICT_LABEL_PATTERN = '/^[0-9A-Za-z_.-]+$/';

    /**
     * Strict value pattern.
     *
     * @var string
     */
    const STRICT_VALUE_PATTERN = '/^[\x01-\x08\x0B\x0C\x0E-\xFF]+$/';

    /**
     * Serializer options.
     *
     * * to_encoding: UTF-8
     * * from_encoding: auto
     * * strict: false
     *
     * @var array
     */
    protected $options;

    /**
     * Constructor.
     *
     * @param array $options Serializer options.
     */
    public function __construct(array $options = array())
    {
        $this->options = $options + array(
            'to_encoding'   => 'UTF-8',
            'from_encoding' => 'auto',
            'strict'        => false,
        );
    }

    // API

    /**
     * Serialize data.
     *
     * @param array $data LTSV items.
     * @return string Serialized LTSV line.
     */
    public function serialize($data)
    {
        $fields = array();

        foreach ($items as $label => $value) {
            $fields[] = $this->serializeField($label, $value);
        }

        return implode(static::SEPARATOR, $fields);
    }

    /**
     * Unserialize LTSV line.
     *
     * @param string $str LTSV line.
     * @return array Unserialized LTSV items.
     */
    public function unserialize($str)
    {
        $line      = $this->convertEncoding($str);
        $tsvFields = explode(static::SEPARATOR, trim($line));
        $items     = array();

        foreach ($tsvFields as $tsvField) {
            list($label, $value) = $this->unserializeField($tsvField);

            $this->assertLabel($label);
            $this->assertValue($value);

            $items[$label] = $value;
        }

        return $items;
    }

    // internal method

    /**
     * Convert encoding.
     *
     * @param string $str Converting string.
     * @return string Converted string.
     */
    protected function convertEncoding($str)
    {
        return mb_convert_encoding($str, $this->options['to_encoding'], $this->options['from_encoding']);
    }

    /**
     * Serialize LTSV field.
     *
     * @param string $label Label.
     * @param string $value Value.
     * @return string Serialized LTSV field.
     * @throws \RuntimeException
     */
    protected function serializeField($label, $value)
    {
        $convertedLabel = $this->convertEncoding($label);

        $this->assertLabel($convertedLabel);

        if ($value === null) {
            $value = '';
        }

        if (is_object($value) && method_exists($value, '__toString')) {
            $value = "$value";
        }

        if (is_scalar($value)) {
            $convertedValue = $this->convertEncoding($value);

            $this->assertValue($convertedValue);

            return sprintf('%s%s%s', $convertedLabel, static::DELIMITER, $convertedValue);
        }

        throw new \RuntimeException(sprintf('Could not serialize LTSV value of label:%s.', $label));
    }

    /**
     * Unserialize LTSV field.
     *
     * @param string $tsvField LTSV field.
     * @return array LTSV item.
     * @throws \RuntimeException Throw on parse error.
     */
    protected function unserializeField($tsvField)
    {
        if (false !== stripos($tsvField, static::DELIMITER)) {
            $labelValue = explode(static::DELIMITER, $tsvField, 2);

            if (count($labelValue) === 2) {
                // "label:value"
                return $labelValue;
            }

            // "label:" (no value)
            return array($tsvField, '');
        }

        throw new \RuntimeException(sprintf('Could not unserialize LTSV field(%s).', $tsvField));
    }

    /**
     * Assert that label is strictly valid.
     *
     * @param string $label
     * @return void
     * @throws \RuntimeException
     */
    protected function assertLabel($label)
    {
        $utf8 = mb_convert_encoding($value, 'UTF-8', 'auto');

        if ($this->options['strict'] && !preg_match_all(static::STRICT_LABEL_PATTERN, $utf8)) {
            $message = sprintf('Could not serialize LTSV label:%s. It contains an illegal character.', $label);

            throw new \RuntimeException($message);
        }
    }

    /**
     * Assert that value is strictly valid.
     *
     * @param string $value
     * @return void
     * @throws \RuntimeException
     */
    protected function assertValue($value)
    {
        $utf8 = mb_convert_encoding($value, 'UTF-8', 'auto');

        if ($this->options['strict'] && !preg_match_all(static::STRICT_VALUE_PATTERN, $utf8)) {
            $message = sprintf('Could not serialize LTSV value:%s. It contains an illegal character.', $value);

            throw new \RuntimeException($message);
        }
    }
}
