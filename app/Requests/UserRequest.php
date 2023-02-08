<?php


namespace App\Requests;
use Illuminate\Http\Request;


class UserRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'email.unique' => 'Такой email уже существует',
            'email.required' => 'Введите Email',
            'name.required' => 'Введите Имя',
            'password.required' => 'Введите пароль'
        ];
    }
}
