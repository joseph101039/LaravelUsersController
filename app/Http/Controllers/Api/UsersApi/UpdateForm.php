<?php

namespace App\Http\Controllers\Api\UsersApi;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateForm extends FormRequest
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
            "account"       =>  'bail|unique:users|min:6|max:191',
            "password"      =>  'bail|min:6|max:191',

            "first_name"    =>  'min:1|max:191',
            "gender"        =>  [ Rule::in(['男', '女'])],
            "last_name"     =>  'min:1|max:191',
            "city"          =>  'min:1|max:191',
            "address"       =>  'min:1|max:191',
            "birthday"      =>  'nullable',

            "tel"           =>  ['regex:/^09[0-9]{8}/'],
            "interest"      =>  'json',
            "photo"         =>  'mimes:jpeg|Nullable',
        ];
    }

    public function failedValidation(Validator $validator) {
        $response = ResponseHelper::responseMaker(1, $validator->errors(),null);
        unset($response['http_code']);
        throw new HttpResponseException(response()->json($response));
    }
}
