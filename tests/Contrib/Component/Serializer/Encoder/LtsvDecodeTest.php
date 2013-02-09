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
    public function supportsLtsvDecoding()
    {
        $this->assertTrue($this->object->supportsDecoding('ltsv'));
    }

    /**
     * @test
     */
    public function shouldNotSupportOtherFormat()
    {
        $this->assertFalse($this->object->supportsDecoding('json'));
    }
}
