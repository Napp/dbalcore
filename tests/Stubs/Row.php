<?php

namespace Napp\Core\Dbal\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    public $guarded = [];

    public $timestamps = false;
}
