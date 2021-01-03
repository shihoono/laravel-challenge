<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBiditem extends FormRequest
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
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
            'picture_name' => 'required|file',
            'endtime' => 'required|after:now',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator)
        {
            if($this->filled(['picture_name'])) {
                $file_data = $this->file('picture_name');
                $file_extension = $file_data->getClientOriginalExtension();
                $lower_case_conversion = strtolower($file_extension);

                if($lower_case_conversion !== 'jpg' && $lower_case_conversion !== 'jpeg' && $lower_case_conversion !== 'png' && $lower_case_conversion !== 'gif'){
                    $validator->errors()->add('', '画像ファイルをアップロードしてください。');
                }
            }
        });
    }
}
