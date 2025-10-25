# СИСКАПИСКА — экспериментальная панель (v1 → v11)

Экспериментальная панель управления, основанная на архитектуре Авогуру 7.3, с полным конвейером доменной фабрики: «дроп → фильтры → покупка на Regway → NS/DNS → ISPmanager → композитный контент → публикация партиями → мониторинг индексации/позиций». Цель — стабильно выводить до 50 доменов/день в топ‑10 Яндекса по РФ.

- Быстрый старт: Docker 2.2+, `./start.sh`
- Документация: см. docs/README.md (оглавление)
- Лицензирование: ядро MIT; коммерческие модули — по ключу (см. License & Activation)

## Архитектура

Сервисы: frontend, backend, ai-service, content-generator, domain-service, scraper-service, site-cloner (SeoDor), domain-regway, postgres, redis, nginx, prometheus, grafana. Потоки: домены → фильтры → покупка → пост‑настройки → контент → публикация → мониторинг.

## ChangeLog (v1.0 → v11.0)

- v1.0 — Базовый стек и оркестрация
  - Docker 2.2; compose профили; сервисы: frontend/backend/ai/content/domain/scraper/site-cloner/postgres/redis/nginx/prometheus/grafana.
  - README, start.sh, базовые конфиги.

- v1.1 — domain‑regway: сбор/фильтры/скоринг (dry‑run)
  - Источники дропов (CSV/JSON/ленты), нормализация.
  - Фильтры: RKN, DNSBL/Spamhaus, Wayback, WHOIS (+ SafeBrowsing/PhishTank опц.).
  - Скоринг Clean/History/Brand, порог по умолчанию 0.75. CLI/REST: find → screen → report.

- v1.2 — Реальная покупка Regway + пост‑настройки
  - Регистрация доменов: checkAvailability → register; транзакционные логи; лимиты/ретраи.
  - NS/DNS (ваши/регистраторские); ISPmanager: сайт/аккаунт; SSL (Let’s Encrypt).

- v2.0 — Kra42 контент: композит против ИИ‑фильтров
  - Сборка T1–T6 (введение, таблицы данных, кейсы, чек‑листы, FAQ, вывод/CTA), вариативные «голоса», шаблоны верстки.
  - Реальные таблицы (электроника/книги/запчасти/питомцы/музыка/типография/апартаменты) + dateModified + источники (nofollow/ugc). Публикация партиями.

- v3.0 — Яндекс индексация и тех‑аудит
  - sitemap (основной+images), robots, canonical, breadcrumbs, hreflang RU.
  - Вебмастер API (пинг, ошибки сканирования). Улучшения скорости (TTFB/LCP), SSR/MPA.

- v4.0 — Поточный режим 10–20 доменов/день
  - Очереди/ретраи, расписание публикаций, анти‑аффилиат различия (UI/юридичка/аналитика/«голоса»/цвета).

- v5.0 — Низкорисковые ссылочные сигналы
  - Каталоги/цитирования/крауд; мониторинг индексации/позиций; корректировки.

- v6.0 — Масштаб 30–40 доменов/день
  - Расширение подниш Kra42 и источников данных; повышенная вариативность контента/версток.

- v7.0 — ML‑скоринг и анти‑«чёрные темы»
  - ML Clean/History/Brand; классификатор «чёрных тем» (Wayback/паттерны); прогноз CTR сниппетов.

- v8.0 — Отчётность и дашборды
  - Вебмастер/позиции/индексация → PDF/CSV/Telegram; Grafana дашборды.

- v9.0 — Оркестрация и устойчивость
  - Очереди задач, ретраи, профили под K8s/Swarm; окружения dev/stage/prod.

- v10.0 — 50 доменов/день
  - Автокоррекция шаблонов/тональности по метрикам; репутационные лимиты/ротации.

- v11.0 — «Супер‑документы» и зонтики без аффилиата
  - Длинные гайды/сравнения/калькуляторы с «живыми» таблицами; аккуратные зонтичные стратегии.

## License & Activation

- Ядро проекта: MIT.
- Коммерческие модули (по ключу):
  - domain‑regway (реальная покупка доменов)
  - Расширенные внешние проверки безопасности (SafeBrowsing/PhishTank и др.)
  - ML‑скоринг доменов/контента
  - Продвинутый контент‑ассемблер (масштаб 50/день)
  - Отчётность (PDF/CSV/Telegram) и дашборды
- Активация: `.env` → `LICENSE_KEY=...`; см. docs/licensing/110-licensing-model.md и 111-activation-guide.md

## Быстрый старт

```bash
# Клонировать и перейти
git clone https://github.com/regprogavocado-art/SISKAPISKA.git
cd SISKAPISKA

# Подготовить .env
cp docs/templates/130-env-example.md .env
# Заполнить ключевые переменные (Regway/ISPmanager/DB/Redis и т.д.)

# Запуск
chmod +x start.sh
./start.sh
```

## Документация

- Оглавление: docs/README.md
- Основные разделы: overview, infra, security, integrations, domain, content, scraping, backend, frontend, devops, ops, licensing, playbooks, roadmap, templates.

## Контакты и вклад

PR приветствуются. Смотрите docs/devops/90-ci-cd.md и docs/devops/91-testing-strategy.md для правил.
