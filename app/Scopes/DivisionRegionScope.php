<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DivisionRegionScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->user()->organization_id == config('app.organization_id_dae')) {
            $builder->leftJoin('regions AS div', $model->getTable().'.division_id', '=', 'div.id');
        } else {
            $builder->leftJoin('divisions AS div', $model->getTable().'.division_id', '=', 'div.id');
        }
    }
}