<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['role'])->get();

        if (count($users) < 1) {
            return $this->resultsNotFoundResponse('No users found!');
        }

        return $this->successResponse($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

//        $role = Role::where('id', $data['role_id'])->get()->first();

        // return $this->updateResponse($role->name);

        if ($this->find_by_email($data['email']))
        {
            return $this->errorResponse('Email is already registered');
        }
        elseif ($this->find_by_username($data['username']))
        {
            return $this->errorResponse('Username already registered');
        }
        elseif ($this->find_by_phone($data['phone']))
        {
            return $this->errorResponse('Phone is already registered');
        }
        else {

            $token = $this->randomString(25);

            $data['password'] = Hash::make($request->password);

            $data['code'] = $token;
            $data['status'] = 'active';

            $results = User::create($data);

            return $this->successResponse($results, 'Account created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['role'])->where('id', $id)->get()->first();

        if (!$user) {
            return $this->notFoundResponse();
        }

        return $this->successResponse($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->all();

        $user->update($data);

        return $this->updateResponse('User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $this->updateResponse('User trashed successfully!');
    }

    public function login (Request $request) {

        $data = $request->all();

        $user = User::with(['role'])->where('email', $data['email'])
            ->orWhere('username', $data['email'])
            ->get()->first();

        if ($user) {

            if ($user->status == 'pending')
                return $this->errorResponse('Your account is not yet activated, please go to your email and follow the activation link!');

            $check_password = Hash::check($data['password'], $user->password);

            if ($check_password) {

                return $this->successResponse($user, 'You have successfully logged in');
            }
            else {
                return $this->errorResponse('Password is wrong');
            }

        }else{
            return $this->resultsNotFoundResponse('Email or username dose not exist');
        }
    }

    public function find_by_username ($username)
    {
        $user = User::where('username', strtolower($username))->get()->first();

        return $user;
    }

    public function find_by_email ($email)
    {
        $user = User::where('email', strtolower($email))->get()->first();

        return $user;
    }

    public function find_by_phone ($phone)
    {
        $user = User::where('phone', $phone)->get()->first();

        return $user;
    }

    public function verification ($token) {

        $user = User::with(['role'])->where('token', $token)->get()->first();

        if ($user) {

            $user->status = 'active';
            $user->save();

            return $this->successResponse($user, 'Thanks for verifying your account, you can now login with your credentials!');

        }else{
            return $this->resultsNotFoundResponse('There is a problem with your activation link, make sure you followed the right link!');
        }
    }

    public function password_recovery (Request $request) {

        $data = $request->all();

        $user = User::where('email', $data['email'])
            ->get()->first();

        if ($user) {

            return $this->updateResponse('Please check your email we have send a recovery link');

        }else{
            return $this->resultsNotFoundResponse('We could not recognize the email you entered!');
        }
    }
}
