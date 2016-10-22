<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $data = [];

        if(file_exists('results.json'))
        {
            $inp = file_get_contents('results.json');
            $data['rows'] = json_decode($inp);
        }

        return view('home', $data);
    }

    public function submit()
    {
        $product_name = $name = Input::get('product_name');
        $quantity = Input::get('quantity');
        $price = Input::get('price');

        $array = ['product_name' => $product_name,
                  'quantity' => $quantity,
                  'price' => $price,
                  'time' => date("Y-m-d H:i:s"),
                  'total' => $quantity*$price];

        if(!file_exists('results.json'))
        {
            $jsonData[] = $array;
            $output = json_encode($jsonData);
            file_put_contents('results.json', $output);
            return response()->json($output, 200);
        }

        $inp = file_get_contents('results.json');
        $tempArray = json_decode($inp);
        array_push($tempArray, $array);
        $jsonData = json_encode($tempArray);
        file_put_contents('results.json', $jsonData);

        return response()->json($jsonData, 200);
    }
}
