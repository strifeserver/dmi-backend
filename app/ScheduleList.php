<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleList extends Model
{
    use HasFactory;
    protected $fillable = [
        "survey_tracking_id",
        "survey_id",
        "schedule_title",
        "classes",
        "schedule_type",
        "requested_by",
        "approved_by",
        "schedule_raw",
        "date",
        "end_date",
        "time",
        "description",
        "remarks",
        "status",
    ];

    public function index(array $data): array
    {
        $returns = [];
        $items_per_page = @$data['items_per_page'];
        $pagination = @$data['pagination'];
        $filter = is_string($data['filters']) ? json_decode($data['filters'], true) ?? [] : $data['filters'] ?? [];
        $sort = @json_decode($data['sort'], true) ?? [];
        $display_fields_only = $data['display_fields_only'] ?? false;

        #default newest_to_oldest
        if (empty($sort) || empty($sort['created_at'])) {
            $sort['created_at'] = ['sort_by' => 'descending'];
        }

        $fields = $this->display_fields();
        $selected_fields = @$data['fieldnames'];

        if (!empty($selected_fields)) {
            $fields = $selected_fields;
        }
        if ($display_fields_only) {
            $fields = $display_fields_only;
        }

        $query = $this->select($fields);

        if (!empty($filter)) {
            $query = $this->applyFilters($query, $filter);
        }

        if (!empty($sort)) {
            $query = $this->applySorting($query, $sort);
        }

        try {
            if ($pagination == 1) {
                $result = $query->paginate($items_per_page)->toArray();
            } else {
                $result = $query->get()->toArray();
            }
            $returns['status'] = 1;
            $returns['data'] = @$result;
        } catch (\Throwable $th) {
            $returns['status'] = 0;
            $returns['error_message'] = $th->getMessage();
        }

        return $returns;
    }

    private function applySorting($query, $sortModel)
    {
        foreach ($sortModel as $key => $value) {
            switch ($value['sort_by']) {
                case 'ascending':
                    $query->orderBy($key, 'ASC');
                    break;
                case 'descending':
                    $query->orderBy($key, 'DESC');
                    break;
            }
        }
        return $query;
    }

    private function applyFilters($query, $filters)
    {
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'all':
                    $count = 0;
                    $fields = $this->getFillable();
                    $fields = $this->display_fields();
                    $attributes = ['fields' => $fields, 'search_value' => $value->filter];
                    $query->where(function ($query) use ($attributes) {
                        $fields = $attributes['fields'];
                        $search_value = $attributes['search_value'];
                        $searched_fields = [];
                        foreach ($fields as $field_values) {
                            $raw_field_names = explode('.', $field_values);
                            $searched_fields[] = $field_values . ' == ' . $search_value;

                            $check_alias = explode(' as ', $raw_field_names[1]);
                            if (!empty($check_alias[1])) {
                                $tbl_name = $raw_field_names[0];
                                $field = $check_alias[0];
                                $field_values = $tbl_name . '.' . $field;
                            }
                            $query->orWhere($field_values, 'LIKE', '%' . $search_value . '%');
                        }
                    });
                    break;
                case 'created_at';
                    try {
                        $from = date('Y-m-d', strtotime($value->from));
                        $to = date('Y-m-d', strtotime($value->to));
                        $from = $from . ' 00:00:00';
                        $to = $to . ' 23:59:59';
                        $query->whereBetween('created_at', [$from, $to]);
                    } catch (\Throwable $th) {
                        // handle the error
                    }
                    break;
                case 'updated_at';
                    try {
                        $from = date('Y-m-d', strtotime($value->from));
                        $to = date('Y-m-d', strtotime($value->to));
                        $from = $from . ' 00:00:00';
                        $to = $to . ' 23:59:59';
                        $query->whereBetween('updated_at', [$from, $to]);
                    } catch (\Throwable $th) {
                        // handle the error
                    }
                    break;
                default:
                    $fields = $this->display_fields();
                    foreach ($fields as $field_values) {
                        $raw_field_names = explode('.', $field_values);
                        if (in_array($key, $raw_field_names)) {
                            $key = $field_values;
                        }
                    }

                    $query->where($key, 'LIKE', '%' . ($value->filter ?? $value['filter'] ?? '') . '%');

                    break;
            }
        }
        return $query;
    }
    public function display_fields($mode = null)
    {

        $fields = [
            "id",
            "survey_id",
            "survey_tracking_id",
            "requested_by",
            "approved_by",
            "schedule_raw",
            "date",
            "date as start_date",
            "end_date",
            "time",
            "schedule_title",
            "classes",
            "description",
            "remarks",
            "status",
            "created_at",
            "updated_at",
        ];

        $amibiguous_fields = [
        ];

        if ($mode == 1) {
            $detail_fields = [];
            $detail_fields['amibiguous_fields'] = $amibiguous_fields;
            $detail_fields['main_fields'] = $fields;
            $detail_fields['joined_fields'][] = $variable;

            $fields = $detail_fields;

        } else {
            $fields = array_merge($amibiguous_fields, $fields);
        }

        return $fields;
    }

    public function execute_store($request): array
    {

        $returns = [];
        $id = optional($request)->get('id', '');
        $fields = $this->fillable;

        $submittedData = collect($request)->only($fields)->toArray();
        $execute = $this::create($submittedData)->id;
        // echo '<pre>';
        // print_r($request);
        // exit;

        $executeStatus = (is_integer($execute)) ? 1 : 0;
        $returns['status'] = $executeStatus;
        $returns['data_id'] = $execute;

        return $returns;
    }

    public function execute_update($request): array
    {
        
        $id = $request['id'] ?? $request->input('id');
        $fields = $this->fillable;

        $data = $this->where('id', $id)->first();

        $request = collect($request);
        if ($data) {
            $submittedData = $request->only($fields);
            $beforeUpdate = $data->toArray();
            $submittedUpdate = $submittedData->toArray();
            $execute = $data->update($submittedUpdate);
            $auditing = null; // no update auditing defined
        } else {
            return ['result' => 'data does not exist'];
        }

        return [
            'status' => $execute ? 1 : 0,
            'data_id' => $data->id,
        ];
    }

    public function getScheduleTitleAttribute($value)
    {
        if (!$value) {
            switch ($this->classes) {
                case 'chip chip-danger':
                    # code...
                    $value = 'Rejected';
                    break;
                case 'chip chip-success':
                    $value = 'Success';

                    # code...
                    break;
                case 'chip chip-warning':
                    $value = 'Pending';
                    break;

                default:
                    $value = 'Others/Appointments';

                    break;
            }
        }
        return $value;
    }
    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d h:i:s A', strtotime($value));
    }
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d h:i:s A', strtotime($value));
    }
}
