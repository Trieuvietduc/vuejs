<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CompanyRequest extends FormRequest
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
        return [
            'code' => 'required|min:8|regex:/^[0-9a-zA-Z]/i',
            'name' => 'required',
            'telephone' => 'required|digits:10',
            'address' => 'required|max:255'
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'Mã code không được để trống',
            'code.min' => 'Mã code phải trên 8 ký tự',
            'code.regex' => 'Mã code không đúng định dạng',
            'name.required' => 'Họ và tên không được để trống',
            'telephone.required' => 'số điện thoại không được để trống',
            'telephone.digits' => 'số điện thoại phải là số và và có 10 chữ số',
            'address.required' => 'Địa chỉ không được để trống',
            'address.max' => 'Địa chỉ tối đa 255 ký tự',
        ];
    }
}
