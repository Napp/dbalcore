<?php

namespace Napp\Core\Dbal\Criteria;

class OffsetLimitCriterion implements CriterionInterface
{
    /**
     * @var int
     */
    protected $offset;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @param int $offset
     * @param int $limit
     */
    public function __construct($offset = 0, $limit = 30)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $query->getQuery()->skip($this->offset);
        $query->getQuery()->take($this->limit);

        return $query;
    }
}
