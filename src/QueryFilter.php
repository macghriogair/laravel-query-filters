<?php

namespace Macgriog\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Adapted from https://github.com/laracasts/Dedicated-Query-String-Filtering
 *
 * By convention, every method named PREFIX + <QueryParam> will be applied to
 * Eloquent's Query Builder.
 */
abstract class QueryFilter
{
    const PREFIX = 'filter_';

    /**
    * The request object.
    *
    * @var Request
    */
    protected $request;

    /**
    * The builder instance.
    *
    * @var Builder
    */
    protected $builder;

    /**
     * All the current filters.
     * @var array
     */
    protected $current = [];

    /**
    * Create a new FilterBase instance.
    *
    * @param Request $request
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * Apply the filters to the builder.
    *
    * @param  Builder $builder
    * @return Builder
    */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            $method = camel_case(self::PREFIX . $name);
            if (! method_exists($this, $method)) {
                continue;
            }
            $this->current[$name] = $value;
            if (is_array($value) || strlen($value)) {
                $this->$method($value);
            } else {
                $this->$method();
            }
        }
        return $this->builder;
    }

    /**
    * Get all request filters data.
    *
    * @return array
    */
    public function filters()
    {
        return $this->request->all();
    }

    /**
     * Return all of the current filters as filterProperty => filterValue
     * @return array
     */
    public function current() : array
    {
        return $this->current;
    }
}
