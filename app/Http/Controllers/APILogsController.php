<?php

namespace App\Http\Controllers;

use App\AgGrid;
use App\APILogs;
use Illuminate\Http\Request;

class APILogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $args = [
            'title' => 'API Logs'
        ];

        return view('pages.api_logs.index')
            ->with($args);
    }

    // +-------------------
    // | TODO: CHECK AUTHORIZE ACCESS
    //
    // paginate via index: offset, end-start (zero based)
    public function paginate(Request $request)
    {
        // return GridService::paginate($request, 'core_api_logs', ['columns']);

        //
        // FIXME: SANITIZE!
        //
        $offset = intval($request->input('start', 0));
        $limit = intval($request->input('end', null)) - $offset; //! Mysql wont allow offset without limit
        $filter = json_decode($request->input('filter')) ?? [];
        $sort = json_decode($request->input('sort')) ?? [];

        $query = \DB::table('core_api_logs')
            ->select(['id', 'remarks', 'data', 'created_at']);

        if($limit) {
            $query->limit($limit);
            $query->offset($offset);

            AgGrid::applyFilter($query, $filter);
            AgGrid::applySort($query, $sort);

            $result = [
                'max' => self::rowCount('core_api_logs', $filter)->count, // FIXME
                'result' => $query->get(),
                'extra' => [
                    'filter' => $filter,
                    'sort' => json_decode($request->input('sort'), true)
                ]
            ];
        } else {
            $result = [ 'stat' => 0, 'msg' => 'INCORRECT_PARAM' ];
        }

        return response()->json($result);
    }


    public function tableInfo(Request $request)
    {
        // return column info with first page
        $columns = [
            self::makeColumn('id', null, [
                // 'suppressSizeToFit' => true,
                'width' => 150,
                'hide' => true
            ]),
            self::makeColumn('remarks', 'Remarks', ['sortable' => false, 'width' => 40 ]),
            self::makeColumn('data', 'Data', [ 'sortable' => false ]),
            self::makeColumn('created_at', 'Created', ['suppressSizeToFit' => true ])
        ];
        $rowCount = self::rowCount('core_api_logs', []);

        return response()->json([
            'columns' => $columns,
            'rows' => $rowCount,
            'controls' => []
        ]);
    }

    private static function rowCount($table, $agFilters)
    {
        $select = \DB::table($table)->selectRaw('count(id) as count');

        return AgGrid::applyFilter($select, $agFilters)
                ->first();
    }

    private static function makeColumn($field, $header = null, $extra = [])
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\APILogs  $aPILogs
     * @return \Illuminate\Http\Response
     */
    public function show(APILogs $aPILogs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\APILogs  $aPILogs
     * @return \Illuminate\Http\Response
     */
    public function edit(APILogs $aPILogs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\APILogs  $aPILogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, APILogs $aPILogs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\APILogs  $aPILogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(APILogs $aPILogs)
    {
        //
    }
}
