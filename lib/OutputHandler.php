<?php

namespace CliExchangeRate;

class OutputHandler {

    public function out($message) {
        echo $message;
    }

    public function newline() {
        $this->out("\n");
    }

    public function print($message) {
        $this->out($message);
        $this->newline();
    }
}
