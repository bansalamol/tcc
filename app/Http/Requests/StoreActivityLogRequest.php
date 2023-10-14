<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityLogRequest extends FormRequest
{
    public function authorize()
    {
        return false; // You can implement authorization logic here if needed
    }

    public function rules()
    {
       //
    }


}
