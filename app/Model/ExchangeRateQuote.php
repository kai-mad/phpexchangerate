<?php declare(strict_types=1);

namespace App\Model;
readonly class ExchangeRateQuote {

    public string $sourceCurrencyCode;
    public string $targetCurrencyCode;
    public string $exchangeRateHumanReadableString;
    public bool $validCurrencyCodeFormat;

    public function __construct(
        public string $combinedCurrencyCode,
        public float $exchangeRateMultiplier
    ) {
        $this->validCurrencyCodeFormat = strlen($combinedCurrencyCode) === 6;
        if ($this->validCurrencyCodeFormat) {
            $this->sourceCurrencyCode = substr($combinedCurrencyCode, 0, 3);
            $this->targetCurrencyCode = substr($combinedCurrencyCode, 3, 3);
        }
        
        $this->exchangeRateHumanReadableString = "{$this->sourceCurrencyCode} -> {$this->targetCurrencyCode} = {$this->exchangeRateMultiplier}";
    }

    public function getExchangedValue(float $value) {
        return $value * $this->exchangeRateMultiplier;
    }

}

/* {
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
