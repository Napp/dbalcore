<?php

namespace Napp\Core\Dbal\Tests\Unit;

use Napp\Core\Dbal\Criteria\CriteriaCollection;
use Napp\Core\Dbal\Criteria\CriteriaCollectionInterface;
use Napp\Core\Dbal\Tests\Stubs\CriterionStub;
use Napp\Core\Dbal\Tests\TestCase;

class CriteriaCollectionTest extends TestCase
{
    /**
     * @var CriteriaCollectionInterface
     */
    protected $criteriaCollection;

    public function setUp()
    {
        parent::setUp();

        $this->criteriaCollection = new CriteriaCollection();
    }

    public function test_it_implements_interface()
    {
        $this->assertInstanceOf(CriteriaCollectionInterface::class, $this->criteriaCollection);
    }
    
    public function test_it_can_be_retrieved_from_the_container()
    {
        $instance = $this->app->make(CriteriaCollectionInterface::class);
        
        $this->assertInstanceOf(CriteriaCollection::class, $instance);
    }

    public function test_it_adds_criterion()
    {
        $this->criteriaCollection
            ->add(new CriterionStub())
            ->add(new CriterionStub())
            ->add(new CriterionStub());

        $this->assertCount(3, $this->criteriaCollection->getAll());
    }

    public function test_it_resets_collection()
    {
        $this->criteriaCollection
            ->add(new CriterionStub())
            ->add(new CriterionStub())
            ->add(new CriterionStub())
            ->reset();

        $this->assertCount(0, $this->criteriaCollection->getAll());
    }
}