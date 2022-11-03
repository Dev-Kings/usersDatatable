<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getData(Request $request)
    {
        $info = [
            "draw" => $request->draw,
            "data" => [],
            "total" => 0,
        ];

        $search = $request->input('search.value');
        $from_date = ($request->from_date) ? $request->from_date : null;
        $to_date = ($request->to_date) ? $request->to_date : null;

        $users = User::orWhere(function ($query) use ($search) {
            $query->where("name", "LIKE", "%" . $search . "%");
        })->dateFilter($from_date, $to_date)->take($request->length)->skip($request->start)->get();

        $info['total'] = User::orWhere(function ($query) use ($search) {
            $query->where("name", "LIKE", "%" . $search . "%");
        })->dateFilter($from_date, $to_date)->count();

        $sl_no_counter = ($request->start == 0) ? 1 : $request->start;
        foreach ($users as $user) {
            $user->sl_no = $sl_no_counter;
            $sl_no_counter++;
            $user->action = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
            $user->checkbox = '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />';
        }

        $info['data'] = $users;

        return $info;
        
    }

    public function queryUsers(Request $request){
        if($request->ajax()){
            //$users = User::select('id', 'name', 'phone_no', 'date_of_birth', 'email')->get();
            $users = DB::table('users')
                        ->select(
                            'users.*',
                        )->get();

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox','action'])
            ->make(true);
        }        
    }

    public function bulkDelete(Request $request)
    {
        dd($request);
        $users_id = $request->input('id');
        $user = User::whereIn('id', $users_id);
        if ($user->delete()) {
            echo 'User data deleted';
        }
    }
}
