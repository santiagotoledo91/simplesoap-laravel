<?php
/**
 * Created by PhpStorm.
 * User: santiagotoledobrokoli
 * Date: 20/09/17
 * Time: 13:09
 */

namespace Santiagotoledo91\SimpleSOAP\Facades;

use Illuminate\Support\Facades\Facade;

class SimpleSOAP extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'simplesoap';
    }
}