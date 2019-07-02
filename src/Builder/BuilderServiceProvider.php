<?php

namespace Napp\Core\Dbal\Builder;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class BuilderServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        Builder::mixin(new ReplaceIntoBuilder());
        $builder = new InsertOnDuplicateKeyBuilder();
        $builder();
    }
}
