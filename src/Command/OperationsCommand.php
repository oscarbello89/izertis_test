<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\RealizarOperacion;

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
