<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBiditemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'picture_name' => 'required|file|mimes:jpg,jpeg,png,gif',
            'endtime' => 'required|after:now',
        ];
    }

    public function withValidator($validator)	
    {	
        $validator->after(function ($validator)	
        {	
            $fileData = $this->file('picture_name');	
            $fileExtension = $fileData->getClientOriginalExtension();	
            $lowerCaseConversion = strtolower($fileExtension);	

            if($lowerCaseConversion !== 'jpg' && $lowerCaseConversion !== 'jpeg' && $lowerCaseConversion !== 'png' && $lowerCaseConversion !== 'gif'){	
                $validator->errors()->add('', '画像ファイルをアップロードしてください。');	
            }	
            
        });	
    }

}
