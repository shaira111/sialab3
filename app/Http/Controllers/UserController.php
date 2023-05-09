<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

Class UserController extends Controller {
    private $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    public function getUsers(){
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }
    
    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);  
    }

    public function add(Request $request ){
        
        $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20'
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());
        return $this->json($user, 200);
    }

    public function updateUser(Request $request, $id) {
        $rules = [
            'username' => 'required | max:20',
            'password' => 'required | max:20'
        ];
    
        $this->validate($request, $rules);
    
        $user = User::findOrFail($id);
    
        $user->fill($request->all());
    
        if ($user->isClean()) {
            return response()->json("At least one value must
            change", 403);
        } else {
            $user->save();
            return response()->json($user, 200);
        }
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
    
        $user->delete();
    
        return response()->json($user, 200);
    }
}