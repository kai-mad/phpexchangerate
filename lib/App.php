<?php

namespace CliExchangeRate;

class App {

    protected $outputHandler;
    protected $commandRegistry;

    public function __construct() {
        $this->outputHandler = new OutputHandler();
        $this->commandRegistry = new CommandRegistry();
    }

    public function getOutputHandler() {
        return $this->outputHandler;
    }

    public function registerController($name, CommandController $controller) {
        $this->commandRegistry->registerController($name, $controller);
    }

    public function registerCommand($name, $callable) {
        $this->commandRegistry->registerCommand($name, $callable);
    }

    public function runCommand(array $argv = []) {
        // Default to the help command if nothing else is specified.
        $command_name = "help";

        // Otherwise we treat the first argument as the command name.
        if (isset($argv[1])) {
            $command_name = $argv[1];
        }

        // Try to call the command by name with the given arguments.
        try {
            call_user_func($this->commandRegistry->getCallable($command_name), $argv);
        } catch (\Exception $e) {
            $this->getOutputHandler()->print("ERROR: " . $e->getMessage());
            exit;
        }
    }
}
