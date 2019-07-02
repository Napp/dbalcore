<?php

namespace Napp\Core\Dbal\Criteria;

interface CriteriaCollectionInterface
{
    /**
     * @param CriterionInterface $criterion
     *
     * @return $this
     */
    public function add(CriterionInterface $criterion);

    /**
     * @return $this
     */
    public function reset();

    /**
     * @return CriterionInterface[]
     */
    public function getAll();
}
