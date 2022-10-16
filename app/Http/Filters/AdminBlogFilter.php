<?php

namespace App\Http\Filters;

use App\Http\Requests\Admin\BlogIndexRequest;
use App\Models\User;

class AdminBlogFilter extends QueryFilter
{
    /**
     * Attributes to sort by the respective field name in query
     *
     * @array $attributes
     */
    protected $attributes = [
        'title' => 'title',
        'created_at' => 'created_at',
    ];

    /**
     * Override QueryFilter constructor to use custom request.
     *
     * @param Request $request
     */
    public function __construct(BlogIndexRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $key
     */
    public function search(string $key)
    {
        $this->builder->where(function ($query) use ($key) {
            $query->where('title', 'like', '%' . $key . '%')
                ->orWhere('providers.unique_id', 'like', '%' . $key . '%');
        });
    }

    /**
     * @param string $slug
     */
    public function slug(string $slug)
    {
        $this->builder->where('slug', 'like', '%' . $slug . '%');
    }

    /**
     * @param string $status
     */
    public function status(string $status)
    {
        $this->builder->where('status', $status);
    }

    /**
     * @param string $email
     */
    public function author(string $key)
    {
        $this->builder->whereRelation('users', 'email', 'like', '%' . $key . '%')->get();
    }
}
