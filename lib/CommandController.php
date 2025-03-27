<?php declare(strict_types=1);

namespace CliExchangeRate;

abstract class CommandController {
    
    protected $app;

    abstract public function run($argv);

    public function __construct(App $app) {
        $this->app = $app;
    }

    protected function getApp() {
        return $this->app;
    }

}
