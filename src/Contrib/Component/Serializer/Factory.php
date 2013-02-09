<?php
namespace Contrib\Component\Serializer;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Contrib\Component\Serializer\Encoder\LtsvEncoder;

/**
 * Serializer factory.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class Factory
{
    /**
     * Create LTSV serializer.
     *
     * @param array $options LtsvEncoder options.
     * @return \Symfony\Component\Serializer\Serializer
     */
    public static function createSerializer($options = array())
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder(), new LtsvEncoder($options));
        $normalizers = array(new GetSetMethodNormalizer());

        return new Serializer($normalizers, $encoders);
    }
}
