<?php 

namespace Mbarwick83\Instagram\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mbarwick83\Instagram\Instagram
 */
class Instagram extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Mbarwick83\Instagram\Instagram';
    }
}