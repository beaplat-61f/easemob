<?php
namespace Beaplat\Easemob\Facades;

use Illuminate\Support\Facades\Facade;

class Easemob extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'easemob';
    }
}
