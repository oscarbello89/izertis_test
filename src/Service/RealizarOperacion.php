<?php

namespace App\Service;

/* Este servicio realiza la tareas relacionadas con las operaciones matemáticas */

class RealizarOperacion
{
    public function operacionARealizar($operacion, $operatorA, $operatorB)
    {
        //Comprobamos el tipo de operación y se llama a la funcion que realiza el cálculo 
        switch ($operacion) {
            case "add":
                return $this->add($operatorA, $operatorB);
            case "sub":
                return $this->sub($operatorA, $operatorB);
            case "mult":
                return $this->mult($operatorA, $operatorB);
            case "div":
                return $this->div($operatorA, $operatorB);
            default:
                return "La operación '" . $operacion . "', no está soportada! Utilice: add para sumar, sub para restar, mult para multiplicar o div para dividir.";
        }
    }

    /*Función que realiza la operación de sumar */
    public function add(int $operatorA = 0, int $operatorB = 0): int
    {
        return $operatorA + $operatorB;
    }

    /*Función que realiza la operación de restar */
    public function sub(int $operatorA = 0, int $operatorB = 0): int
    {
        return $operatorA - $operatorB;
    }

    /*Función que realiza la operación de multiplicar */
    public function mult(int $operatorA = 0, int $operatorB = 0): int
    {
        return $operatorA * $operatorB;
    }

    /*Función que realiza la operación de dividir */
    public function div(int $operatorA = 0, int $operatorB = 0): float
    {
        return $operatorA / $operatorB;
    }
}
