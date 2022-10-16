<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class QueryFilter
{
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
     * Define these attributes to sort by the respective field name in db
     * Keys represent url fields and values represents db fields
     *
     * @array $attributes
     */
    protected $attributes = [];

    /**
     * Create a new QueryFilters instance.
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
            if (!method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
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
     * Sort the collection by the sort field
     * Examples: sort= name,-status || sort=-name || sort=status
     *
     * @param string $value
     */
    protected function sort(string $value)
    {
        collect(explode(',', $value))->mapWithKeys(function (string $field) {
            switch (substr($field, 0, 1)) {
                case '-':
                    return [substr($field, 1) => 'desc'];
                case ' ':
                    return [substr($field, 1) => 'asc'];
                default:
                    return [$field => 'asc'];
            }
        })->each(function (string $order, string $field) {
            $sort_field = Arr::get($this->attributes, $field);
            if ($sort_field) {
                $this->builder->orderBy($sort_field, $order);
            }
        });
    }
}
