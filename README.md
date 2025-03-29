# Interview technical task
## Exchange rate php CLI app
How to use (assuming you are in repo directory):

1. $`cp .env.example .env` and insert your exchangerate.host API-key into the .env file

2. $`docker compose up cli` to get everything up and running.

 
- Fetch a list of exchangerates with $`docker compose run --rm cli /var/www/html/exchangerate list source=NOK`

- Convert a value from one currency to another with $`docker compose run --rm cli /var/www/html/exchangerate convert value=100 source=SEK target=EUR`

- To run tests, use $`docker compose run --rm cli ./vendor/bin/phpunit tests`