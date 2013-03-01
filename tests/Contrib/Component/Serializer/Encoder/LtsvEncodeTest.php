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
    public function encodeLtsvItemOnString()
    {
        $data = array(
            'label1' => 'value1',
        );

        $expected = "label1:value1";
        $actual = $this->object->encode($data, self::FORMAT, array('strict' => true));

        $this->assertEquals($expected, $actual);
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
    public function encodeSerializableObjectValue()
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
        $data = array(
            'あいうえお' => 'value1',
        );

        $this->object->encode($data, self::FORMAT, array('strict' => true));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfInvalidValueOnStrictMode()
    {
        $data = array(
            'label1' => 'あいうえお',
        );

        $this->object->encode($data, self::FORMAT, array('strict' => true));
    }

    // store_context

    /**
     * @test
     */
    public function encodeInvalidLtsvFieldWithStoredContext()
    {
        $data = array(
            'label1' => 'あいうえお',
        );
        $expected = "label1:あいうえお";

        $actual = $this->object->encode($data, self::FORMAT, array('strict' => false, 'store_context' => true));
        $this->assertEquals($expected, $actual);

        $actual = $this->object->encode($data, self::FORMAT, array('strict' => true, 'store_context' => true));
        $this->assertEquals($expected, $actual);

        return $this->object;
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @depends encodeInvalidLtsvFieldWithStoredContext
     */
    public function throwRuntimeExceptionOnEncodeInvalidLtsvFieldWithoutStoredContext($object)
    {
        $data = array(
            'label1' => 'あいうえお',
        );

        $object->encode($data, self::FORMAT, array('strict' => true));
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @depends encodeInvalidLtsvFieldWithStoredContext
     */
    public function throwRuntimeExceptionOnEncodeInvalidLtsvFieldWithStoredContextFalse($object)
    {
        $data = array(
            'label1' => 'あいうえお',
        );

        $object->encode($data, self::FORMAT, array('strict' => true, 'store_context' => false));
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
