<?php

/**
 * Contracts for classes that accepts pagination of table data
 * @author CORE
 *
 * TODO: implement classes for sortmodel, filtermodel
 */

namespace App\Http\Controllers\Pagination;

use Illuminate\Http\Request;
use JsonSerializable;

/**
 * Represents an aggrid expected xhr response model
 * @see https://www.ag-grid.com/javascript-data-grid/infinite-scrolling/#datasource-interface
 */
class PageData implements JsonSerializable
{
    public int $max;
    public array $result;
    public array $meta;

    public function __construct(int $max, array $result, array $meta = [])
    {
        $this->max = $max;
        $this->result = $result;
        $this->meta = $meta;
    }

    public function jsonSerialize()
    {
        return [ 'max' => $this->max, 'result' => $this->result, 'meta' => $this->meta ];
    }
}

interface Paginatable
{
    /**
     * Return array of column definitions
     * headerName
     * field
     * sortable
     * filter
     *
     * @see https://www.ag-grid.com/javascript-data-grid/column-definitions/
     */
    public function getColumns(): array;

    /**
     * Start and end refers to the actual row number, not offset/limit
     * Note that: `limit = end - start ; offset = start`
     *
     * @see https://www.ag-grid.com/javascript-data-grid/server-side-model-sorting/
     * @see https://www.ag-grid.com/javascript-data-grid/filter-api/
     */
    public function getPage(int $start, int $end, ?array $sortModel, ?object $filterModel)
        : PageData;

    /**
     * Must call and return getPage()
     */
    public function acceptPagination(Request $request);
}
