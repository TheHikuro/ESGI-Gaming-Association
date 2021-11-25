.PHONY: start stop

start:
	docker-compose --env-file=".env.local" up -d

stop:
	docker-compose stop

restart: stop start
