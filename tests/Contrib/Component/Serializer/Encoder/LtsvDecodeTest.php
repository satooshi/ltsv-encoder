<?php
namespace Contrib\Component\Serializer\Encoder;

/**
 * Decode LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvDecodeTest extends \PHPUnit_Framework_TestCase
{
    const FORMAT = 'ltsv';

    protected function setUp()
    {
        $this->object = new LtsvDecode();
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

    /**
     * @test
     */
    public function decodeLtsvFields()
    {
        $data = "label1:value1\tlabel2:value2";

        $expected = array(
            'label1' => 'value1',
            'label2' => 'value2',
        );

        $this->assertEquals($expected, $this->object->decode($data, self::FORMAT));
    }

    /**
     * @test
     */
    public function decodeLtsvLabel()
    {
        $data = "label1:";

        $expected = array(
                'label1' => '',
        );

        $this->assertEquals($expected, $this->object->decode($data, self::FORMAT));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfDelimiterNotFound()
    {
        $data = "label1";
        $this->object->decode($data, self::FORMAT);
    }

    /**
     * @test
     */
    public function decodeLtsvValueContainingDelimiter()
    {
        $data = "label1:value1:other";

        $expected = array(
            'label1' => 'value1:other',
        );

        $this->assertEquals($expected, $this->object->decode($data, self::FORMAT));
    }

    // decode() with invalid character

    /**
     * @test
     */
    public function decodeInvalidLabelUnlessStrictMode()
    {
        $data = "あいうえお:value1";

        $expected = array(
            'あいうえお' => 'value1',
        );

        $this->assertEquals($expected, $this->object->decode($data, self::FORMAT));
    }

    /**
     * @test
     */
    public function decodeInvalidValueUnlessStrictMode()
    {
        $data = "label1:あいうえお";

        $expected = array(
            'label1' => 'あいうえお',
        );

        $this->assertEquals($expected, $this->object->decode($data, self::FORMAT));
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfInvalidLabelOnStrictMode()
    {
        $this->object = new LtsvDecode(array('strict' => true));

        $data = "あいうえお:value1";
        $this->object->decode($data, self::FORMAT);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function throwRuntimeExceptionIfInvalidValueOnStrictMode()
    {
        $this->object = new LtsvDecode(array('strict' => true));

        $data = "label:あいうえお";
        $this->object->decode($data, self::FORMAT);
    }

    // supportsDecoding()

    /**
     * @test
     */
    public function supportsLtsvDecoding()
    {
        $this->assertTrue($this->object->supportsDecoding('ltsv'));
    }

    /**
     * @test
     */
    public function shouldNotSupportOtherFormatDecoding()
    {
        $this->assertFalse($this->object->supportsDecoding('json'));
    }
}
