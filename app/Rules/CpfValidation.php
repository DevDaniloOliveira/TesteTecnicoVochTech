<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValidation implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/[^0-9]/', '', $value);
        
        if (strlen($cpf) != 11) {
            $fail('O CPF deve ter 11 dígitos.');
            return;
        }
        
        // Lógica de validação do CPF
        if (!$this->isValidCpf($cpf)) {
            $fail('CPF inválido.');
        }
    }
    
    private function isValidCpf($cpf): bool
    {
        // Sua lógica de validação aqui
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false; // CPF com todos números iguais
        }
        
        // Cálculo dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        
        return true;
    }
}