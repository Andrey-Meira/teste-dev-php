<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfValido implements Rule
{
    public function passes($attribute, $value)
    {
        $cpf = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += $cpf[$i] * (($t + 1) - $i);
            }
            $rest = ($sum * 10) % 11;
            if ($rest == 10) $rest = 0;

            if ($cpf[$t] != $rest) return false;
        }

        return true;
    }

    public function message()
    {
        return 'O CPF informado é inválido.';
    }
}
