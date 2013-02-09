<?php
namespace Contrib\Component\Serializer;

/**
 * Serialize LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvSerializerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->object = new LtsvSerializer();
    }

    // serialize()

    /**
     * @test
     */
    public function serializeLtsvField()
    {
        $expected = "label1:value1";

        $data = array(
            'label1' => 'value1',
        );

        $this->assertEquals($expected, $this->object->serialize($data));
    }

    /**
     * @test
     */
    public function deserializeLtsvField()
    {
        $data = "label1:value1";

        $expected = array(
            'label1' => 'value1',
        );

        $this->assertEquals($expected, $this->object->deserialize($data));
    }
}
