<?php

namespace App\Tests;

use App\Service\RealizarOperacion;
use PHPUnit\Framework\TestCase;

class CalculadoraTest extends TestCase
{
    public function testAdd()
    {
        $calculadora = new RealizarOperacion();
        $result = $calculadora->add(30, 12);

        $this->assertEquals(42, $result);
    }

    public function testSub()
    {
        $calculadora = new RealizarOperacion();
        $result = $calculadora->sub(30, 12);

        $this->assertEquals(18, $result);
    }

    public function testMult()
    {
        $calculadora = new RealizarOperacion();
        $result = $calculadora->mult(5, 6);

        $this->assertEquals(30, $result);
    }

    public function testDiv()
    {
        $calculadora = new RealizarOperacion();
        $result = $calculadora->div(30, 6);

        $this->assertEquals(5, $result);
    }
}
