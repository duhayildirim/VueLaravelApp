<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //user resource kullanarak istediğim kolonları çektim
        $users = UserResource::collection(User::orderByDesc('id')->paginate(6));
        return $users;
        //return response()-> json(['users' => $users],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:4'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Bir Sorun Var :(',
                'errors' => $validator -> errors()
            ], 422);
        }

        $data = $request -> only('name','email','password');
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Kayıt Edildi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
        /* tek bir kaydı resource ile döndürmek istersem
        $user = new UserResource(User::find($id));
        return response()-> json(['user' => $user],200); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'required|string|min:4'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Bir Sorun Var :(',
                'errors' => $validator -> errors()
            ], 422);
        }

        $data = $request -> only('name','email','password');
        $data['password'] = bcrypt($data['password']);

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Güncellendi'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kayıt Silindi'
        ]);
    }
}
