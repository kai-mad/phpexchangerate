<?php declare(strict_types=1);

namespace App\Service;

use ErrorException;
use App\Model\ExchangeRate;
use App\Model\ExchangeRateQuote;
use App\Model\ExchangeRateQuotesCollection;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ExchangeRateDotHostApi {

    public Client $client;
    private string $apiKey;

    Public function __construct() {

        $this->client = new Client([
            'base_uri' => 'https://api.exchangerate.host',
        ]);

        $this->apiKey = $_ENV["EXCHANGERATE.HOST_API_KEY"];
    }

    public function getRecentExchangeRatesForCurrency($sourceCurrencyCode = "USD", $targetCurrencyCode = null, $shouldMock = false) {
        $request = new Request('GET',"/live?access_key={$this->apiKey}&source={$sourceCurrencyCode}" . (!empty($targetCurrencyCode) ? "&currencies={$targetCurrencyCode}" : ""));

        $mockResponse = '{"success":true,"terms":"https:\/\/currencylayer.com\/terms","privacy":"https:\/\/currencylayer.com\/privacy","timestamp":1743009363,"source":"USD","quotes":{"USDAED":3.672955,"USDAFN":72.000129,"USDALL":91.249833,"USDAMD":391.802273,"USDANG":1.803238,"USDAOA":914.499688,"USDARS":1071.419745,"USDAUD":1.587255,"USDAWG":1.8,"USDAZN":1.699145,"USDBAM":1.813251,"USDBBD":2.020276,"USDBDT":121.572572,"USDBGN":1.813621,"USDBHD":0.376949,"USDBIF":2928,"USDBMD":1,"USDBND":1.338661,"USDBOB":6.913528,"USDBRL":5.734398,"USDBSD":0.995,"USDBTC":1.1542839e-5,"USDBTN":85.716405,"USDBWP":13.697195,"USDBYN":3.274477,"USDBYR":19600,"USDBZD":2.0098,"USDCAD":1.42708,"USDCDF":2870.49797,"USDCHF":0.88428,"USDCLF":0.024069,"USDCLP":923.598342,"USDCNY":7.2574,"USDCNH":7.27823,"USDCOP":4133.23,"USDCRC":499.070559,"USDCUC":1,"USDCUP":26.5,"USDCVE":102.603241,"USDCZK":23.066987,"USDDJF":177.71987,"USDDKK":6.92126,"USDDOP":63.303045,"USDDZD":133.830179,"USDEGP":50.5531,"USDERN":15,"USDETB":129.202559,"USDEUR":0.927725,"USDFJD":2.296801,"USDFKP":0.772391,"USDGBP":0.775705,"USDGEL":2.769922,"USDGGP":0.772391,"USDGHS":15.494452,"USDGIP":0.772391,"USDGMD":71.527064,"USDGNF":8655.000296,"USDGTQ":7.714523,"USDGYD":209.335206,"USDHKD":7.776235,"USDHNL":25.697242,"USDHRK":6.984953,"USDHTG":131.019873,"USDHUF":371.374497,"USDIDR":16615.8,"USDILS":3.68967,"USDIMP":0.772391,"USDINR":85.704012,"USDIQD":1310,"USDIRR":42100.000247,"USDISK":132.740025,"USDJEP":0.772391,"USDJMD":157.053258,"USDJOD":0.708967,"USDJPY":150.707501,"USDKES":129.500406,"USDKGS":86.456599,"USDKHR":4015.000406,"USDKMF":456.498567,"USDKPW":900.000357,"USDKRW":1467.920105,"USDKWD":0.30835,"USDKYD":0.833855,"USDKZT":500.679112,"USDLAK":21660.999736,"USDLBP":89600.00018,"USDLKR":296.482063,"USDLRD":199.55015,"USDLSL":18.230014,"USDLTL":2.95274,"USDLVL":0.60489,"USDLYD":4.825008,"USDMAD":9.619502,"USDMDL":18.070563,"USDMGA":4659.999632,"USDMKD":57.052379,"USDMMK":2099.672696,"USDMNT":3483.014385,"USDMOP":8.01387,"USDMRU":39.815042,"USDMUR":45.779735,"USDMVR":15.410247,"USDMWK":1735.99978,"USDMXN":20.092598,"USDMYR":4.429497,"USDMZN":63.90971,"USDNAD":18.230287,"USDNGN":1534.969807,"USDNIO":36.750282,"USDNOK":10.532095,"USDNPR":137.146248,"USDNZD":1.74324,"USDOMR":0.384961,"USDPAB":1.000542,"USDPEN":3.725006,"USDPGK":4.01375,"USDPHP":57.719499,"USDPKR":280.301923,"USDPLN":3.8832,"USDPYG":8007.491088,"USDQAR":3.64075,"USDRON":4.615501,"USDRSD":108.678175,"USDRUB":84.079683,"USDRWF":1415.5,"USDSAR":3.751326,"USDSBD":8.421986,"USDSCR":14.720082,"USDSDG":600.497294,"USDSEK":10.035355,"USDSGD":1.339455,"USDSHP":0.785843,"USDSLE":22.797439,"USDSLL":20969.501083,"USDSOS":571.501987,"USDSRD":36.3545,"USDSTD":20697.981008,"USDSVC":8.754746,"USDSYP":13001.918649,"USDSZL":18.250044,"USDTHB":33.965046,"USDTJS":10.911316,"USDTMT":3.51,"USDTND":3.104996,"USDTOP":2.342101,"USDTRY":37.998597,"USDTTD":6.791179,"USDTWD":33.12101,"USDTZS":2644.999633,"USDUAH":41.583512,"USDUGX":3667.666406,"USDUYU":42.155913,"USDUZS":12944.999844,"USDVES":68.613555,"USDVND":25570,"USDVUV":123.068264,"USDWST":2.826478,"USDXAF":608.147485,"USDXAG":0.02969,"USDXAU":0.000332,"USDXCD":2.70255,"USDXDR":0.755808,"USDXOF":606.999369,"USDXPF":111.050214,"USDYER":246.025021,"USDZAR":18.25592,"USDZMK":9001.19346,"USDZMW":28.791285,"USDZWL":321.999592}}';

        try {
            if (!$shouldMock) {
                $response = $this->client->send($request);
            
                $statusCode = $response->getStatusCode();
                if ($statusCode != 200) {
                    $errorMessage = $this->parseErrorMessageFromStatusCode($statusCode);
                    throw new ErrorException($errorMessage);
                }
                $responseBody = json_decode($response->getBody()->getContents(), true);
            } else {
                $responseBody = json_decode($mockResponse, true);
            }
                
            if (!$responseBody['success'] === true) {
                throw new ErrorException($responseBody['error']['info']);
            }
            
            $exchangeRateQuotes = new ExchangeRateQuotesCollection();
            foreach($responseBody['quotes'] as $combinedCurrencyCode => $exchangeRateMultiplier) {
                $quote = new ExchangeRateQuote($combinedCurrencyCode, $exchangeRateMultiplier);
                $exchangeRateQuotes->append($quote);
            }
            
            return new ExchangeRate(
                $exchangeRateQuotes,
                $responseBody['source'],
                $responseBody['timestamp']
            );

        } catch (ErrorException $e) {
            return $e->getMessage();
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
