<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\test;

class testApi extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $client = new \GuzzleHttp\Client();
        $response =  $client->request('GET', 'http://interview.new.trt.academy/1.php');
        $data = json_decode($response->getBody(), true);
        $dataToArray = [
            'age' => $data['age'],
            'name' => $data['name'],
            'job' => $data['job']
        ];
        if (is_array($dataToArray)) return $dataToArray;
    }
}
