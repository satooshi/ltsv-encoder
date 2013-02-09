<?php
namespace Contrib\Component\Serializer\Encoder;

/**
 * Encode LTSV data.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class LtsvEncoderTest extends \PHPUnit_Framework_TestCase
{
    const FORMAT = 'ltsv';

    protected function setUp()
    {
        //$encoder = new LtsvEncode();
        //$decoder = new LtsvDecode();

        $this->object = new LtsvEncoder();
    }

    // encode test

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

    // decode test

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
