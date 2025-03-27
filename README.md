# Interview technical task
## Exchange rate php CLI app
How to use (assuming you are in repo directory):

1. $`cp .env.example .env` and insert your exchangerate.host API-key into the .env file

2. $`docker compose up cli`

3. After the service is up and running, fetch exchangerates with $`docker compose run cli /var/www/html/exchangerate get source=NOK`

4. To run tests, use $`docker compose run cli ./vendor/bin/phpunit tests`
