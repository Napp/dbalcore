<?php

namespace Napp\Core\Dbal\Criteria;

class CriteriaCollection implements CriteriaCollectionInterface
{
    /**
     * @var CriterionInterface[]
     */
    protected $criteria;

    /**
     * @param CriterionInterface $criterion
     *
     * @return $this
     */
    public function add(CriterionInterface $criterion)
    {
        $this->criteria[] = $criterion;

        return $this;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->criteria = [];

        return $this;
    }

    /**
     * @return CriterionInterface[]
     */
    public function getAll()
    {
        return $this->criteria;
    }
}
