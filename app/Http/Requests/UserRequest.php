<?php

namespace App\Http\Requests;

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

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('password', 'required|min:6|confirmed', function($input)
        {
            if(!empty($input->password) || ((empty($input->password) && $this->route()->getName() !== 'user.update'))) {
                return TRUE;
            }
            return FALSE;
        });

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = (isset($this->route()->parameter('user')->id)) ? $this->route()->parameter('user')->id : '';

        return [
            'name' => 'required|max:190',
            'login' => 'required|max:190|unique:users,login,'.$id,
            'role' => 'integer',
            'telefon' => 'required',
            'email' => 'required|email|max:190|unique:users,email,'.$id
        ];
    }
}
