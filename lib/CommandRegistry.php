<?php declare(strict_types=1);

namespace CliExchangeRate;

class CommandRegistry {

    protected $commandRegistry = [];
    protected $commandControllers = [];

    public function registerController($commandName, CommandController $commandController) {
        $this->commandControllers = [ $commandName => $commandController ];
    }

    public function registerCommand($name, $callable) {
        $this->commandRegistry[$name] = $callable;
    }

    public function getController($command) {
        return isset($this->commandControllers[$command]) ? $this->commandControllers[$command] : null;
    }

    public function getCommand($command) {
        return isset($this->commandRegistry[$command]) ? $this->commandRegistry[$command] : null;
    }

    public function getCallable($commandName) {
        $commandController = $this->getController($commandName);

        if ($commandController instanceof CommandController) {
            return [ $commandController, 'run' ];
        }

        $command = $this->getCommand($commandName);
        if ($command === null) {
            throw new \Exception("Command \"$commandName\" not found.");
        }

        return $command;
    }
}
