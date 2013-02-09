<?php
namespace Contrib\Component\Serializer\Encoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Encode LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvEncoder implements EncoderInterface, DecoderInterface
{
    /**
     * Format name.
     *
     * @var string
     */
    const FORMAT = 'ltsv';

    /**
     * @var LtsvEncode
     */
    protected $encodingImpl;

    /**
     * @var LtsvDecode
     */
    protected $decodingImpl;

    public function __construct($options = null, LtsvEncode $encodingImpl = null, LtsvDecode $decodingImpl = null)
    {
        if ($options === null) {
            $options = array();
        }

        $this->encodingImpl = null === $encodingImpl ? new LtsvEncode($options) : $encodingImpl;
        $this->decodingImpl = null === $decodingImpl ? new LtsvDecode($options) : $decodingImpl;
    }

    // API

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format)
    {
        return $this->encodingImpl->encode($data, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data, $format)
    {
        return $this->decodingImpl->decode($data, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding($format)
    {
        return self::FORMAT === $format;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDecoding($format)
    {
        return self::FORMAT === $format;
    }
}
