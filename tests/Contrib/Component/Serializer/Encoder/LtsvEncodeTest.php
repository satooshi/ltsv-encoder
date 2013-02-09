<?php
namespace Contrib\Component\Serializer\Encoder;

/**
 * Encode LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvEncodeTest extends \PHPUnit_Framework_TestCase
{
    const FORMAT = 'ltsv';

    protected function setUp()
    {
        $this->object = new LtsvEncode();
    }

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

    /**
     * @test
     */
    public function encodeLtsvItems()
    {
        $data = array(
            'label1' => 'value1',
            'label2' => 'value2',
        );

        $expected = "label1:value1\tlabel2:value2";

        $this->assertEquals($expected, $this->object->encode($data, self::FORMAT));
    }

    /**
     * @test
     */
    public function encodeNullValue()
    {
        $data = array(
            'label1' => null,
        );

        $expected = "label1:";

        $this->assertEquals($expected, $this->object->encode($data, self::FORMAT));
    }

    /**
     * @test
     */
    public function encodeSerializableValue()
    {
        $data = array(
            'label1' => new SerializableObject,
        );

        $expected = "label1:value1";

        $this->assertEquals($expected, $this->object->encode($data, self::FORMAT));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfNonserializableValue()
    {
        $data = array(
            'label1' => new \stdClass(),
        );

        $this->object->encode($data, self::FORMAT);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfArrayValue()
    {
        $data = array(
            'label1' => array(),
        );

        $this->object->encode($data, self::FORMAT);
    }

    /**
     * @test
     */
    public function supportLtsvEncoding()
    {
        $this->assertTrue($this->object->supportsEncoding('ltsv'));
    }

    /**
     * @test
     */
    public function shouldNotSupportOtherFormatEncoding()
    {
        $this->assertFalse($this->object->supportsEncoding('json'));
    }
}

class SerializableObject
{
    public function __toString()
    {
        return 'value1';
    }
}
