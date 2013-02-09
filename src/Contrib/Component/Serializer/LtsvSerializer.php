<?php
namespace Contrib\Component\Serializer;

use Contrib\Component\Serializer\Encoder\LtsvEncoder;


/**
 * Serialize LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvSerializer
{
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
     * @var LtsvEncoder
     */
    protected $encoder;

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

        $this->encoder = new LtsvEncoder($this->options);
    }

    // API

    /**
     * Serialize data.
     *
     * @param array $data LTSV data.
     * @return string Serialized LTSV data.
     */
    public function serialize($data)
    {
        return $this->encoder->encode($data, LtsvEncoder::FORMAT);
    }

    /**
     * Deserialize LTSV data.
     *
     * @param string $data LTSV data.
     * @return array Deserialized LTSV data.
     */
    public function deserialize($data)
    {
        return $this->encoder->decode($data, LtsvEncoder::FORMAT);
    }
}
