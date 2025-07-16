<?php

namespace App\Http\Requests;

use App\Models\Fornecedor;
use App\Rules\CpfOuCnpj;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFornecedorRequest extends FormRequest
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

    public function prepareForValidation()
    {
        try {
            $fornecedor = Fornecedor::findOrFail($this->route('id'));
        } catch (ModelNotFoundException) {
            abort(404, 'Fornecedor não encontrado');
        }

        if (
            $this->has('documento') && $this->input('documento') !== $fornecedor->documento ||
            $this->has('tipo_documento') && $this->input('tipo_documento') !== $fornecedor->tipo_documento
        ) {
            abort(403, 'Você não pode alterar o tipo de documento ou o número do documento.');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
        ];
    }
}
