<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfOuCnpj implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $value = preg_replace('/\D/', '', $value);
        return $this->validaCPF($value) || $this->validaCNPJ($value);
    }

    public function message()
    {
        return 'O campo :attribute deve conter um CPF ou CNPJ válido.';
    }

    private function validaCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += $cpf[$i] * (($t + 1) - $i);
            }

            $rest = ($sum * 10) % 11;
            if ($rest == 10) {
                $rest = 0;
            }

            if ($cpf[$t] != $rest) {
                return false;
            }
        }

        return true;
    }


    private function validaCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $soma = 0;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $peso1[$i];
        }

        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        $soma = 0;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $peso2[$i];
        }

        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        return $cnpj[12] == $digito1 && $cnpj[13] == $digito2;
    }
}
