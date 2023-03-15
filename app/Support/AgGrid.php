<?php

namespace App\Support;

class AgGrid
{
    public const W_SMALL = [ 'minWidth' => 120 ];
    public const W_MEDIUM  = [ 'minWidth' => 150 ];
    public const W_WIDE = [ 'minWidth' => 250 ];
    public const W_ULTRAWIDE = [ 'minWidth' => 400 ];

    public static function column($field, $header = null, $defaults = [])
    {
        return array_merge(
            [
                'headerName' => $header ?? ucwords(str_replace('_', ' ', $field)),
                'field' => $field,
                'sortable' => true,
                'filter' => true,
                'suppressMenu' => true
            ],
            $defaults
        );
    }

    public static function hidden($field)
    {
        return static::column($field, '', [ 'hide' => true ]);
    }

    /**
     * Without filter and sort
     */
    public static function fixed($field, $header = null, $default = [])
    {
        return static::column($field, $header, array_merge([
            'filter' => false,
            'sortable' => false ], $default));
    }

    public static function cellRenderer($field)
    {
        return static::column($field);
    }

    public static function fixedWidth($field, $header = null, $width = 170)
    {
        return static::column($field, $header, [
            'width' => $width,
            'suppressSizeToFit' => true
        ]);
    }

    public static function withMinWidth($field, $header = null, $minWidth = 100)
    {
        return static::column($field, $header, [
            'minWidth' => $minWidth,
            'suppressSizeToFit' => true,
            'filter' => false
        ]);
    }

    public static function money($field, $header, $minWidth = 160)
    {
        return static::column($field, $header, [
            'minWidth' => $minWidth,
            'suppressSizeToFit' => true ,
            'suppressMenu' => true,
            'cellClass' => '--x-money-cell'
        ]);
    }
}
