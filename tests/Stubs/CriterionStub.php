<?php

namespace Napp\Core\Dbal\Tests\Stubs;

use Napp\Core\Dbal\Criteria\CriterionInterface;

class CriterionStub implements CriterionInterface
{
    public function apply($query)
    {
        // Do some magic.
    }
}