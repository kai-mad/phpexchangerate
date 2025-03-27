<?php

namespace App\Model;
readonly class ExchangeRate {

    public function __construct(
        public array $quotes,
        public string $source,
        public int $timeStamp,
    ) {}

    public function getExchangeRateOutputString() {
      $quotesCopy = $this->quotes;
      $outputString = "";
      array_walk(
          $quotesCopy, 
          function ($item, $key) use (&$outputString) {
              $outputString .= $key ." = " . $item . "\n";  
          }
      );
      return $outputString;
    }

}

/* {
  "success": true,
  "terms": "https://exchangerate.host/terms",
  "privacy": "https://exchangerate.host/privacy",
  "timestamp": 1430401802,
  "source": "USD",
  "quotes": {
      "USDAED": 3.672982,
      "USDAFN": 57.8936,
      "USDALL": 126.1652,
      "USDAMD": 475.306,
      "USDANG": 1.78952,
      "USDAOA": 109.216875,
      "USDARS": 8.901966,
      "USDAUD": 1.269072,
      "USDAWG": 1.792375,
      "USDAZN": 1.04945,
      "USDBAM": 1.757305,
  [...]
  }
} */
