<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest()->get();

        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->user_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn.= '&nbsp;&nbsp';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->user_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteData"><i class="fa-solid fa-trash"></i> Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('users.index',compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'avatar'=>'mimes:png,jpg|max:3000'
        ]);

        if($request->file('avatar')){
            $path  = $request->file('avatar')->store('avatar-image');
        }

        $id = IdGenerator::generate(['table' => 'users','field'=>'user_id', 'length' => 8, 'prefix' =>'USR-']);

        $user = new User();
        $user->user_id = $id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $path;
        $user->password = Hash::make($request->password);
        $user->isAdmin = $request->isAdmin;

        $user->save();
        Alert::success('Success Title', 'Success Message');


        return redirect('/users');
    }

    public function edit($user_id)
    {
      $where = array('user_id' => $user_id);
    //   dd($where);
      $users  = User::where($where)->first();
        // dd($users);
      return response()->json($users);
    }

    public function update(Request $request,$user_id)
    {
        // dd($request);
        $rule = [
            'name'=>'required',
            'email'=>'email|required',
            'password'=>'required',
            'avatar'=>'mimes:png,jpg|max:3000'
        ];

        $validator = $request->validate($rule);

        if($validator){
            $user = User::where('user_id',$user_id);
            // dd($user);
            if($request->file('avatar')){
                if($request->oldImage){
                    Storage::delete($request->oldImage);
                }

                $path  = $request->file('avatar')->store('avatar-image');
            }else{
                $path = $request->oldImage;
            }


        $user->update([
            // 'user_id'=>$request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar'=>$path,
            'isAdmin'=>$request->isAdmin,
        ]);

        Alert::success('Success Title', 'Success Message');


        return redirect('/users');

        }
            return response()->json([
                'message'=>'update failed',
                'success'=>false
            ]);
    }
    public function destroy($user_id)
    {
        $user = User::where('user_id',$user_id);
        $user->delete();
        return redirect('/users');
    }
}
