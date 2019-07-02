<?php

namespace Napp\Core\Dbal\Criteria;

class WithAttributeValueAndOperatorCriterion implements CriterionInterface
{
    /**
     * @var string
     */
    protected $attribute;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @param string $attribute
     * @param string $value
     * @param string $operator
     */
    public function __construct($attribute, $value, $operator = '=')
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->operator = $operator;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query)
    {
        $query->getQuery()->where($query->getModel()->getTable().'.'.$this->attribute, $this->operator, $this->value);

        return $query;
    }
}
