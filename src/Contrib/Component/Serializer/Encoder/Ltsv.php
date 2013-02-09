<?php
namespace Contrib\Component\Serializer\Encoder;

/**
 * LTSV definition.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
abstract class Ltsv
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
    const STRICT_LABEL_PATTERN = '/^[0-9A-Za-z_\.\-]+$/';

    /**
     * Strict value pattern.
     *
     * @var string
     */
    const STRICT_VALUE_PATTERN = '/^[\\\x01-\\\x08\\\x0B\\\x0C\\\x0E-\\\xFF]+$/';

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
     * Assert that label is strictly valid.
     *
     * @param string $label
     * @return void
     * @throws \RuntimeException
     */
    protected function assertLabel($label)
    {
        $utf8 = mb_convert_encoding($label, 'UTF-8', 'auto');

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
