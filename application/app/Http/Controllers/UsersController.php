<?php

namespace App\Http\Controllers;

use App\User;
use App\Petani;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        // $this->middleware('api', [
        // 'only' => ['','']
        // ]);
        
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('level', '=', 0)->with('petani' )->get();
        // dd($users);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.addusers');
        // return view('admin.users.addusers');    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            // 'nama'  => 'required',
            'email'         => 'required|string|email|max:255|unique:tb_users',
            'password'      => 'required',
            // 'id_user'        => 'required',
            'nama_petani'   => 'required',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            
        ]);
        if($validator->fails()){
            return response()->json([
                'msg'  => 'failed create user',
                'error' => $validator->errors(),
                'status' => 401
            ]);
        }

        $create = User::create([
            'email'     => $request->email,
            'password'  => encrypt($request->password),
            'level'     => 0

        ]);
        if($create){

            // $uniqueFileName = uniqid() . $request->get('foto_petani')->getClientOriginalName() . '.' . $request->get('foto_petani')->getClientOriginalExtension());
            // $request->get('foto_petani')->move(public_path('images/petani/coba/') . $uniqueFileName);
            // return redirect()->back()->with('success', 'File uploaded successfully.');

            // $photo = $request->foto_petani;
            // $savename = time().'.jpg';
            // file_put_contents("images/petani/".$savename, base64_decode($photo));

          
                $file = $request->foto_petani;
                $ext = $file->getClientOriginalExtension();
                $newName = rand(100000,1001238912).".".$ext;
                $file->move('images/petani/',$newName);
                // $y->file = $newName;
                // return $file_name;
            

            // $imagedata = base64_encode(file_get_contents($request->file('image')->pat‌​h()));

            $create2 = Petani::create([
                'id_user'       => $create->id_user, 
                'nama_petani'   => $request->nama_petani,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'foto_petani'   => $newName,
            
            ]);
            if($create2){
                // return response()->json([
                //     'msg'     => 'user created',
                //     'user'    => $create,
                //     'datauser'=>$create2,
                //     'status'  => 200
                // ]);
                return redirect()->route('users.index')->with('alert', 'Data Sukses Disimpan');
            }
        }
        



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $users = User::findOrFail($id);
        $data = User::with('petani')->findOrFail($id);

        // $nama_petani = $users->petani->nama_petani;
        // $alamat = $users->petani->alamat;
        // $no_hp = $users->petani->no_hp;
        // $id_device = $users->petani->id_device;
        
        // return view('user.edit', compact('users'));
        return view('admin.users.addusers', ['update'=>'1', 'data'=>$data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'email' => 'required|string|email|max:255|unique:tb_users',`
            'password' => 'required|string|min:6|confirmed',
            
        ]);

        $data = User::findOrFail($id);
        $data->email   = $request->email;
        $data->level   = 0;
        $data->password  = encrypt($request->password);
        $data->save();

        if ($data){
            $data2 = Petani::where('id_user', $id)
            ->update([
              'nama_petani' => $request->nama_petani,
              'alamat'      => $request->alamat,
              'no_hp'       => $request->no_hp,
            ]);

            if ($data2) {
                return redirect()->route('users.index')->with('alert', 'Data Sukses Diedit');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        // $data = User::with('petani')->where('id_user', '=', $id)->delete();
        // if ($data) {
        //   $data2 =
        // }
        return back()->with('alert', 'Data Sukses Dihapus');
    }

}
