<?php

namespace App\Http\Filters;

/**
 * Class UserFilter
 * @package App\Http\Filters
 */
class UserFilter extends QueryFilter
{
    /**
     * @param $name
     */
    public function name($name)
    {
        $this->builder->where('name', 'LIKE', "%{$name}%");;
    }

    /**
     * @param $lastName
     */
    public function lastName($lastName)
    {
        $this->builder->where('last_name', 'LIKE', "%{$lastName}%");;
    }

    /**
     * @param $email
     */
    public function email($email)
    {
        $this->builder->where('email', 'LIKE', "%{$email}%");;
    }

    /**
     * @param $search
     */
    public function search($search)
    {
        $this->builder->orWhere('name', 'LIKE', "%{$search}%");
        $this->builder->orWhere('last_name', 'LIKE', "%{$search}%");
        $this->builder->orWhere('email', $search);
    }
}
