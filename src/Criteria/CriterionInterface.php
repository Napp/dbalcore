<?php

namespace Napp\Core\Dbal\Criteria;

interface CriterionInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query);
}
