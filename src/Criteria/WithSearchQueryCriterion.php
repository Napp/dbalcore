<?php

namespace Napp\Core\Dbal\Criteria;

class WithSearchQueryCriterion implements CriterionInterface
{
    /** @var string */
    protected $searchQuery;

    /** @var array */
    protected $field;

    /**
     * WithSearchQueryCriterion constructor.
     * @param string $searchQuery
     * @param string|null $field
     */
    public function __construct(string $searchQuery, string $field = null)
    {
        $this->searchQuery = $searchQuery;
        $this->field = $field;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        if (null === $this->field) {
            return $query;
        }

        $query->getQuery()->where($this->field, 'LIKE', '%' . $this->searchQuery . '%');

        return $query;
    }
}
