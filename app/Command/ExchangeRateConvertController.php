<?php declare(strict_types=1);

namespace App\Command;

use App\Model\ExchangeRateQuote;
use CliExchangeRate\App;
use App\Model\ExchangeRate;
use CliExchangeRate\CommandController;
use App\Service\ExchangeRateDotHostApi;

class ExchangeRateConvertController extends CommandController {

    protected ExchangeRateDotHostApi $api;

    public static string $documentationString = 
        "./exchangerate convert value=[ currency amount ] source=[ source currency code ] target=[ source currency code ]";

    Public function __construct(App $app) {
        parent::__construct($app);

        $this->api = new ExchangeRateDotHostApi();
    }

    public function run($argv) {
    
        $this->loadParams($argv);

        $value = $this->getParam("value");
        if (!isset($value)) {
            $this->getApp()->getOutputHandler()->print("Missing required parameter 'value'");
            $this->getApp()->getOutputHandler()->print(ExchangeRateConvertController::$documentationString);
            exit;
        }
        if (!is_numeric($value)) {
            $this->getApp()->getOutputHandler()->print("Parameter 'value' is not numeric.");
            $this->getApp()->getOutputHandler()->print(ExchangeRateConvertController::$documentationString);
            exit;
        }
        $value = (float) $value;

        $sourceCurrencyCode = $this->getParam("source");
        if (!isset($sourceCurrencyCode)) {
            $this->getApp()->getOutputHandler()->print("Missing required parameter 'source'");
            $this->getApp()->getOutputHandler()->print(ExchangeRateConvertController::$documentationString);
            exit;
        }

        $targetCurrencyCode = $this->getParam("target");
        if (!isset($targetCurrencyCode)) {
            $this->getApp()->getOutputHandler()->print("Missing required parameter 'target'");
            $this->getApp()->getOutputHandler()->print(ExchangeRateConvertController::$documentationString);
            exit;
        }

        $shouldMock = $this->hasParam("mock");

        $exchangeRate = $this->api->getRecentExchangeRatesForCurrency($sourceCurrencyCode, $targetCurrencyCode, $shouldMock);
        if (!$exchangeRate instanceof ExchangeRate) {
            if ($exchangeRate instanceof string) {
                $this->getApp()->getOutputHandler()->print($exchangeRate);
            } else {
                $this->getApp()->getOutputHandler()->print("ERROR: response could not be formed into ExchangeRate object");
            }
            exit;
        }

        $quotes = $exchangeRate->quotes->getArrayCopy();
        

        $keys = array_column($quotes, 'combinedCurrencyCode');
        $index = array_search("{$sourceCurrencyCode}{$targetCurrencyCode}", $keys);
        $quote = $quotes[$index];

        if ($quote instanceof ExchangeRateQuote) {
          $this->getApp()->getOutputHandler()->print(
            "{$value} {$sourceCurrencyCode} is worth {$quote->getExchangedValue($value)} {$targetCurrencyCode} given the exchange-rate multiplier of {$quote->exchangeRateMultiplier}"
          );
        }
        
        exit;
    }

}
