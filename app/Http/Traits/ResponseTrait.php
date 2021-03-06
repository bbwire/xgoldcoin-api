<?php
/**
 * Created by PhpStorm.
 * User: user pc
 * Date: 11/1/2018
 * Time: 12:38 AM
 */

namespace App\Http\Traits;


use App\Models\SmsRate;
use App\Models\User;
use App\Models\Account;
use App\Models\Log;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Flysystem\Config;

trait ResponseTrait
{

    protected function paginateResponse ($data) {
        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 10;

        $results = collect($data)->slice(($page - 1) * $perPage, $perPage)->values();

//        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, count($data), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends('data', $data);

        return $paginated;
    }

    protected function successResponse($data, $message = 'ok') {

        $response = [
            'code' => 200,
            'error' => false,
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, 200, [], JSON_NUMERIC_CHECK);
    }
    
    protected function notFoundResponse() {

        $response = [
            'code' => 404,
            'error' => true,
            'status' => 'error',
            'message' => 'Resource Not Found'
        ];
        return response()->json($response);
    }

    protected function resultsNotFoundResponse($message) {

        $response = [
            'code' => 200,
            'error' => true,
            'status' => 'error',
            'message' => $message
        ];
        return response()->json($response);
    }

    protected function updateResponse($message) {

        $response = [
            'code' => 200,
            'error' => false,
            'status' => 'success',
            'message' => $message
        ];
        return response()->json($response);
    }

    public function deleteResponse($message) {

        $response = [
            'error' => false,
            'status' => 'success',
            'data' => [],
            'message' => $message
        ];
        return response()->json($response);
    }

    public function errorResponse($message) {

        $response = [
            'code' => 200,
            'error' => true,
            'status' => 'error',
            'message' => $message
        ];
        return response()->json($response);
    }

    protected function randomString($len){
        $result = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++){
            $randItem = array_rand($charArray);
            $result .= "".$charArray[$randItem];
        }
        return $result;
    }

    protected function randomNumber($len){
        $result = "";
        $chars = "0123456789";
        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++){
            $randItem = array_rand($charArray);
            $result .= "".$charArray[$randItem];
        }
        return $result;
    }

    protected function getSmsRate ($number) {

        $rate = 'Not defined';

        $rates = SmsRate::where('min_messages', '<=', $number)->where('max_messages', '>=', $number)->get()->first();

        if ($rates) {
            $rate = $rates->rate;
        }

        return $rate;
    }

    public function mobileMoneyPayments ($phone, $amount, $userId = 1, $ref = null)
    {
        $secret = 'FLWSECK-3d4734cad85e076704fc7ce48e45175b-X';
        $publicKey = "FLWPUBK-275bc03b4d4f1d49ff7350faef50bc24-X";

        $user = User::findOrFail(1);

        $data = ["PBFPubKey" => $publicKey,
            'currency' => 'UGX',
            'country' => 'UG',
            'payment_type' => 'mobilemoneyuganda',
            'amount' => $amount,
            'phonenumber' => $phone,
            'firstname' => $user->first_name,
            'lastname' => $user->last_name,
            'network' => 'UGX',
            'txRef' => $ref,
            'orderRef' => 'MXX-ASC-90929',
            'is_mobile_money_ug' => 1
            ];


        $dataJson = json_encode($data);

        $key = $this->getKey($secret);

        $keyEncrypt = $this->encrypt3Des($dataJson, $key);

        $postData = ["PBFPubKey" => "FLWPUBK-275bc03b4d4f1d49ff7350faef50bc24-X",
            "client" => $keyEncrypt,
            "alg" => "3DES-24"
        ];

        //print_r($postData);

        $response = $this->curl_request_post($postData);

        //var_dump($response);

    }


    public function mobilemoney_pay_now($phone, $amount, $userId = 1, $ref = null){

        $user = User::findOrFail($userId);

        $secret = \Config::get('constants.options.rave_secret');
        $publicKey = \Config::get('constants.options.rave_public');

//        return $secret;

        error_reporting(E_ALL);
        ini_set('display_errors',1);

//        $email = "neri@hamsoftug.com";

        $data = ['PBFPubKey' => $publicKey,
            'currency' => 'UGX',
            'country' => 'UG',
            'payment_type' => 'mobilemoneyuganda',
            'amount' => $amount,
            'phonenumber' => $phone,
            'firstname' => $user->first_name,
            'lastname' => $user->last_name,
            'network' => 'UGX',
            'email' => $user->email,
            'userid' => $user->id,
            'txRef' => $ref,
            'orderRef' => 'MXX-ASC-90929',
            'is_mobile_money_ug' => 1,
            'device_fingerprint' => sha1($ref)];

        $SecKey = $secret;

        $key = $this->getKey($SecKey);

        $dataReq = json_encode($data);

        $post_enc = $this->encrypt3Des( $dataReq, $key);

        //var_dump($dataReq);

        $postdata = array(
            'PBFPubKey' => $publicKey,
            'client' => $post_enc,
            'alg' => '3DES-24');

        return $this->_curl_payment_post($postdata);

    }

    function encrypt3Des($data, $key)
    {
        $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        return base64_encode($encData);
    }

    public function getKey($seckey){
        $hashedkey = md5($seckey);
        $hashedkeylast12 = substr($hashedkey, -12);

        $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
        $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

        $encryptionkey = $seckeyadjustedfirst12.$hashedkeylast12;
        return $encryptionkey;

    }

    public function _curl_payment_post($post_data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.ravepay.co/flwv3-pug/getpaidx/api/charge?use_polling=1');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20000);

        //$curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
        //$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;

        $headers = array('Content-Type: application/json');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec($ch);

        $success = 1;

        if ($request) {
            $result = json_decode($request, true);

        }else{

            if(curl_error($ch))
            {
                $result = curl_error($ch);
            } else {
                $result = 'Null';
            }

            $success = 0;
        }

        curl_close($ch);

        if ($success == 0) {
            return $this->updateResponse($result);
        } else {
            return $this->successResponse($result, 'We have sent a notification on your phone to approve payment');
        }

        
    }

    public function testFunc () {
        $data = [];
        print_r(User::findOrFail(1));
    }

    public function verify_payments ($ref, $user) 
    {
        $result = array();

        $secret = \Config::get('constants.options.rave_secret');

        $postdata =  array( 
          'txref' => $ref,
          'SECKEY' => $secret
          );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20000);

        $headers = [
          'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);
        $err = curl_error($ch);

        if($err){
            // there was an error contacting rave
          die('Curl returned error: ' . $err);
        }


        curl_close ($ch);

        $result = json_decode($request, true);

        $payment = Payment::where('ref', $result->data->txref)->get()->first();

        if('error' == $result->status){
            // there was an error from the API
            $payment->status = 'cancelled';
            $payment->save();

            $data['response_string'] = $result;

            Log::create($data);
        }

        if('successful' == $result->data->status && '00' == $result->data->chargecode){

            $payment->status = 'approved';

            $account = Account::where('user_id', $payment->user_id)->get()->first();

            $newAmount = $account->amount + $payment->amount;

            $account->amount = $newAmount;

            $account->save();
            $payment->save();
        }
    }

}