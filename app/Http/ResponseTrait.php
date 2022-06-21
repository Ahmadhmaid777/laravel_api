<?php

namespace App\Http;

use phpDocumentor\Reflection\Types\Void_;

trait ResponseTrait
{
public function fetchData($message,$status,$array){

    $array=[
        'message'=>$message,
        'data'=>$array,
        'status'=>$status
    ];

    return response()->json($array,$status);
}
}
