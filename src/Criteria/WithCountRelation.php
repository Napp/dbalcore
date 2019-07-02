<?php

namespace Napp\Core\Dbal\Criteria;

class WithCountRelation implements CriterionInterface
{
    protected $relations = [];

    public function __construct($relations = [])
    {
        $this->relations = $relations;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|void
     */
    public function apply($query)
    {
        $query->withCount($this->relations);
    }
}
