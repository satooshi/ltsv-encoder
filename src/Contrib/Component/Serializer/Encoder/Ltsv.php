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
    const STRICT_VALUE_PATTERN = '/^[\x01-\x08\x0B\x0C\x0E-\xFF]+$/u';

    /**
     * Serializer context options.
     *
     * @var array
     */
    protected $context;

    // internal method

    /**
     * Merge the default options of the Ltsv Encode/Decode with the passed context.
     *
     * @param array $context
     * @return array
     */
    protected function resolveContext(array $context)
    {
        return array_merge(
            array(
                'to_encoding'   => 'UTF-8',
                'from_encoding' => 'auto',
                'strict'        => false,
                'store_context' => false,
            ),
            $context
        );
    }

    /**
     * Convert encoding.
     *
     * @param string $str     Converting string.
     * @param array  $context Serializer context options.
     * @return string Converted string.
     */
    protected function convertEncoding($str, array $context)
    {
        return mb_convert_encoding($str, $context['to_encoding'], $context['from_encoding']);
    }

    /**
     * Assert that label is strictly valid.
     *
     * @param string $label
     * @return void
     * @throws \RuntimeException
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function assertLabel($label)
    {
        $utf8 = mb_convert_encoding($label, 'UTF-8', 'auto');

        if (!preg_match_all(static::STRICT_LABEL_PATTERN, $utf8, $matches)) {
            $message = sprintf('Could not serialize LTSV label = %s. It contains an illegal character.', $label);

            throw new \RuntimeException($message);
        }
    }

    /**
     * Assert that value is strictly valid.
     *
     * @param string $value
     * @return void
     * @throws \RuntimeException
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function assertValue($value)
    {
        $utf8 = mb_convert_encoding($value, 'UTF-8', 'auto');

        if (!preg_match_all(static::STRICT_VALUE_PATTERN, $utf8, $matches)) {
            $message = sprintf('Could not serialize LTSV value = %s. It contains an illegal character.', $value);

            throw new \RuntimeException($message);
        }
    }
}
