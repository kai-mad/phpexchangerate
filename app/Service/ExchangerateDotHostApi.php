<?php

namespace App\Service;

use ErrorException;
use App\Model\ExchangeRate;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ExchangeRateDotHostApi {

    protected $app;
    public Client $client;
    private string $apiKey;

    Public function __construct($app) {
        $this->app = $app;

        $this->client = new Client([
            'base_uri' => 'https://api.exchangerate.host',
        ]);

        $this->apiKey = $_ENV["EXCHANGERATE.HOST_API_KEY"];
    }

    public function getRecentExchangeRatesForCurrency($sourceCurrencyCode = "USD") {
        $request = new Request('GET',"/live?access_key=" . $this->apiKey . "&source=" . $sourceCurrencyCode);

        try {
            $response = $this->client->send($request);
            
            $statusCode = $response->getStatusCode();
            if ($statusCode != 200) {
                $errorMessage = $this->parseErrorMessageFromStatusCode($statusCode);
                throw new ErrorException($errorMessage);
            }
            
            $responseBody = json_decode($response->getBody(), true);
            if (!$responseBody['success'] === true) {
                throw new ErrorException($responseBody['error']['info']);
            }
            
            return new ExchangeRate(
                $responseBody['quotes'],
                $responseBody['source'],
                $responseBody['timestamp']
            );

        } catch (\Exception $e) {
            $this->app->getOutputHandler()->print("ERROR: " . $e->getMessage());
            exit;
        }
    }

    private function parseErrorMessageFromStatusCode($statusCode) {
        $errors = [
            404 => `User requested a resource which does not exist.`,
            101	=> "User did not supply an access key or supplied an invalid access key.",
            103 =>	"User requested a non-existent API function.",
            104 =>	"User has reached or exceeded his subscription plan's monthly API request allowance.",
            105	=> "The user's current subscription plan does not support the requested API function.",
            106	=> "The user's query did not return any results",
            102	=> "The user's account is not active. User will be prompted to get in touch with Customer Support.",
            201	=> "User entered an invalid Source Currency.",
            202	=> "User entered one or more invalid currency codes.",
            301	=> "User did not specify a date. [historical]",
            302	=> "User entered an invalid date. [historical, convert]",
            401	=> `User entered an invalid "from" property. [convert]`,
            402	=> `User entered an invalid "to" property. [convert]`,
            403	=> `User entered no or an invalid "amount" property. [convert]`,
            501	=> "User did not specify a Time-Frame. [timeframe, convert].",
            502	=> `User entered an invalid "start_date" property. [timeframe, convert].`,
            503	=> `User entered an invalid "end_date" property. [timeframe, convert].`,
            504	=> "User entered an invalid Time-Frame. [timeframe, convert]",
            505	=> "The Time-Frame specified by the user is too long - exceeding 365 days. [timeframe]"
        ];

        if (!empty($errors[$statusCode])) {
            return $errors[$statusCode];
        } else {
            return "Unknown Error";
        }
    }

}
