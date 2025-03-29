<?php declare(strict_types=1);

namespace CliExchangeRate\Tests;

use App\Service\ExchangeRateDotHostApi;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

final class ExchangerateDotHostApiTest extends TestCase {
	public function testApiKeyExists() {
		$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
		$dotenv->load();
		self::assertNotEmpty($_ENV["EXCHANGERATE.HOST_API_KEY"]);
	}

	public function testApiResponseCanCreateExchangeRateObject() {
		$api = new ExchangeRateDotHostApi();
		$expectedExchangeRateObject = $api->getRecentExchangeRatesForCurrency("USD", null, true);
		self::assertInstanceOf("App\Model\ExchangeRate", $expectedExchangeRateObject);
	}

}