<?php

namespace Napp\Core\Dbal\Criteria;

class OrderByCriterion implements CriterionInterface
{
    /**
     * @var string
     */
    protected $column;

    /**
     * @var string
     */
    protected $direction;

    /**
     * @param string $column
     * @param string $direction
     */
    public function __construct($column, $direction = 'desc')
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $query->getQuery()->orderBy($this->column, $this->direction);

        return $query;
    }
}
