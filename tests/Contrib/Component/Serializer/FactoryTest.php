<?php
namespace Contrib\Component\Serializer;

require_once 'SerializableEntity.php';

/**
 * Serializer factory.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    const FORMAT = 'ltsv';

    protected function setUp()
    {
        $this->object = Factory::createSerializer();
    }

    // encode()

    /**
     * @test
     */
    public function encodeLtsvItem()
    {
        $data = array(
            'label1' => 'value1',
        );

        $expected = "label1:value1";

        $this->assertEquals($expected, $this->object->encode($data, self::FORMAT));
    }

    // decode()

    /**
     * @test
     */
    public function decodeLtsvField()
    {
        $data = "label1:value1";

        $expected = array(
            'label1' => 'value1',
        );

        $this->assertEquals($expected, $this->object->decode($data, self::FORMAT));
    }

    // serialize()

    /**
     * @test
     */
    public function serialize()
    {
        $data = new SerializableEntity(array('id' => 1, 'name' => 'hoge'));
        $expected = "id:1\tname:hoge";

        $this->assertEquals($expected, $this->object->serialize($data, self::FORMAT));
    }

    // deserialize()

    /**
     * @test
     */
    public function deserialize()
    {
        $data = "id:1\tname:hoge";
        $expected = new SerializableEntity(array('id' => 1, 'name' => 'hoge'));
        $actual = $this->object->deserialize($data, 'Contrib\Component\Serializer\SerializableEntity', self::FORMAT);

        $this->assertEquals($expected, $actual);
    }
}
