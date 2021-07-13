# Temperature finder app

## 1. Running local environment
### 1.1 Create .env file in root directory
    WEB_PORT=4000
    DB_PORT=4001
    DB_PASSWORD=temperature_finder
    DB_USERNAME=temperature_finder
### 1.2 Run commands
    docker-compose build 
    docker-compose up -d
    docker-compose run temperature-finder cp .env.example .env
    docker-compose run temperature-finder php artisan key:generate
    docker-compose run temperature-finder php artisan migrate
### 1.3 Setup API keys in application .env
    OPENWEATHERMAP_APIKEY=
    WEATHERAPI_APIKEY=

## 2. Registering new weather service
1. Create an implementation of `App\Service\Weather\WeatherService` interface
2. Register it in `/application/config/weather.php`

## 2. Registering new temperature format
1. Create an implementation of `App\Service\Temperature\Converter\TemperatureConverter` interface
2. Register it in `/application/config/temperatureformat.php`

## 3. Deploying on heroku
    heroku container:push web -a temperature-finder
    heroku container:release web -a temperature-finder

## 4. Running tests
    docker-compose run temperature-finder cp .env.testing.example .env.testing
    docker-compose run temperature-finder php artisan key:generate --env=testing
    docker-compose run temperature-finder php artisan test --env=testing