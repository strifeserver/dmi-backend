<?php

namespace App;

class AgGrid
{
    /**
     * Translate and apply aggrid filter to query object
     *
     * https://www.ag-grid.com/javascript-grid-filter-api/
     */
    public static function applyFilter($query, $filters)
    {
        if(!$filters) return $query;

        // TODO: support for non string types, other operators
        foreach($filters as $column => $state) {
            if($state->type == 'contains') {
                // add like
                $query->where($column, 'like', "%{$state->filter}%");
            }
        }

        return $query;
    }

    /**
     * Apply sort on query based on aggrid model
     *
     * https://www.ag-grid.com/javascript-grid-server-side-model-sorting/
     */
    public static function applySort($query, $sortEnum)
    {
        if(!$sortEnum) return $query;

        foreach($sortEnum as $state) {
            $order = strtolower($state->sort);

            if(! ($order == 'asc' || $order == 'desc')) continue;

            $query->orderBy($state->colId, $order);
        }
        return $query;
    }

    public static function makeColumn($field, $header = null, $extra = [])
    {
        return array_merge(
            [
                'headerName' => $header ?? strtoupper($field),
                'field' => $field,
                'sortable' => true,
                'filter' => true
            ],
            $extra
        );
    }
}
