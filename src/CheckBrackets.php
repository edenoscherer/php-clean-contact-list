<?php

declare(strict_types=1);

namespace Edeno\PhpCleanContactList;

final class CheckBrackets
{
    public static function test(string $value)
    {
        // Array com a lista colchetes válidos
        $brackets = ['[' => ']', '{' => '}', '(' => ')'];
        // Array com a lista colchetes invertida
        $closedBrackets = array_values($brackets);
        // Array com a lista de colchetes encontreados no teste
        $bracketsTest = [];
        // quantidade de caracteres da string recebida
        $length = strlen($value);
        for ($i = 0; $i < $length; $i++) {
            // caractere atual da string
            $char = $value[$i];
            if (isset($brackets[$char])) { // verifique se é um colchetes de abertura
                $bracketsTest[] = $brackets[$char]; // adiciona o colchetes de fechamento a lista para verificação
            } else if (in_array($char, $closedBrackets)) { // verifique se é um colchetes de fechamento
                $expected = array_pop($bracketsTest); // retira o último  colchetes de fechamento da lista de teste
                if (($expected === NULL) || ($char != $expected)) { // caso o array estiver vazio ou estiver  fechando algum diferente o último  aberto
                    return false;
                }
            }
        }
        return empty($bracketsTest);
    }
}
