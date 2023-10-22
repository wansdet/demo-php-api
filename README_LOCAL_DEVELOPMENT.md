# Local Development

## Symfony Binary Docker Integration
If you are using Docker Desktop and the local Symfony server, you can utilize the Symfony binary docker integration.
See https://symfony.com/doc/current/setup/docker.html

This enables you to create docker containers for services like Redis, RabbitMQ, MySQL, etc. and run them locally.

### Preparation
1. Configure docker-compose.yaml to include the services you need.
2. See below for configuration of each service.
3. See README.md for instructions on how to run the services.

### Mailer 
The application is configured for sending mails asynchronously using the messenger component.
If you have configured your mailer to disable delivery i.e.

```dotenv
# .env.dev.local
MAILER_DSN=null://null
```

then you may want to use a mail catcher to check the emails sent by the application.

In docker.compose.yaml add the following service:
```yaml
# docker.compose.yaml
  mailcatcher:
    image: schickling/mailcatcher
    ports: ["1025", "1080"]
```
Open web management interface using:
```sh
symfony open:local:webmail
```

### Redis
The application can be configured to use Redis for caching.

To use Redis for caching, add Redis URL to .env.dev.local:
```dotenv
# .env.dev.local
REDIS_URL=redis://redis:6379
```
In config/packages/cache.yaml update the configuration to use Redis:
```yaml
# config/packages/cache.yaml
framework:
    cache:
        app: cache.adapter.redis
        default_redis_provider: '%env(resolve:REDIS_URL)%'
```
In docker.compose.yaml add the following service:
```yaml
# docker.compose.yaml
  redis:
    image: redis:alpine
    ports: ["6379"]
```

### RabbitMQ
The application can be configured to use RabbitMQ for asynchronous messaging.

In your .env.dev.local file you can configure the messenger to use RabbitMQ:
```dotenv
# .env.dev.local
MESSENGER_TRANSPORT_DSN=amqp://guest:guest@localhost:5672/%2F/messages
```
In docker.compose.yaml add the following service:
```yaml
# docker.compose.yaml
rabbitmq:
    image: rabbitmq:3.12-management
    ports:
        - '5672:5672'
        - '15672:15672'
```
Open web management interface using:
```sh
symfony open:local:rabbitmq
```



