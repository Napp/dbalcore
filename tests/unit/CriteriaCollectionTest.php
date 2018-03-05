<?php

use Napp\Core\Dbal\Criteria\CriteriaCollection;
use Napp\Core\Dbal\Criteria\CriteriaCollectionInterface;
use \Stubs\CriterionStub;

class CriteriaCollectionTest extends \Codeception\Test\Unit
{
    /**
     * @var CriteriaCollectionInterface
     */
    protected $criteriaCollection;

    public function _before()
    {
        $this->criteriaCollection = new CriteriaCollection();
    }

    public function test_it_implements_interface()
    {
        $this->assertInstanceOf(CriteriaCollectionInterface::class, $this->criteriaCollection);
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
