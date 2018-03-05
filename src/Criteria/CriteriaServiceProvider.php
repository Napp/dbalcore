<?php

namespace Napp\Core\Dbal\Criteria;

use Illuminate\Support\ServiceProvider;

class CriteriaServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(CriteriaCollectionInterface::class, CriteriaCollection::class);
    }
}
