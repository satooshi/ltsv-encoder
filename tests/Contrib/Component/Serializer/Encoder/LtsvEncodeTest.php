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

    // encode() with invalid character

    /**
     * @test
     */
    public function encodeInvalidLabelUnlessStrictMode()
    {
        $data = array(
            'あいうえお' => 'value1',
        );

        $expected = "あいうえお:value1";

        $this->assertEquals($expected, $this->object->encode($data, self::FORMAT));
    }

    /**
     * @test
     */
    public function encodeInvalidValueUnlessStrictMode()
    {
        $data = array(
            'label1' => 'あいうえお',
        );

        $expected = "label1:あいうえお";

        $this->assertEquals($expected, $this->object->encode($data, self::FORMAT));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfInvalidLabelOnStrictMode()
    {
        $this->object = new LtsvEncode(array('strict' => true));

        $data = array(
            'あいうえお' => 'value1',
        );

        $this->object->encode($data, self::FORMAT);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfInvalidValueOnStrictMode()
    {
        $this->object = new LtsvEncode(array('strict' => true));

        $data = array(
            'label1' => 'あいうえお',
        );

        $this->object->encode($data, self::FORMAT);
    }

    // supportsEncoding()

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
