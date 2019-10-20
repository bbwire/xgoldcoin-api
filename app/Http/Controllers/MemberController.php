<?php

namespace App\Http\Controllers;

use App\Http\Traits\EmailTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    use ResponseTrait, EmailTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::get();

        return $this->successResponse($members);
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

            $name = $data['username'];

            $token = $this->randomString(25);

            $data['password'] = Hash::make($request->password);

            $data['verification_token'] = $token;
            $data['status'] = 'active';

            $results = Member::create($data);

            if ($request->has('referee_id') and $request->has('direction')) {
                $data['leader_id'] = $data['referee_id'];
                $data['member_id'] = $results->id;

                Network::create($data);
            }

            // $to = $data['email'];
            // $subject = 'Future Options Account Creation';
            // $verificationLink = 'http://umbrtech.com/future-client/#/account/verification/' . $token;

            // $this->accountVerificationMail($to, $subject, $name, $verificationLink);

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
        $member = Member::where('id', $id)->get()->first();

        return $this->successResponse($member);
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

        $member = Member::findOrFail($id);

        if ($request->has('pic')) {

            $now = strtotime(date('Y-m-d h:i:s'));

            $photo = $data['pic'];

            if ($photo != 'null')
            {

                $fileName = $now . '-' . $photo->getClientOriginalName();

                $photo->move('uploads', $fileName);

                $data['photo'] = $fileName;
            }

        }

        $member->update($data);

        return $this->updateResponse('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        $member->delete();

        return $this->updateResponse('Member trashed!');
    }

    public function login (Request $request) {

        $data = $request->all();

        $member = Member::where('email', $data['email'])
            ->orWhere('username', $data['email'])
            ->get()->first();

        if ($member) {

            if ($member->status == 'pending')
                return $this->errorResponse('Your account is not yet activated, please go to your email and follow the activation link!');

            $check_password = Hash::check($data['password'], $member->password);

            if ($check_password) {
                return $this->successResponse($member, 'You have successfully logged in');
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
        $member = Member::where('username', strtolower($username))->get()->first();

        return $member;
    }

    public function find_by_email ($email)
    {
        $member = Member::where('email', strtolower($email))->get()->first();

        return $member;
    }

    public function find_by_phone ($phone)
    {
        $member = Member::where('phone', $phone)->get()->first();

        return $member;
    }

    public function verification ($token) {

        $member = Member::where('verification_code', $token)->get()->first();

        if ($member) {

            $member->status = 'active';
            $member->save();

            return $this->successResponse($member, 'Thanks for verifying your account, you can now login with your credentials!');

        }else{
            return $this->resultsNotFoundResponse('There is a problem with your activation link, make sure you followed the right link!');
        }
    }

    public function password_recovery (Request $request) {

        $data = $request->all();

        $member = Member::where('email', $data['email'])
            ->get()->first();

        if ($member) {

            $verificationLink = 'http://umbrtech.com/crypto-client/#/password/reset/' . $member->id .'/' . $member->verification_code;

            $this->passwordRecoveryMail($member->username, $member->email, $verificationLink);

            return $this->updateResponse('Please check your email we have send a recovery link');

        }else{
            return $this->resultsNotFoundResponse('We could not recognize the email you entered!');
        }
    }

    public function member_by_username ($username)
    {
        $user = Member::with(['role'])->where('username', $id)->get()->first();

        if (!$user) {
            return $this->notFoundResponse();
        }

        return $this->successResponse($user);
    }
}
