<?php

use Napp\Core\Dbal\Criteria\CriterionInterface;
use Napp\Core\Dbal\Criteria\OrderByCriterion;

class OrderByCriterionTest extends \Codeception\Test\Unit
{
    /**
     * @var OrderByCriterion
     */
    protected $criterion;

    public function _before()
    {
        $this->criterion = new OrderByCriterion('published', 'desc');
    }

    public function test_it_implements_interface()
    {
        $this->assertInstanceOf(CriterionInterface::class, $this->criterion);
    }

    public function test_it_applies_constraints()
    {
        $query = $this->getMockBuilder(\Illuminate\Database\Query\Builder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $query->expects($this->once())
            ->method('orderBy')
            ->willReturn($query);

        $builder = $this->getMockBuilder(\Illuminate\Database\Eloquent\Builder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getQuery'])
            ->getMock();
        $builder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        $this->criterion->apply($builder);
    }
}
