<?php

namespace App\GraphQL\Builder;
use Exception;

// use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;

class Search {

    protected $builder;
    
    protected $aliases = [
        'equal' => 'eq',
        'greaterThan' => 'gt',
        'greaterOrEqualThan' => 'get',
        'lessThan' => 'lt',
        'lessOrEqualThan' => 'let',
    ];

    /* Fazer pesquisas.
    *
    * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
    * @param  mixed  $value
    * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
    */
    
    public function __invoke(Builder $builder, array $searchFields = []) 
    {
        $this->builder = $builder;

        foreach($searchFields as $field => $methods)
            foreach($methods as $method => $value)
                $this->callMethod($method, $builder, $field, $value);

        return $this->builder;
    }

    public function callMethod($method, Builder $builder, string $field, $value) 
    {
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $builder, $field, $value);
        } else if ($aliasMethod = $this->getMethodAlias($method)) {
            $this->callMethod($aliasMethod, $builder, $field, $value);
        } else {
            throw new Exception("Method [$method] not exists to builder", 400);
        }
    }

    public function getMethodAlias(string $method)
    {
        $classMethods = array_keys($this->aliases);
        foreach($classMethods as $classMethod) {
            $aliases = $this->aliases[$classMethod];

            if(! is_array($aliases)) $aliases = [$aliases];

            if(in_array($method, $aliases)) {
                return $classMethod;
                break;
            }
        }
        return false;
    }

    public function contains(Builder $builder, string $field, ?string $value)
    {
        $this->builder = $builder->where($field, 'like', "%$value%");
    }

    public function equal(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->where($field, $value);
    }

    public function notContains(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->where($field, 'not like', "%$value%");
    }

    public function notEqual(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->where($field, '<>', $value);
    }

    public function in(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->whereIn($field, $value);
    }

    public function notIn(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->whereNotIn($field, $value);
    }

    public function greaterThan(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->where($field, '>', $value);
    }

    public function greaterOrEqualThan(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->where($field, '>=', $value);
    }

    public function lessThan(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->where($field, '<', $value);
    }

    public function lessOrEqualThan(Builder $builder, string $field, $value)
    {
        $this->builder = $builder->where($field, '<=', $value);
    }
}