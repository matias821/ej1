<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UserDataRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'name'                     => 'string',
            'email'                    => 'email',
            'actividad'                => 'string',
            'foto'                     => 'string',
        ];

    }
}
