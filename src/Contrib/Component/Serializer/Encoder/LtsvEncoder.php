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

    /**
     * Constructor.
     *
     * @param string $options
     * @param LtsvEncode $encodingImpl
     * @param LtsvDecode $decodingImpl
     */
    public function __construct(LtsvEncode $encodingImpl = null, LtsvDecode $decodingImpl = null)
    {
        $this->encodingImpl = null === $encodingImpl ? new LtsvEncode() : $encodingImpl;
        $this->decodingImpl = null === $decodingImpl ? new LtsvDecode() : $decodingImpl;
    }

    // API

    /**
     * {@inheritdoc}
     */
    public function encode($data, $format, array $context = array())
    {
        return $this->encodingImpl->encode($data, self::FORMAT, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data, $format, array $context = array())
    {
        return $this->decodingImpl->decode($data, self::FORMAT, $context);
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
