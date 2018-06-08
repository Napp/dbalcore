<?php

namespace Napp\Core\Dbal\Tests\Unit;

use Napp\Core\Dbal\Criteria\CriterionInterface;
use Napp\Core\Dbal\Criteria\GroupByCriterion;
use Napp\Core\Dbal\Tests\TestCase;

class GroupByCriterionTest extends TestCase
{
    protected $criterion;

    public function test_it_implements_interface()
    {
        $this->assertInstanceOf(CriterionInterface::class, new GroupByCriterion('published', 'id'   ));
    }

    public function test_it_applies_constraints_using_strings()
    {
        $query = $this->getMockBuilder(\Illuminate\Database\Query\Builder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $query->expects($this->once())
            ->method('groupBy')
            ->with(['published', 'id'])
            ->willReturn($query);

        $builder = $this->getMockBuilder(\Illuminate\Database\Eloquent\Builder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getQuery'])
            ->getMock();
        $builder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        (new GroupByCriterion('published', 'id'))->apply($builder);
    }

    public function test_it_applies_constraints_using_an_array()
    {
        $query = $this->getMockBuilder(\Illuminate\Database\Query\Builder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $query->expects($this->once())
            ->method('groupBy')
            ->with(['testing', 'test'])
            ->willReturn($query);

        $builder = $this->getMockBuilder(\Illuminate\Database\Eloquent\Builder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getQuery'])
            ->getMock();
        $builder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        (new GroupByCriterion(['testing', 'test']))->apply($builder);
    }
}
