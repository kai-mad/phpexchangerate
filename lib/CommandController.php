<?php declare(strict_types=1);

namespace CliExchangeRate;

abstract class CommandController {
    
    protected $app;
    protected $params = [];

    abstract public function run($argv);

    public function __construct(App $app) {
        $this->app = $app;
    }

    protected function getApp() {
        return $this->app;
    }

    protected function loadParams(array $args) {
        foreach ($args as $arg) {
            $pair = explode('=', $arg);
            if (count($pair) == 2) {
                $this->params[$pair[0]] = $pair[1];
            }
        }
    }

    public function hasParam($param) {
        return isset($this->params[$param]);
    }

    public function getParam($param) {
        return $this->hasParam($param) ? $this->params[$param] : null;
    }

}
