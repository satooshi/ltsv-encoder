<?php
namespace Contrib\Component\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Encode LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvEncode extends Ltsv implements EncoderInterface
{
    // API

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format)
    {
        $fields = array();

        foreach ($data as $label => $value) {
            $fields[] = $this->encodeField($label, $value);
        }

        return implode(static::SEPARATOR, $fields);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format)
    {
        return LtsvEncoder::FORMAT === $format;
    }

    // internal method

    /**
     * Serialize LTSV field.
     *
     * @param string $label Label.
     * @param string $value Value.
     * @return string Serialized LTSV field.
     * @throws \RuntimeException
     */
    protected function encodeField($label, $value)
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
}
