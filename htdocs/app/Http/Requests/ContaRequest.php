<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;

class ContaRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'valor' => 'required|max:10',
            'vencimento' => 'required|date',
            'situacao_conta_id' => 'Required',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'valor.required' => 'O campo valor é obrigatório',
            'valor.max' => 'O preço so pode ter 8 numeros',
            'vencimento.required' => 'O campo vencimento é obrigatório',
            'situacao_conta_id.required' => 'O campo de situação é obrigatorio',
        ];
    }
    protected function prepareForValidation()
    {
        if ($this->valor) {
            $valor = str_replace('.', '', $this->valor); // tira pontos de milhar
            $valor = str_replace(',', '.', $valor);     // troca vírgula por ponto
            $this->merge([
                'valor' => (float) $valor,              // converte para float
            ]);
        }
    }
}
