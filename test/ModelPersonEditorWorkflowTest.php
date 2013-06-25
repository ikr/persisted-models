<?php

namespace Magomogo\Persisted;

use Magomogo\Persisted\Container\ContainerInterface;
use Magomogo\Persisted\Container\Db;
use Magomogo\Persisted\Container\Memory;
use Test\DbFixture;
use Test\ObjectMother;
use Test\Person;

class ModelEditorWorkflowTest extends \PHPUnit_Framework_TestCase
{
    private $fixture;

    private $propertiesId;

    protected function setUp()
    {
        $this->fixture = new DbFixture();
        $this->fixture->install();

        $this->propertiesId = ObjectMother\Person::maxim()->putIn($this->dbContainer());
    }

    public function testCanBeEditWithSomeEditor()
    {
        $model = Person\Model::load($this->dbContainer(), $this->propertiesId);
        $editor = new PersonEditor($model);

        $editor->updateProperties(array(
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'John.Doe@example.com',
            ));
        $editor->saveTo($this->dbContainer());

        $this->assertEquals(
            'Mr. John Doe',
            Person\Model::load($this->dbContainer(), $this->propertiesId)->politeTitle()
        );

    }

//----------------------------------------------------------------------------------------------------------------------

    private function dbContainer()
    {
        return new Db($this->fixture->db, 'Test\\');
    }
}


//======================================================================================================================

class PersonEditor extends Memory
{
    private $idInMemory;

    /**
     * @param Person\Model $person
     */
    public function __construct($person)
    {
        $this->idInMemory = $person->putIn($this);
    }

    public function updateProperties($map)
    {
        $properties = $this->storage['Test\\Person\\Properties'][$this->idInMemory];
        foreach ($map as $name => $value) {
            $properties->$name = $value;
        }
    }

    /**
     * @param ContainerInterface $container
     */
    public function saveTo($container)
    {
        Person\Model::load($this, $this->idInMemory)->putIn($container);
    }
}