<?php
namespace Contrib\Component\Serializer;

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

class SerializableEntity
{
    protected $id;
    protected $name;

    public function __construct($data = array())
    {
        if (is_array($data)) {
            foreach ($data as $property => $value) {
                if (property_exists($this, $property)) {
                    $this->$property = $value;
                }
            }
        }
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}
