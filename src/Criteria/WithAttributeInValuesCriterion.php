<?php

namespace Napp\Core\Dbal\Criteria;

class WithAttributeInValuesCriterion implements CriterionInterface
{
    /**
     * @var string
     */
    protected $attribute;

    /**
     * @var array
     */
    protected $values;

    /**
     * @param string $attribute
     * @param array $values
     */
    public function __construct($attribute, $values)
    {
        $this->attribute = $attribute;
        $this->values = $values;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $query->getQuery()->whereIn($query->getModel()->getTable() . '.' . $this->attribute, $this->values);

        return $query;
    }
}
