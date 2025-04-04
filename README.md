# Interview technical task
## Exchange rate php CLI app
### How to use 
(assuming you are running commands from the repo directory)

1. $`cp .env.example .env` and insert your exchangerate.host API-key into the .env file

2. $`docker compose up cli` to get everything up and running.

- Fetch a list of exchangerates with $`docker compose run --rm cli /var/www/html/exchangerate list source=NOK`

- Convert a value from one currency to another with $`docker compose run --rm cli /var/www/html/exchangerate convert value=100 source=SEK target=EUR`

- To run tests, use $`docker compose run --rm cli ./vendor/bin/phpunit tests`

**NOTE: if API key is exhausted, commands can be run with a mock param. e.g.**

- $`docker compose run --rm cli /var/www/html/exchangerate list source=USD mock=1` 

- $`docker compose run --rm cli /var/www/html/exchangerate convert value=100 source=USD target=NOK mock=1`

### Task details:  
Make a PHP CLI App for fetching currency exchange rates and do conversions in CLI  
- PHP 8.3, should enforce strict types and focus on clean-code practices
- Readonly classes should be utilized to model the response data
- Fetch exchangerates from an API
- Manage dependencies with composer
- Use docker to set up a PHP 8.3 CLI environment, and run the service. Dockerfile & docker-compose.yml. Make sure setup is simple and straightforward.
- Write at least one test, focus on verifying the API data fetching and processing for the tests.
- Push to public repo
