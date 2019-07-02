<?php

namespace Napp\Core\Dbal\Tests\Unit;

use Napp\Core\Dbal\Criteria\CriterionInterface;
use Napp\Core\Dbal\Criteria\SelectCriterion;
use Napp\Core\Dbal\Tests\TestCase;

class SelectCriterionTest extends TestCase
{
    /**
     * @var SelectCriterion
     */
    protected $criterion;

    public function setUp(): void
    {
        parent::setUp();

        $this->criterion = new SelectCriterion(['id', 'file']);
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
            ->method('select')
            ->with(['id', 'file'])
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
