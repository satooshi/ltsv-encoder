<?php
namespace Contrib\Component\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface;

/**
 * Decode LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvDecode extends Ltsv implements DecoderInterface
{
    // API

    /**
     * {@inheritdoc}
     */
    public function decode($data, $format)
    {
        $line      = $this->convertEncoding($data);
        $tsvFields = explode(static::SEPARATOR, trim($line));
        $items     = array();

        foreach ($tsvFields as $tsvField) {
            list($label, $value) = $this->decodeField($tsvField);

            $this->assertLabel($label);
            $this->assertValue($value);

            $items[$label] = $value;
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDecoding($format)
    {
        return LtsvEncoder::FORMAT === $format;
    }

    // internal method

    /**
     * Decode LTSV field.
     *
     * @param string $tsvField LTSV field.
     * @return array Decoded LTSV item.
     * @throws \RuntimeException Throw on parse error.
     */
    protected function decodeField($tsvField)
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
}
