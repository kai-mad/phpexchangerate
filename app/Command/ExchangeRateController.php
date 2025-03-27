<?php declare(strict_types=1);

namespace App\Command;

use App\Model\ExchangeRate;
use CliExchangeRate\CommandController;
use App\Service\ExchangeRateDotHostApi;

class ExchangeRateController extends CommandController {

    private $params = [];
    protected ExchangeRateDotHostApi $api;
    private string $apiKey;
    public static string $documentationString = 
        "usage: ./exchangerate get source-currency=[ source currency code ]";

    Public function __construct(\CliExchangeRate\App $app) {
        parent::__construct($app);

        $this->api = new ExchangeRateDotHostApi($app);
    }

    public function run($argv) {
    
        $this->loadParams($argv);

        $sourceCurrencyCode = $this->getParam("source");
        if (!isset($sourceCurrencyCode)) {
            $this->getApp()->getOutputHandler()->print("Missing required parameter 'source'");
            $this->getApp()->getOutputHandler()->print($this->documentationString);
            exit;
        }

        // Get 
        $exchangeRate = $this->api->getRecentExchangeRatesForCurrency($sourceCurrencyCode);
        if (!$exchangeRate instanceof ExchangeRate) {
            $this->getApp()->getOutputHandler()->print("ERROR: response could not be formed into ExchangeRate object");
        }
        
        $this->getApp()->getOutputHandler()->out($exchangeRate->getExchangeRateOutputString());
        exit;

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
