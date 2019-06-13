<?php

namespace App\Http\Controllers\Api\UsersApi;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Exceptions\HttpResponseException;


class Form extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // pass the user identity validation
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
            "account"       =>  'bail|required|unique:users|min:6|max:191',
            "password"      =>  'bail|required|min:6|max:191',

            "first_name"    =>  'required|min:1|max:191',
            "gender"        =>  ['required', Rule::in(['男', '女'])],
            "last_name"     =>  'required|min:1|max:191',
            "city"          =>  'required|min:1|max:191',
            "address"       =>  'required|min:1|max:191',
            "birthday"      =>  'nullable',

            "tel"           =>  ['required', 'regex:/^09[0-9]{8}/'],
            "interest"      =>  'required|json',
            "photo"         =>  'mimes:jpeg|Nullable',
        ];
    }

    public function failedValidation(Validator $validator) {
        $response = ResponseHelper::responseMaker(1, $validator->errors(),null);
        unset($response['http_code']);
        throw new HttpResponseException(response()->json($response));
    }
}
