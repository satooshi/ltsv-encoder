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
    public function decode($data, $format, array $context = array())
    {
        if (isset($context['store_context']) && $context['store_context']) {
            if (!isset($this->context)) {
                $this->context = $this->resolveContext($context);
            }

            $context = $this->context;
        } else {
            $context = $this->resolveContext($context);
        }

        $strict  = $context['strict'];
        $line    = $this->convertEncoding($data, $context);
        $items   = array();

        foreach (explode(static::SEPARATOR, $line) as $tsvField) {
            $field = $this->decodeField($tsvField);

            if ($strict) {
                $this->assertLabel($field[0]);
                $this->assertValue($field[1]);
            }

            $items[$field[0]] = $field[1];
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
        if (false === stripos($tsvField, static::DELIMITER)) {
            throw new \RuntimeException(sprintf('Could not unserialize LTSV field(%s).', $tsvField));
        }

        // "label:value"
        // "label:" (no value)
        return explode(static::DELIMITER, $tsvField, 2);
    }
}
