<?php

namespace Napp\Core\Dbal\Criteria;

use Illuminate\Support\Arr;

class GroupByCriterion implements CriterionInterface
{
    private $groups;

    public function __construct(...$groups)
    {
        foreach ($groups as $group) {
            $this->groups = array_merge(
                (array) $this->groups,
                Arr::wrap($group)
            );
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|void
     */
    public function apply($query)
    {
        $query->getQuery()->groupBy($this->groups);
    }
}
