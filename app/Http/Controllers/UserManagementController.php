<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserManagementController extends Controller
{
    /** index page */
    public function index()
    {
        return view('usermanagement.list_users');
    }

    /** user view */
    public function userView($id)
    {
        $users = User::where('user_id', $id)->first();
        $role  = DB::table('role_type_users')->get();
        return view('usermanagement.user_update', compact('users', 'role'));
    }

    /** user Update */
    public function userUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin') {
                $user_id       = $request->user_id;
                $name          = $request->name;
                $email         = $request->email;
                $role_name     = $request->role_name;
                $position      = $request->position;
                $phone         = $request->phone_number;
                $date_of_birth = $request->date_of_birth;
                $department    = $request->department;
                $status        = $request->status;

                $image_name = $request->hidden_avatar;
                $image = $request->file('avatar');

                if ($image_name == 'photo_defaults.jpg') {
                    if ($image != '') {
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/images/'), $image_name);
                    }
                } else {
                    if ($image != '') {
                        unlink('images/' . $image_name);
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/images/'), $image_name);
                    }
                }

                $update = [
                    'user_id'       => $user_id,
                    'name'          => $name,
                    'role_name'     => $role_name,
                    'email'         => $email,
                    'position'      => $position,
                    'phone_number'  => $phone,
                    'date_of_birth' => $date_of_birth,
                    'department'    => $department,
                    'status'        => $status,
                    'avatar'        => $image_name,
                ];

                User::where('user_id', $request->user_id)->update($update);
            } else {
                Toastr::error('User update fail :)', 'Error');
            }
            DB::commit();
            Toastr::success('User updated successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('User update fail :)', 'Error');
            return redirect()->back();
        }
    }

    /** user delete */
    public function userDelete(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
        ]);

        if (Session::get('role_name') !== 'Admin' && Session::get('role_name') !== 'Super Admin') {
            Toastr::error('Unauthorized access!', 'Error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $user = User::where('user_id', $request->user_id)->firstOrFail();

            // Delete avatar if not default
            if ($user->avatar !== 'photo_defaults.jpg' && file_exists(public_path('images/' . $user->avatar))) {
                unlink(public_path('images/' . $user->avatar));
            }

            $user->delete(); // Cascade deletes teacher/student due to foreign key

            DB::commit();
            Toastr::success('User deleted successfully!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('User delete failed: ' . $e->getMessage());
            Toastr::error('Failed to delete user!', 'Error');
            return redirect()->back();
        }
    }

    /** change password */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        DB::commit();
        Toastr::success('User change successfully :)', 'Success');
        return redirect()->intended('home');
    }

    /** get users data */
    public function getUsersData(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length"); // total number of rows per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');

        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = $search_arr['value']; // Global search value

        // Custom search parameters from the form
        $searchUserId    = $request->get('user_id');
        $searchName      = $request->get('name');
        $searchPhone     = $request->get('phone_number');

        $users = DB::table('users');

        // Apply custom search filters
        if ($searchUserId) {
            $users->where('user_id', 'like', '%' . $searchUserId . '%');
        }
        if ($searchName) {
            $users->where('name', 'like', '%' . $searchName . '%');
        }
        if ($searchPhone) {
            $users->where('phone_number', 'like', '%' . $searchPhone . '%');
        }

        // Apply global search filter
        $totalRecords = DB::table('users')->count();
        $totalRecordsWithFilter = $users->where(function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%')
                ->orWhere('position', 'like', '%' . $searchValue . '%')
                ->orWhere('phone_number', 'like', '%' . $searchValue . '%')
                ->orWhere('status', 'like', '%' . $searchValue . '%');
        })->count();

        if ($columnName == 'name') {
            $columnName = 'name';
        }

        $records = $users->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('position', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchValue . '%')
                    ->orWhere('status', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();

        $data_arr = [];

        foreach ($records as $key => $record) {
            $avatar = '
                <td>
                    <h2 class="table-avatar">
                        <a class="avatar-sm me-2">
                            <img class="avatar-img rounded-circle avatar" data-avatar="' . $record->avatar . '" src="/images/' . $record->avatar . '" alt="' . $record->name . '">
                        </a>
                    </h2>
                </td>
            ';
            if ($record->status === 'Active') {
                $status = '<td><span class="badge bg-success-dark">' . $record->status . '</span></td>';
            } elseif ($record->status === 'Disable') {
                $status = '<td><span class="badge bg-danger-dark">' . $record->status . '</span></td>';
            } elseif ($record->status === 'Inactive') {
                $status = '<td><span class="badge badge-warning">' . $record->status . '</span></td>';
            } else {
                $status = '<td><span class="badge badge-secondary">' . $record->status . '</span></td>';
            }

            $modify = '
                <td class="text-end"> 
                    <div class="actions">
                        <a href="' . url('view/user/edit/' . $record->user_id) . '" class="btn btn-sm bg-danger-light">
                            <i class="far fa-edit me-2"></i>
                        </a>
                        <a class="btn btn-sm bg-danger-light delete user_id" data-bs-toggle="modal" data-user_id="' . $record->user_id . '" data-bs-target="#delete">
                            <i class="fe fe-trash-2"></i>
                        </a>
                    </div>
                </td>
            ';

            $data_arr[] = [
                "user_id"      => $record->user_id,
                "avatar"       => $avatar,
                "name"         => $record->name,
                "email"        => $record->email,
                "position"     => $record->position,
                "phone_number" => $record->phone_number,
                "join_date"    => $record->join_date,
                "status"       => $status,
                "modify"       => $modify,
            ];
        }

        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData"               => $data_arr
        ];
        return response()->json($response);
    }
}
