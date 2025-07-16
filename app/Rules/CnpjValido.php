<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CnpjValido implements Rule
{
    public function passes($attribute, $value)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $soma = 0;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $peso1[$i];
        }

        $resto = $soma % 11;
        $dig1 = $resto < 2 ? 0 : 11 - $resto;

        $soma = 0;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $peso2[$i];
        }

        $resto = $soma % 11;
        $dig2 = $resto < 2 ? 0 : 11 - $resto;

        return $cnpj[12] == $dig1 && $cnpj[13] == $dig2;
    }

    public function message()
    {
        return 'O CNPJ informado é inválido.';
    }
}
