<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
     
        if($request->id){
            return [
                'name'=> 'required',
                'email'=> 'required|email',
                'password'=> 'required|min:8',
                'role_id'=> 'required',
            ];
        }
        return [
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:8',
            'role_id'=> 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Họ và tên không được để trống',
            'email.required'=> 'Email không được để trống',
            'email.email'=> 'Email không đúng định dạng',
            'email.unique'=> 'Email đã tồn tại',
            'password.required'=>'Mật khẩu không được để trống',
            'password.min'=>'Mật khẩu tối thiểu 8 ký tự',
            'role_id.required'=>'chức vụ không được để trống',

        ];
    }
}
