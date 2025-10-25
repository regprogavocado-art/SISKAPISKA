# Архитектура (обзор)

Сервисы:
- frontend (UI)
- backend (REST, очереди)
- ai-service (генерация блоков)
- content-generator (сборка страниц)
- domain-service (домены и проверки)
- scraper-service (данные/таблицы)
- site-cloner (SeoDor)
- domain-regway (Regway покупка)
- postgres, redis, nginx, prometheus, grafana

Границы и потоки: домены → фильтры → покупка → пост‑настройки → контент → публикация → мониторинг.
