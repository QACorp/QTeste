<?php

namespace App\System\Traits;

use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait Validation
{
    public function validation(array $arrayValidation, Request $request){
        $validator = Validator::make($arrayValidation, $request->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
    }
}
