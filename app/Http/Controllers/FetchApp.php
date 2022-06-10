<?php

namespace App\Http\Controllers;

use Validator;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Testing\Fluent\AssertableJson;

class FetchApp extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    //1. Fetch App (task3, task4, task5)
    public function task3()
    {   
        $token    = JWTAuth::parseToken()->authenticate();
        
        //Request JSON Auth with token
        $response = Http::withToken($token)->retry(2, 0, function ($exception, $request) {
            // if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
            //     return false;
            // }
         
            // $request->withToken($this->getNewToken());
            return true;
        })->get('https://60c18de74f7e880017dbfd51.mockapi.io/api/v1/jabar-digital-services/product');
        $resource = json_decode($response);
        
        //Get Currency ini https://apilayer.com/ get USD to IDR
        $response2 = Http::withHeaders([
            'Content-Type' => 'text/plain',
            'apikey' => 'nt3pDAZNRV9CaVSWVFbnVrrOHViYtm5G'
        ])->get('https://api.apilayer.com/fixer/convert?to=IDR&from=USD&amount=1')->json();
        $valCurrency = $response2['info']['rate']; // GET Rate 1 USD = 14537 IDR
        
        //Insert PriceIDR to array
        $newJSON         = array();
        foreach ($resource as $json) {
            $h['id']         = $json->id;
            $h['createdAt']  = $json->createdAt;
            $h['price']      = $json->price;
            $h['department'] = $json->department;
            $h['product']    = $json->product;
            $h['priceIDR']   = $json->price*$valCurrency;
            
            array_push($newJSON, $h);
        }
        //Convert to JSON
        return json_encode($newJSON, JSON_PRETTY_PRINT);
    }

    
    public function task4()
    {
        $token    = JWTAuth::parseToken()->authenticate();
        
         //Request JSON Auth with token
        $response = Http::withToken($token)->retry(2, 0, function ($exception, $request) {
            // if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
            //     return false;
            // }
         
            // $request->withToken($this->getNewToken());
            return true;
        })->get('https://60c18de74f7e880017dbfd51.mockapi.io/api/v1/jabar-digital-services/product');
        $resource = json_decode($response);
        
       //Get Currency ini https://apilayer.com/ get USD to IDR
       $response2 = Http::withHeaders([
            'Content-Type' => 'text/plain',
            'apikey' => 'nt3pDAZNRV9CaVSWVFbnVrrOHViYtm5G'
        ])->get('https://api.apilayer.com/fixer/convert?to=IDR&from=USD&amount=1')->json();
        $valCurrency = $response2['info']['rate']; // GET Rate 1 USD = 14537 IDR
        
        $out = [];
        //Grouping Array by Department
        foreach($resource as $element) {
            $out[$element->department][] = [
                    'id' => $element->id, 
                    'createdAt' => $element->createdAt,
                    'price' => $element->price,
                    'product' => $element->product,
            ];
        }
        return  json_encode($out, JSON_PRETTY_PRINT);
    }
}