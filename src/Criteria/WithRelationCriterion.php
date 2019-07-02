<?php

namespace Napp\Core\Dbal\Criteria;

class WithRelationCriterion implements CriterionInterface
{
    /**
     * @var array|string
     */
    protected $relation;

    /**
     * @param array|string $relation
     */
    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $query->with($this->relation);

        return $query;
    }
}
