<?php

namespace App\Http\Requests;

use App\Rules\CnpjValido;
use App\Rules\CpfOuCnpj;
use App\Rules\CpfValido;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFornecedorRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'tipo_documento' => ['required', Rule::in(['CPF', 'CNPJ'])],
            'documento' => ['required', 'unique:fornecedores', new CpfOuCnpj],
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
        ];

        if ($this->input('tipo_documento') === 'CPF') {
            $rules['documento'] = ['required', 'unique:fornecedores', new CpfValido];
        } elseif ($this->input('tipo_documento') === 'CNPJ') {
            $rules['documento'] = ['required', 'unique:fornecedores', new CnpjValido];
        }

        return $rules;
    }
}
