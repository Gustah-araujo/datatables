<?php

namespace GustahAraujo\Datatables;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GustahAraujo\Datatables\Skeleton\SkeletonClass
 */
class DatatablesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'datatables';
    }
}
