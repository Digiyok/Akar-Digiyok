<?php

namespace App\Http\Services;

use App\Models\Setting;
use App\Models\Siswa\CalonSiswa;
use Carbon\Carbon;
use GuzzleHttp\Client;
use stdClass;

class BsiService
{
    public static function registerInvoice($name, $email, $address, $va, $desc, $unit)
    {
        // Dari funct
        // $unit = 0;

        $client = new Client();
        $method = 'POST';
        $url = env('BSI_API_DEV_BILLING_HOST').'/api/v2/register';
        // $auth = 'Bearer '.self::getToken();
        $auth = 'Bearer '.self::getToken($unit);

        $date = now()->format('Y-m-d');

        $object = new stdClass();
        $object->description = 'SISTA '.$desc;
        $object->unitPrice = 0;
        $object->qty = 1;
        $object->amount = 0;

        $requesting = [
            "date" => $date,
            "amount" => 0,
            "name" => $name,
            "email" => $email,
            "openPayment"  => "true",
            "address" => $address,
            "va" => $va,
            "attribute1" => $desc." SIT AULIYA",
            "attribute2" => "Sistem Informasi Sekolah Islam Terpadu Auliya",
            "items" => [
                $object
            ],
            "attributes" => [
            ]
        ];
        // dd(json_encode($requesting));

        $promise = $client->requestAsync($method, $url, [
            'headers' => [
                    'Authorization' => $auth,
            ],
            'json' => [
                "date" => $date,
                "amount" => 0,
                "name" => $name,
                "email" => $email,
                "openPayment"  => "true",
                "address" => $address,
                "va" => $va,
                "attribute1" => "SIT Auliya",
                "attribute2" => "Sistem Informasi Sekolah Islam Terpadu Auliya",
                "items" => [
                    $object
                ],
                "attributes" => [
                ]
            ]
            ])->then(
            function ($response){
                // dd($response->getBody());
                return $response->getBody();
            }, function ($exception){
                // dd($exception->getMessage());
                return $exception->getMessage();
            }
        );
        $response = $promise->wait();
        $data = json_decode($response);
    
        return $data;
    }


    public static function InquiryVa($user,  $unit)
    {
        $client = new Client();
        $method = 'POST';
        $url = env('BSI_API_DEV_BILLING_HOST').'/api/v2/inquiry';
        $auth = 'Bearer '.self::getToken( $unit );

        $date = now();

        $promise = $client->requestAsync($method, $url, [
            'headers' => [
                    'Authorization' => $auth
            ],
            'json' => [
                "va" => "88081234567",
                "invoiceNumber" => 4306,
                "amount" => 50000,
                ]
            ])->then(
            function ($response){
                return $response->getBody();
            }, function ($exception){
                return $exception->getMessage();
            }
        );
        $response = $promise->wait();
        $data = json_decode($response);
    
        return $data;
    }

    private static function auth( $unit)
    {
        // dari funct
        // $unit = 0;

        $client = new Client();
        $method = 'POST';
        $url = env('BSI_API_DEV_TOKEN_URL');


        if($unit == 1 || $unit == 2){
            $client_id = env('BSI_API_TKSD_CLIENT_ID');
            $client_secret = env('BSI_API_TKSD_CLIENT_SECRET');
            $client_username = env('BSI_API_TKSD_USERNAME');
            $client_password = env('BSI_API_TKSD_PASSWORD');
            $bsi_token = 'bsi_token_tksd';
            $bsi_get_token = 'bsi_token_get_date_tksd';
            $bsi_expired_token = 'bsi_token_expired_date_tksd';
        }else if($unit == 3){
            $client_id = env('BSI_API_SMP_CLIENT_ID');
            $client_secret = env('BSI_API_SMP_CLIENT_SECRET');
            $client_username = env('BSI_API_SMP_USERNAME');
            $client_password = env('BSI_API_SMP_PASSWORD');
            $bsi_token = 'bsi_token_smp';
            $bsi_get_token = 'bsi_token_get_date_smp';
            $bsi_expired_token = 'bsi_token_expired_date_smp';
        }else if($unit == 4){
            $client_id = env('BSI_API_SMA_CLIENT_ID');
            $client_secret = env('BSI_API_SMA_CLIENT_SECRET');
            $client_username = env('BSI_API_SMA_USERNAME');
            $client_password = env('BSI_API_SMA_PASSWORD');
            $bsi_token = 'bsi_token_sma';
            $bsi_get_token = 'bsi_token_get_date_sma';
            $bsi_expired_token = 'bsi_token_expired_date_sma';
        }else{
            $client_id = env('BSI_API_DEV_CLIENT_ID');
            $client_secret = env('BSI_API_DEV_CLIENT_SECRET');
            $client_username = env('BSI_API_DEV_USERNAME');
            $client_password = env('BSI_API_DEV_PASSWORD');
            $bsi_token = 'bsi_token';
            $bsi_get_token = 'bsi_token_get_date';
            $bsi_expired_token = 'bsi_token_expired_date';
        }



        $promise = $client->requestAsync($method, $url, [
            'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'grant_type' => 'password',
                'username' => $client_username,
                'password' => $client_password,
            ]
            ])->then(
            function ($response){
                return $response->getBody();
            }, function ($exception){
                return $exception->getMessage();
            }
        );
            
        $response = $promise->wait();
        $data = json_decode($response);

        // data found
        if($data){

            // save token
            $token = Setting::where('name',$bsi_token)->first();
            $token->value = $data->access_token;
            $token->save();
            
            $now = Carbon::now();
            $setting = Setting::where('name',$bsi_get_token)->first();
            $setting->value = $now;
            $setting->save();

            $expired_date = Carbon::now()->addMinutes(4);
            $setting = Setting::where('name',$bsi_expired_token)->first();
            $setting->value = $expired_date;
            $setting->save();
        
        }

    
        return $data;
    }

    public static function getToken( $unit )
    {
        // dari funct
        // $unit = 0;

        if($unit == 1 || $unit == 2){
            $token = Setting::where('name','bsi_token_tksd')->first();
            $expired_date = Setting::where('name','bsi_token_expired_date_tksd')->first();
        }else if($unit == 3){
            $token = Setting::where('name','bsi_token_smp')->first();
            $expired_date = Setting::where('name','bsi_token_expired_date_smp')->first();
        }else if($unit == 4){
            $token = Setting::where('name','bsi_token_sma')->first();
            $expired_date = Setting::where('name','bsi_token_expired_date_sma')->first();
        }else{
            $token = Setting::where('name','bsi_token')->first();
            $expired_date = Setting::where('name','bsi_token_expired_date')->first();
        }


        $now = Carbon::now();

        if($now < $expired_date->value){
            $return = $token->value;
        }else{
            $data = self::auth( $unit );
            $return = $data->access_token;
        }

        return $return;
    }
}