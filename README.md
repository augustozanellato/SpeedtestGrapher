# SpeedtestGrapher

A [speedtest](https://speedtest.net) results grapher made using Docker and Chart.js during some boring days of lockdown.

## Configuration

1. Copy `db.config.sample` to `db.config` and replace the contents with some appropriate values.
2. Open `docker-compose.yml` and edit the following
    | Parameter             | Description                                                                                     |
    |:---------------------:| ----------------------------------------------------------------------------------------------- |
    | UID                   | UID of the user that should own the files created inside the containers. (Output of `id -u`)    |
    | GID                   | GID of the user that should own the files created inside the containers. (Output of `id -u`)    |
    | TZ                    | Your timezone (eg. Europe/Rome)                                                                 |
    | ports                 | The port on your machine where you want the service to be exposed in the form external:internal |
    | TEST_INTERVAL_MINUTES | The interval at which speedtests should run                                                     |

## Running

1. Run `docker-compose pull` in order to pull the required dependencies. (This could take a while, but it's required only on the first run)
2. Run `docker-compose build` in order to build the speedtest runner image.(This could also take a while, but it's required only on the first run)
3. Run `docker-compose up -d` in order to finally start the service. (Omit `-d` if you want to leave `docker-compose` running in foreground in order to see logs in realtime)
4. Connect to <http://127.0.0.1:8080> (or to the port you defined in `docker-compose.yml`) and you should see the results of the first test after a few seconds
