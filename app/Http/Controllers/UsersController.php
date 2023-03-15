<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination\AcceptsPagination;
use App\Http\Controllers\Pagination\PageData;
use App\Http\Controllers\Pagination\Paginatable;
use App\Services\AuditService;
use App\Services\DataStatusService;
use App\Services\PageService;
use App\Services\UserService;
use App\Rules\ComplexPassword;
use App\Http\Requests\UserPostRequest;

use App\CorePassword;
use App\CoreSystemStatus;
use App\CoreUserLevel;
use App\Support\AgGrid;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UsersController extends Controller implements Paginatable
{
    use AcceptsPagination;

    protected $main_table;
    public function __construct(User $User, CoreUserLevel $CoreUserLevel, CoreSystemStatus $CoreSystemStatus, DataStatusService $dataStatusService, AuditService $auditService, PageService $pageService, UserService $userService)
    {
        $this->db_table = $User;
        $this->CoreUserLevel = $CoreUserLevel;
        $this->CoreSystemStatus = $CoreSystemStatus;
        $this->GenSet = $this->getGeneralSettings();
        $this->dataStatusService = $dataStatusService;
        $this->auditService = $auditService;
        $this->pageService = $pageService;
        $this->userService = $userService;
    }
    public function getColumns(): array
    {
        $table_cols = $this->table_columns();
        $formatted_cols = [];
        $formatted_cols[] = AgGrid::hidden('id');
        foreach ($table_cols as $key => $value) {
            $table_name = $value['table_name'];
            $table_headername = ($value['headerName']) ? $value['headerName'] : null;
            $is_display = $value['is_display'];

            $column_width = $value['column_width'];
            $filter = @$value['filter'];

            $arr_counter = count($formatted_cols);
            $to_insert = '';

            if ($is_display == true) {
                if ($column_width == 'W_SMALL') {
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_SMALL, $filter);
                }
                if ($column_width == 'W_MEDIUM') {
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_MEDIUM, $filter);
                }
                if ($column_width == 'W_WIDE') {
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_WIDE, $filter);
                }
                if ($column_width == 'W_ULTRAWIDE') {
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_ULTRAWIDE, $filter);
                }
            } else {
                $to_insert = AgGrid::hidden($table_name);
            }
            $formatted_cols[] = $to_insert;
        }

        return $formatted_cols;
    }

    // TABLE COLUMNS

    // DATA FILTERING AND PAGINATION

    public function getPage(int $start, int $end, ?array $sortModel, ?object $filterModel): PageData
    {
        $ctrl_var = $this->controller_variables();

        if ($ctrl_var['accesslevel']->index) {
            $rows = $this->db_table->select('id', DB::raw("CONCAT(first_name,last_name) AS name"), 'email', 'username', 'access_level', 'account_status', 'created_at', 'updated_at')
                ->when($filterModel, function ($query, $filterModel) {
                    foreach ($filterModel as $key => $value) {
                        if ($key == 'created_at') {
                            $created_at = explode(" to ", $filterModel->created_at->filter);
                            $format_date = $this->filter_date_format_v2($created_at[0], $created_at[1]);
                            $from = $format_date['from'];
                            $to = $format_date['to'];
                            $query->whereBetween('created_at', [$from, $to]);
                        } else if ($key == 'status') {
                            $search_is = '';
                            if ($value->filter == 'Active') {
                                $search_is = 1;
                            } else {
                                $search_is = 0;
                            }
                            $query->where($key, 'LIKE', '%' . $search_is . '%');
                        } else {

                            $query->where($key, 'LIKE', '%' . $value->filter . '%');
                        }
                    }
                    return $query;
                })
                ->paginate($end)
                ->toArray();

            $total = $rows['total'];
            $data = $rows['data'];
            $data = $this->change_value($data);

            return new PageData(
                $total,
                $data
            );
        }else{
            abort(404);
        }
    }
    public function validator(Request $request)
    {
        $id = $this->sanitizer($request->input('id'));
        $mode = $this->sanitizer($request->input('mode'));
        $pc = $this->GenSet['Password_Complex'];
        $paasoword_complex = isset($pc) ? $pc : 'OFF';
        $pass_comp = ($paasoword_complex == 'ON') ? array('required', 'string', new ComplexPassword, 'confirmed')
            : array('required', 'string', 'confirmed');

        $input = [
            'username' => $this->sanitizer($request->input('username')),
            'password' => $this->sanitizer($request->input('password')),
            'password_confirmation' => $this->sanitizer($request->input('password_confirmation')),
            'first_name' => $this->sanitizer($request->input('first_name')),
            'last_name' => $this->sanitizer($request->input('last_name')),
            'email' => $this->sanitizer($request->input('email')),
            'mobile_number' => $this->sanitizer($request->input('mobile_number')),
            'access_level' => $this->sanitizer($request->input('access_level')),
            'password_updated_at' => Carbon::now(),
            'google2fa_secret' => $request->input('google2fa_secret'),
            'account_status' => $request->input('account_status'),

        ];

        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'unique:core_users,username,' . $id,
            'email' => 'unique:core_users,email,' . $id,
            // 'email' => 'required|string|email|max:80|unique:core_users',
            'password' => $pass_comp,
            'google2fa_secret' => 'string|nullable',
            'password_updated_at' => 'required',
            'mobile_number' => 'string|nullable',
            'access_level' => 'required',
            'account_status' => 'required',
        ];

        $messages = [];

        $customAttributes = [
            // 'sku_id'=> 'SKU ID',
            // 'store_id'=> 'Store ID',
            // 'sku_raw'=> 'SKU RAW',
            // 'product_name'=> 'Product Name',
            // 'product_description'=> 'Product Description',
            // 'product_price'=> 'Product Price',
            // 'product_category_id'=> 'Product Category',
            // 'is_inventoriable'=> 'Inventoriable',
            // 'stock_status'=> 'Stock Status',
            // 'product_status'=> 'Product Status',
        ];
        if ($mode == 'account_settings') {
            unset($input['password']);
            unset($input['password_confirmation']);
            unset($input['access_level']);

            unset($rules['password']);
            unset($rules['password_confirmation']);
            unset($rules['password_updated_at']);
            unset($rules['google2fa_secret']);
            unset($rules['access_level']);
        }
        if ($mode == 'Update') {
            unset($input['password']);
            unset($input['password_confirmation']);

            unset($rules['password']);
            unset($rules['password_confirmation']);
            unset($rules['password_updated_at']);
        }

        if ($mode == 'change_pass') {
            unset($rules['first_name']);
            unset($rules['last_name']);
            unset($rules['last_name']);
            unset($rules['access_level']);
            unset($rules['username']);
            unset($rules['email']);
            unset($rules['mobile_number']);
            // unset($input['password']);
            // unset($input['password_confirmation']);
            $input['password'] = $request->new_password;
            $input['password_confirmation'] = $request->new_password_confirmation;
            // $returns = [];
            // $user = User::findOrFail($id);
            // $check_password = Hash::check($this->sanitizer($request->current_password), $this->sanitizer($request->password));
            // if(!$check_password){
            //     $returns = ['status'=>'failed','remarks'=>'Old password does not match'];
            //     $validator->getMessageBag()->add('current_password', 'Old password does not match');
            // }
            // if($this->sanitizer($request->new_password) != $this->sanitizer($request->new_password_confirmation)){
            //     $returns = ['status'=>'failed','remarks'=>'New password does not match'];
            //     $validator->getMessageBag()->add('new_password', 'New password does not match');
            // }
        }

        $validator = Validator::make($input, $rules, $messages, $customAttributes);
        if ($mode == 'change_pass') {
            $returns = [];
            $user = User::findOrFail($id);
            $check_password = Hash::check($request->current_password, $user->password);

            if (!$check_password) {
                $returns = ['status' => 'failed', 'remarks' => 'Old password does not match'];
                // $validator->errors()->add('current_password', 'Old password does not match');
                // $request->session()->flash('failed', 'Old password does not match');
            }
            if ($this->sanitizer($request->new_password) != $this->sanitizer($request->new_password_confirmation)) {
                $returns = ['status' => 'failed', 'remarks' => 'New password does not match'];
                // $validator->errors()->add('new_password', 'New password does not match');
                // $request->session()->flash('failed', 'New password does not match');
            }

            if (@$returns['status'] == 'failed') {
                return $returns;
            }
        }

        return $validator->validate();
    }

    public function controller_variables()
    {
        $accesslevel = json_decode($this->acclvl());
        $controller_res = [];
        #UPDATE ON EACH CONTROLLER YOU MAKE WITH TABLE
        $controller_res['site_title'] = 'Users';
        $controller_res['folder_name'] = 'users';
        $controller_res['accesslevel'] = $accesslevel;
        #UPDATE ON EACH CONTROLLER YOU MAKE WITH TABLE
        return $controller_res;
    }

    public function table_columns()
    {
        // DEFINE YOUR TABLE COLUMN DISPLAY HERE
        // W_SMALL
        // W_MEDIUM
        // W_WIDE
        // W_ULTRAWIDE

        $table_col_display = [];
        $table_col_display[] = ['table_name' => 'email', 'headerName' => 'EMAIL', 'is_display' => true, 'column_width' => 'W_ULTRAWIDE', 'filter' => true];
        $table_col_display[] = ['table_name' => 'username', 'headerName' => 'USERNAME', 'is_display' => true, 'column_width' => 'W_WIDE', 'filter' => true];
        $table_col_display[] = ['table_name' => 'access_level', 'headerName' => 'ACCESS LEVEL', 'is_display' => true, 'column_width' => 'W_MEDIUM', 'filter' => true];
        $table_col_display[] = ['table_name' => 'account_status', 'headerName' => 'ACCOUNT STATUS', 'is_display' => true, 'column_width' => 'W_MEDIUM', 'filter' => true];
        $table_col_display[] = ['table_name' => 'created_at', 'headerName' => 'DATE CREATED', 'is_display' => true, 'column_width' => 'W_WIDE', 'filter' => true];
        $table_col_display[] = ['table_name' => 'updated_at', 'headerName' => 'DATE UPDATED', 'is_display' => true, 'column_width' => 'W_WIDE', 'filter' => true];

        return $table_col_display;
    }

    public function index()
    {

        // // FILTER DATA
        $statuses = [['status_name' => 'Active', 'value' => 'Active'], ['status_name' => 'Inactive', 'value' => 'Inactive']];

        $filters = [
            ['filter_name' => 'Page Status', 'filter_code' => 'status', 'filter_type' => 'dropdown_filter', 'dropdown_data' => $statuses],
            ['filter_name' => 'Date Filter', 'filter_code' => 'created_at', 'filter_type' => 'date_filter', 'dropdown_data' => null], #sample_date filter
        ];
        // // FILTER DATA

        $table_version = 'v2';
        $table_version_file = 'default';
        #v1 - load all data, frontend filtering
        #v2 - backend filtering data
        #table_version_file
        #default - using v1 and v2 js file
        #mixed - same file with v1 and v2 switchable tables

        $page_variables = $this->page_variables([
            'mode' => 'index',
            'agrid_data' => @$return_data,
            'data_filters' => $filters,
            'controller_variables' => $this->controller_variables(),
        ]);

        # ADD PARAMS HERE TO FURTHER ADD RETURNS
        $page_variables['static'] = [
            'title' => $page_variables['title'],
            'controls' => json_decode($page_variables['controls']),
            'columns' => $this->getColumns(),
            'pagination_link' => url('paginate/' . $page_variables['folder_name']),
            'agrid_data' => ($table_version == 'v1') ? $return_data : null,
            'data_filters' => $filters,
            'page' => $page_variables['page'],
            'controls_btn_index' => @$controls_btn_index,
            'routes' => [
                $page_variables['folder_name'] . '.edit' => route($page_variables['folder_name'] . '.edit', ':id'),
                $page_variables['folder_name'] . '.destroy' => route($page_variables['folder_name'] . '.destroy', ':id'),
            ],
            'table_version' => $table_version, #v1 v2 options
            'table_version_file' => $table_version_file, #v1 v2 options
            'temp_url' => url('users/make_temp'),
        ];
        return view($page_variables['index_page'], $page_variables);
    }
    public function create()
    {
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Create']);
        $userservice = $this->userService->pageVariables()['data'];

        $page_variables['static'] = $userservice;
        return view($page_variables['create_page'], $page_variables);

    }
    // public function create()
    // {
    //     $google2fa = app('pragmarx.google2fa');
    //     $qr_name = $this->GenSet['qr_name'] ?? 'TEST';
    //     $qr_address = $this->GenSet['qr_address'] ?? '@test.com';
    //     // Generate the QR image. This is the image the user will scan with their app
    //     // to set up two factor authentication
    //     $registration_data = array();
    //     $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();

    //     $QR_Image = $google2fa->getQRCodeInline(
    //         $qr_name, $qr_address,
    //         $registration_data['google2fa_secret']
    //     );

    //     $google_auth = '';
    //     $FA = $this->GenSet['2FA'];
    //     if (isset($FA)) {
    //         if ($FA == 'ON') {
    //             $google_auth = '1';
    //         }
    //     }

    //     $access = auth::user()->access_level;
    //     $statusname = CoreSystemStatus::all();
    //     $CoreUserLevels = $this->CoreUserLevel->get();
    //     $CoreSystemStatus = $this->CoreSystemStatus->get();

    //     if ($access == 1) {
    //         $current_group = CoreUserLevel::all();
    //     } else {
    //         $current_group = CoreUserLevel::where('id', '<>', 1)->get();
    //     }
    //     $page_variables = $this->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Create']);
    //     $page_variables['static'] = [
    //         'core_user_levels' => $CoreUserLevels,
    //         'CoreSystemStatus' => $CoreSystemStatus,
    //     ];
    //     return view($page_variables['create_page'], $page_variables, ['existingSelect' => 0, 'statusData' => $statusname, 'existingSelect3' => 0, 'QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret'], 'google_auth' => $google_auth]);
    // }

    public function store(Request $request)
    {
        $accesslevel = json_decode($this->acclvl());
        if ($accesslevel->add) {
            $ctrl_var = $this->controller_variables();
            $page_variables = $this->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Delete']);
            $validator = $this->validator($request);

            if ($validator) {
                $data = $this->db_table->create($validator)->id;
            }

            if ($data) {
                $auditing = ['data_id' => $data, 'data' => $validator];
                $core_audit_trail = $this->audit_trail('', 'CREATE', $auditing, $data);
            }
            return redirect()->route($page_variables['store_page'])
                ->with('success', $page_variables['title'] . ' Added Successfully');
        } else {
            $audit = $this->audit('', '', 'UNAUTHORIZED', '');
            return abort(404);
        }
    }


    public function edit($id)
    {
        $ctrl_var = $this->controller_variables();
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $edit = $this->db_table->findOrFail($id);
        $page_variables['edit'] = $edit;
        $userservice = $this->userService->pageVariables($edit)['data'];
        $page_variables['static'] = $userservice;

        return view($page_variables['edit_page'], $page_variables);
    }
    public function update(UserPostRequest $request)
    {
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $validated = $request->validated();
        $validated = (array) $request->all();
  
        $execution = $this->userService->update($validated);
        return redirect()
            ->route($page_variables['update_page'])
            ->with(
                $execution['status'],
                $page_variables['title'] . ' Updated ' . $execution['message']
            );
    }


    public function destroy($db_table)
    {
        $page_variables = $this->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'index']);
        $db_table = $this->db_table->findOrFail($db_table);
        $audit = $this->audit('', '', '', $db_table->id);
        $saving = $db_table->delete();
        if ($saving) {
            $return_msg = ['type' => 'success', 'remarks' => 'Successfully Deleted'];
        } else {
            $return_msg = ['type' => 'error_comment', 'remarks' => 'Failed to Delete'];
        }
        return redirect()->route($page_variables['destroy_page'])->with($return_msg['type'], $return_msg['remarks']);
    }
    public function general_info()
    {
        $general_info = array(
            'id' => auth()->user()->id,
            'username' => auth()->user()->username,
            'firstname' => auth()->user()->first_name,
            'lastname' => auth()->user()->last_name,
            'email' => auth()->user()->email,
            'mobile_number' => auth()->user()->mobile_number,
        );
        return $general_info;
    }

    public function account_settings()
    {
        $general_info = $this->general_info();
        return view('pages.users.account-settings', ['gen_info' => $general_info, 'gen' => 'active', 'changepass' => '', 'message' => '']);
    }

    public function change_value($rows)
    {
        $search_array = $rows;
        foreach ($search_array as $key => $value) {

            if ($value['account_status'] == 1) {
                $search_array[$key]['account_status'] = 'Active';
            } else {
                $search_array[$key]['account_status'] = 'Inactive';
            }

            if ($value['access_level']) {
                $CoreUserLevel = $this->CoreUserLevel->where('id', '=', $value['access_level'])->first();
                if ($CoreUserLevel) {
                    $search_array[$key]['access_level'] = $CoreUserLevel->accesslevel;
                }
            }
        }
        return $search_array;
    }

    public function postPasswordHistory($user, $old_pass)
    {
        $array = array(
            'user_id' => $user,
            'old_password' => $old_pass,
        );
        smx_password::create($array);
    }

    public function make_temp(Request $request)
    {

        $random = $this->quickRandom();
        $user_level = User::find($request->input('id'));
        $old_pass = $user_level->password;
        //$old_user = $user_level->username;
        //$old_user.
        $mix = $random;
        $user_level->password = $mix;
        $user_level->temporary_password = $old_pass;
        $user_level->temporary_password_created = date('Y-m-d H:i:s');
        $user_level->save();

        $this->postPasswordHistory($request->input('id'), $old_pass);
        $return = array('temporary_password' => $mix);
        return $mix;
    }

    public static function quickRandom($length = 10)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function lock_account(Request $request)
    {

        $returns = [];
        $_user = User::find($request->input('id'));
        $status = ($_user->account_status == '1' || $_user->account_status == '2') ? '4' : '1';
        $_user->account_status = $status;
        $saving = $_user->save();
        if ($saving) {
            if ($_user->account_status == 1) {
                $returns = ['status' => 'success', 'remarks' => 'Account Successfully unlocked'];
            } else {
                $returns = ['status' => 'success', 'remarks' => 'Account Successfully locked'];
            }
        } else {
            $returns = ['status' => 'failed', 'remarks' => 'failed to update account status'];
        }
        return $returns;
    }
}
