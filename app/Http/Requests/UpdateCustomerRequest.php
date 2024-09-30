<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:clientes',
            'telefone' => 'nullable|string|max:15',
            'cpf' => 'nullable|cpf|unique:clientes,cpf',
            'cnpj' => 'nullable|cnpj|unique:clientes,cnpj',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.max' => 'O campo nome não pode ter mais de 255 caracteres.',

            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'O email informado já está em uso.',

            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.string' => 'O campo telefone deve ser um texto.',
            'telefone.max' => 'O campo telefone não pode ter mais de 15 caracteres.',

            'cpf.cpf' => 'O CPF informado não é válido.',
            'cpf.unique' => 'O CPF informado já está em uso.',

            'cnpj.cnpj' => 'O CNPJ informado não é válido.',
            'cnpj.unique' => 'O CNPJ informado já está em uso.',
        ];
    }
}
