<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::with('loans')->get();
        $users = User::all();
        // return view('users.index', [
        //     'users' => $users
        // ]);

        return view('users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|unique:users,id_pengguna',
            'name' => 'required',
            'kelas'=> 'nullable|string',
            'jurusan'=> 'nullable|string',
            'nomor_kelas'=> 'nullable|string',
            'status' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password'=> 'required|confirmed',
        ]);

        
        $array = $request->only([
            'id_pengguna',
            'name',
            'kelas',
            'status',
            'jurusan',
            'nomor_kelas',
            'email',
            'password',
        ]);
        $array['password'] = bcrypt($array['password']);
        $user = User::create($array);
        // return redirect()->route('users.index')
        //     ->with('success_message', 'Berhasil menambah user baru');

        return response()->json($user, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('loans')->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'success',
                'message' => "user not found",
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "$user->id_pengguna user detail",
            'data' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) return redirect()->route('users.index')
            ->with('error_message', 'User dengan id '.$id.' tidak ditemukan');
        return view('users.edit', [
            'user' => $user
        ]);
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
        $user = User::find($id)->first();
        $validatedUser = $request->validate([
            "id_pengguna" => "required|unique:users,id_pengguna,".$user->id,
            'name' => 'required',
            'kelas'=> 'nullable|string',
            'jurusan'=> 'nullable|string',
            'nomor_kelas'=> 'nullable|string',
            'status' => 'nullable|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password'=> 'nullable|confirmed',
        ]);

        if ($request->password) $validatedUser['password'] = bcrypt($request->password);
        User::where('id_pengguna',$user->id_pengguna)->update($validatedUser);

        return response()->json($validatedUser, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id user not found",
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => "$user->id_pengguna has been deleted"
        ]);

    }
}
