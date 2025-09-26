<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjValidation implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cnpj = preg_replace('/[^0-9]/', '', $value);
        
        if (strlen($cnpj) != 14) {
            $fail('O CNPJ deve ter 14 dígitos.');
            return;
        }
        
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            $fail('CNPJ inválido.');
            return;
        }
        
        if (!$this->validateCnpjDigits($cnpj)) {
            $fail('CNPJ inválido.');
        }
    }
    
    private function validateCnpjDigits($cnpj): bool
    {
        // Primeiro dígito verificador
        $sum = 0;
        $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights[$i];
        }
        
        $rest = $sum % 11;
        $digit1 = ($rest < 2) ? 0 : 11 - $rest;
        
        if ($cnpj[12] != $digit1) {
            return false;
        }
        
        // Segundo dígito verificador
        $sum = 0;
        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights[$i];
        }
        
        $rest = $sum % 11;
        $digit2 = ($rest < 2) ? 0 : 11 - $rest;
        
        return $cnpj[13] == $digit2;
    }
}