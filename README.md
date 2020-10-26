# Prueba Backend - Calculadora

El ejercicio consiste en crear una serie de servicios para poder realizar operaciones matemáticas empleando Symfony 4.4 o superior con las siguientes funciones:
- Crear un servicio que realice la tarea de realizar la operación matemática.
- Crear un nuevo controlador con formato.
- Crear un comando (symfony/console)

### Como ejecutar este proyecto
1. Descargar o clonar este proyecto desde https://github.com/oscarbello89/izertis_test.git
2.  Si tiene instalado un servidor Nginx o Apache, copie el contenido en un directorio de su servidor y ejecútelo .....
3. En caso contrario, utilizaremos la línea de comandos (CLI) de  `symfony` (consulta toda la información en este [enlace](https://symfony.com/download "symfony")). 
Una vez instalado, abra su terminal de consola, muévase al directorio de su nuevo proyecto e inicie el servidor web local de la siguiente manera (si localmente no tienes instalada una autoridad de certificación añade `--no-tls` al final) :
    `symfony server:start` o `symfony server:start --no-tls`

### Descripción de los trabajos realizados
-  Instalación de la línea de comandos (CLI) de  `symfony`.
-  Creación de la aplicación con el comando `symfony new izertis`.
-  Instalación de Annotations Routes con el comando `symfony composer require annotations`.
-  Activación del log con el comando `symfony composer req logger`.
-  Instalación en desarrollo las herramientas de depuración con el comando `symfony composer req debug --dev`.
-  Instalación del Maker Bundle para generar controladores con el comando `symfony composer req maker --dev`.
-  Generación del controlador de la calculadora con el comando `symfony console make:controller CalculadoraController`.
> -  Creación de la ruta **/{operation}/{operatorA}/{operatorB}** en el controlador **CalculadoraController**.
> - Creación del servicio ***RealizarOperacion***.

-.  Añadir lógica a la calculadora:
         /* La función calcular llama al servicio para realizar la operación y devuelve el resultado.
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

10.  Añadir lógica al servicio:
```php
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
```
-  Creación del comando (symfony/console) **operations** con los siguientes comandos:
> - `composer require symfony/console`
> - `php bin\console make:command`
- Añadirmos la lógica al comando:

```php
class OperationsCommand extends Command
{
    protected static $defaultName = 'operations';

    private $realizarOperacion;

    public function __construct(RealizarOperacion $realizarOperacion)
    {
        $this->realizarOperacion = $realizarOperacion;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Comando para realizar una operación matemática básica.')
            ->addArgument('operatorA', InputArgument::REQUIRED, 'Primer operador')
            ->addArgument('operatorB', InputArgument::REQUIRED, 'Segundo operador')
            ->addArgument('operation', InputArgument::REQUIRED, 'Operación a realizar')
            ->setHelp('Este comando nos permite realizar operaciones matemáticas básicas como sumar(add), restar(sub), multiplicar(mult) y dividir(div).');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $operatorA = $input->getArgument('operatorA');
        $operatorB = $input->getArgument('operatorB');
        $operation = $input->getArgument('operation');

        $resultado = $this->realizarOperacion->operacionARealizar($operation, $operatorA, $operatorB);

        if (is_numeric($resultado)) {
            $io->success('{"result":' . $resultado . '}');
            return Command::SUCCESS;
        } else {
            $io->error($resultado);
            return Command::FAILURE;
        }
    }
}

```
### Pruebas unitarias
1.  Se instala el componente PHPUnit Bridge con el comando: `composer require --dev symfony/phpunit-bridge`
1.  Ejecutamos PHPUnit (la primera vez descargará PHPUnit y sus clases estarán disponibles la aplicación): `php bin\phpunit`
1.  Dentro de la carpeta *src/tests* creamos un nuevo test **CalculadoraTest.php**:

```php
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
```
> Finalmente, para comprobar el resultado de la prueba ejecutamos el comando php `bin\phpunit test\CalculadoraTest.php`
