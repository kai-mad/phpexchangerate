<?php declare(strict_types=1);
      
namespace App\Model;

use CliExchangeRate\BaseCollection;
use App\Model\ExchangeRateQuote;

class ExchangeRateQuotesCollection extends BaseCollection {

    public function __construct(ExchangeRateQuote ...$exchangeRateQuotes) {
        $this->values = $exchangeRateQuotes;
    }
    
}
