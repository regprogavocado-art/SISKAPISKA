# Docker оркестрация

- Требования: Docker 2.2+, Compose v2.
- Профили: prod/stage/dev.
- Сети: reverse proxy (nginx), внутренние сети сервисов.
- Volumes: postgres_data, redis_data, logs, configs.
- Команды: docker compose build; docker compose up -d; docker compose down -v.
