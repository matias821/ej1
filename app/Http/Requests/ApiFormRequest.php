<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
//use Illuminate\Http\Exceptions\DomainException;
use Illuminate\Contracts\Validation\Validator;
use Exception;
class ApiFormRequest extends FormRequest
{
    public function authorize()                                                                    //No utilizare logica aqui, por tanto cambio el valor a true.
    {
        return 'true';
    }

    protected function failedValidation(Validator $validator): void                               // Cambio redireccionar a url anterior por mostrar errores de validacion
    {
        $jsonResponse = response()->json(['errors' => $validator->errors()], 422);
        throw new HttpResponseException($jsonResponse);
    }

    public function messages()
    {
        return [
            'comment' => 'comment, Es requerido enviar una variable de comentario.',
            'comment_id.required' => 'comment_id ausente, Es requerido un ID de valoracion',
            'cotizacion_id.required' => 'cotizacion_id ausente, Es requerido un ID de cotizacion',
            'comment_id.numeric' => 'comment_id no es un numero, No fue enviado como variable numerica',
            'precio.required' => 'precio es requerido',
            'descripcion.required' => 'descripcion es requerida como valor para actualizar',
            'profesional_id.required' => 'profesional_id es requerido para la operacion solicitada',
            'estado.required' => 'estado es requrido',
            'estado.numeric' => 'estado debe ser una valor numerico del 1 al 4',
        ];
    }

}
