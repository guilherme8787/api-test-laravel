<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'cliente_id' => 'required|exists:clientes,id',
            'nome' => 'required|string|max:255',
            'uf' => [
                'required',
                'string',
                'size:2',
                'in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO'
            ],
            'tipo_instalacao' => 'required|string|in:Fibrocimento (Madeira),Fibrocimento (Metálico),Cerâmico,Metálico,Laje,Solo',
            'equipamentos' => 'nullable|array',
            'equipamentos.*.equipamento_id' => 'required_with:equipamentos|exists:equipamentos,id',
            'equipamentos.*.quantidade' => 'required_with:equipamentos|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'O campo cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente informado não existe.',

            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.max' => 'O campo nome não pode ter mais de 255 caracteres.',

            'uf.required' => 'O campo UF é obrigatório.',
            'uf.string' => 'O campo UF deve ser uma string.',
            'uf.size' => 'O campo UF deve ter exatamente 2 caracteres.',
            'uf.in' => 'O campo UF deve ser um estado brasileiro válido.',

            'tipo_instalacao.required' => 'O tipo de instalação é obrigatório.',
            'tipo_instalacao.in' => 'O tipo de instalação deve ser um dos valores permitidos.',

            'equipamentos.array' => 'O campo equipamentos deve ser uma lista.',
            'equipamentos.*.equipamento_id.required_with' => 'O campo equipamento_id é obrigatório quando os equipamentos são fornecidos.',
            'equipamentos.*.equipamento_id.exists' => 'O equipamento informado não existe.',
            'equipamentos.*.quantidade.required_with' => 'A quantidade do equipamento é obrigatória.',
            'equipamentos.*.quantidade.integer' => 'A quantidade do equipamento deve ser um número inteiro.',
            'equipamentos.*.quantidade.min' => 'A quantidade do equipamento deve ser pelo menos 1.',
        ];
    }
}
