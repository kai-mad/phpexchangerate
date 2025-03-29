<?php declare(strict_types=1);

namespace App\Command;

use CliExchangeRate\App;
use App\Model\ExchangeRate;
use CliExchangeRate\CommandController;
use App\Service\ExchangeRateDotHostApi;

class ExchangeRateListController extends CommandController {

    protected ExchangeRateDotHostApi $api;
    private string $apiKey;
    public static string $documentationString = 
        "./exchangerate list source=[ source currency code ]";

    Public function __construct(App $app) {
        parent::__construct($app);

        $this->api = new ExchangeRateDotHostApi();
    }

    public function run($argv) {
    
        $this->loadParams($argv);

        $sourceCurrencyCode = $this->getParam("source");
        if (!isset($sourceCurrencyCode)) {
            $this->getApp()->getOutputHandler()->print("Missing required parameter 'source'");
            $this->getApp()->getOutputHandler()->print(ExchangeRateListController::$documentationString);
            exit;
        }

        $shouldMock = $this->getParam("mock") == true;

        $exchangeRate = $this->api->getRecentExchangeRatesForCurrency($sourceCurrencyCode, null, $shouldMock);
        if (!$exchangeRate instanceof ExchangeRate) {
            if ($exchangeRate instanceof string) {
                $this->getApp()->getOutputHandler()->print($exchangeRate);
            } else {
                $this->getApp()->getOutputHandler()->print("ERROR: response could not be formed into ExchangeRate object" . var_dump($exchangeRate));

            }
            exit;
        }
        
        $this->getApp()->getOutputHandler()->out($exchangeRate->getExchangeRateOutputString());
        exit;

    }

}
