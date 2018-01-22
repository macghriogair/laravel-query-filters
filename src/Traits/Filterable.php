<?php

namespace Macgriog\QueryFilters\Traits;

use Macgriog\QueryFilters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * adapted from
 * https://raw.githubusercontent.com/laracasts/Dedicated-Query-String-Filtering/
 */
trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  Builder      $query
     * @param  QueryFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
