<?php

namespace Napp\Core\Dbal\Criteria;

class SelectCriterion implements CriterionInterface
{
    /**
     * @var array
     */
    protected $columns;

    /**
     * @param array $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $query->getQuery()->select($this->columns);

        return $query;
    }
}
