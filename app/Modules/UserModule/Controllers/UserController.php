<?php

namespace App\Modules\UserModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\UserModule\DAO\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class UserController extends Controller
{

    protected $path = 'UserModule::html.';
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view($this->path . 'index', compact('users'));
    }

    public function validateUser($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => [Rule::requiredIf($action == 'store')],
            ]
        );
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path . 'create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateUser($request);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!is_null($request->password) && !is_null($request->password_confirmation)) {
            $password = Hash::make($request->password);
            $request->merge(['password' => $password]);
        }

        $user = User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }


    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view($this->path . 'edit', compact('user'));
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view($this->path . 'show', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = $this->validateUser($request, 'update', $id);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (!is_null($request->password)) {
            $password = Hash::make($request->password);
        }else{
            $password = $user->password;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
