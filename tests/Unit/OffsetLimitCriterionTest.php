<?php

namespace Napp\Core\Dbal\Tests\Unit;

use Napp\Core\Dbal\Criteria\CriterionInterface;
use Napp\Core\Dbal\Criteria\OffsetLimitCriterion;
use Napp\Core\Dbal\Tests\TestCase;

class OffsetLimitCriterionTest extends TestCase
{
    /**
     * @var OffsetLimitCriterion
     */
    protected $criterion;

    public function setUp(): void
    {
        parent::setUp();

        $this->criterion = new OffsetLimitCriterion(0, 30);
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
            ->method('skip')
            ->with(0)
            ->willReturn($query);
        $query->expects($this->once())
            ->method('take')
            ->with(30)
            ->willReturn($query);

        $builder = $this->getMockBuilder(\Illuminate\Database\Eloquent\Builder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getQuery'])
            ->getMock();
        $builder->expects($this->exactly(2))
            ->method('getQuery')
            ->willReturn($query);

        $this->criterion->apply($builder);
    }
}
