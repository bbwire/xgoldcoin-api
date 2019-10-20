<?php

namespace App\Http\Controllers;

use App\Http\Traits\EmailTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    use ResponseTrait, EmailTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::get();

        if (count($clients) < 1) {
            return $this->resultsNotFoundResponse('No clients found!');
        }

        return $this->successResponse($clients);
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

            $name = $data['name'];

            $token = $this->randomString(25);

            $data['password'] = Hash::make($request->password);

            $data['verification_code'] = $token;

            $results = Client::create($data);

            $to = $data['email'];
            $subject = 'Future Options Account Creation';
            $verificationLink = 'http://testemployer.futureoptions.org/#/account/verification/' . $token;

            $this->accountVerificationMail($to, $subject, $name, $verificationLink);

            return $this->successResponse($results, 'Thanks for registering! Please go to your email and verify your account');
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
        $client = Client::where('id', $id)->get()->first();

        return $this->successResponse($client);
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
        $data = $request->all();

        $client = Client::findOrFail($id);

        $now = strtotime(date('Y-m-d h:i:s'));

        if ($request->has('pic')) {

            $photo = $data['pic'];

            if ($photo != 'null')
            {

                $fileName = $now . '-' . $photo->getClientOriginalName();

                $photo->move('uploads', $fileName);

                $data['photo'] = $fileName;
            }

        }

        $client->update($data);

        return $this->updateResponse('Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        $client->delete();

        return $this->updateResponse('Client trashed successfully!');
    }

    public function login (Request $request) {

    $data = $request->all();

    $client = Client::where('email', $data['email'])
        ->orWhere('username', $data['email'])
        ->get()->first();

    if ($client) {

        if ($client->status == 'pending')
            return $this->errorResponse('Your account is not yet activated, please go to your email and follow the activation link!');

        $check_password = Hash::check($data['password'], $client->password);

        if ($check_password) {
            return $this->successResponse($client, 'You have successfully logged in');
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
        $client = Client::where('username', strtolower($username))->get()->first();

        return $client;
    }

    public function find_by_email ($email)
    {
        $client = Client::where('email', strtolower($email))->get()->first();

        return $client;
    }

    public function find_by_phone ($phone)
    {
        $client = Client::where('phone', $phone)->get()->first();

        return $client;
    }

    public function verification ($token) {

        $client = Client::where('verification_code', $token)->get()->first();

        if ($client) {

            $client->status = 'active';
            $client->save();

            return $this->successResponse($client, 'Thanks for verifying your account, you can now login with your credentials!');

        }else{
            return $this->resultsNotFoundResponse('There is a problem with your activation link, make sure you followed the right link!');
        }
    }

    public function password_recovery (Request $request) {

        $data = $request->all();

        $client = Client::where('email', $data['email'])
            ->get()->first();

        if ($client) {

            $verificationLink = 'http://testemployer.futureoptions.org/#/password/reset/' . $client->id .'/' . $client->verification_code;

            $this->passwordRecoveryMail($client->username, $client->email, $verificationLink);

            return $this->updateResponse('Please check your email we have send a recovery link');

        }else{
            return $this->resultsNotFoundResponse('We could not recognize the email you entered!');
        }
    }
}
