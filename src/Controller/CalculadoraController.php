<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\RealizarOperacion;

class CalculadoraController extends AbstractController
{
    /**
     * @Route("/", name="calculadora")
     */
    public function index(): Response
    {
        return $this->render('calculadora/index.html.twig');
    }


    /**
     * La función calcular llama al servicio para realizar la operación y devuelve el resultado.
     * @Route("/{operation}/{operatorA}/{operatorB}", name="add")
     * @param string $operation
     * @param int $operatorA
     * @param int $operatorB
     * @return JsonResponse
     */
    public function calcular($operation, $operatorA, $operatorB, RealizarOperacion $realizarOperacion)
    {
        //return new JsonResponse(['result' => $realizarOperacion->operacionARealizar($operation, $operatorA, $operatorB)]);

        $respuesta = JsonResponse::fromJsonString('{"result":' . $realizarOperacion->operacionARealizar($operation, $operatorA, $operatorB) . '}');

        return $respuesta;
    }
}
