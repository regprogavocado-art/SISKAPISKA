# СИСКАПИСКА v1.0

🚀 Экспериментальная панель управления с ИИ интеграцией

## Описание
СИСКАПИСКА - это экспериментальная панель управления, основанная на архитектуре Авогуру 7.3, но представляющая собой отдельное направление развития. Проект интегрирует множество автоматизированных скриптов для:

- 🤖 **Интеграция с ИИ** - OpenAI API, ChatGPT, автоматическая генерация контента
- 🌐 **Автопокупка доменов** - мониторинг, оценка и автоматическая регистрация
- ⚙️ **ISPmanager интеграция** - автоматическое добавление и настройка сайтов
- 📝 **Генерация контента** - SEO-оптимизированный контент для сайтов
- 🔧 **Автоматическое развертывание** - полная автоматизация настройки новых сайтов

## Архитектура

```
СИСКАПИСКА/
├── frontend/          # React.js интерфейс (Авогуру 7.3 база)
├── backend/           # Node.js/Express API
├── ai-integration/    # Модули ИИ (скрипты с GitHub)
├── domain-automation/ # Скрипты автопокупки доменов
├── ispmanager-api/    # ISPmanager интеграция
├── content-generator/ # Генератор контента
├── deployment/        # Скрипты развертывания
└── docker/            # Docker конфигурации (v2.2+)
```

## Быстрый старт с Docker 2.2+

### Требования
- Docker 2.2+
- Docker Compose v2
- 4GB RAM минимум
- 10GB свободного места

### Установка

```bash
# Клонирование репозитория
git clone https://github.com/regprogavocado-art/SISKAPISKA.git
cd SISKAPISKA

# Настройка переменных окружения
cp .env.example .env
# Отредактируйте .env файл

# Запуск с Docker Compose v2
docker compose up -d

# Или с логами
docker compose up
```

### Доступ к панели
- **Web UI**: http://localhost:8080 - Основной интерфейс
- **API Gateway**: http://localhost:3000 - REST API
- **AI Module**: http://localhost:5000 - Модуль ИИ
- **Monitoring**: http://localhost:9090 - Prometheus/Grafana

## Компоненты

### 🖼️ Frontend (Авогуру 7.3 UI)
- React.js 18+ с современным Material-UI
- Адаптивный русскоязычный интерфейс
- Real-time WebSocket мониторинг
- Дашборд с метриками

### 💻 Backend API
- Node.js/Express сервер
- Python Flask модули для ИИ
- PostgreSQL 15+ с оптимизациями
- Redis для кеширования

### 🤖 AI Integration
- **OpenAI GPT-4** для генерации контента
- **Content-Generation-AI-Tool** - SEO-оптимизированный контент
- **Script-Craft** - автоматическая генерация скриптов
- **Python-Automation-with-ChatGPT** - интеллектуальная автоматизация

### 🌐 Domain Automation
- **hackerpain/domaining** - массовая оценка доменов GoDaddy
- **Мониторинг WHOIS** - отслеживание сроков истечения
- **Генератор логотипов** - автоматическое создание логотипов
- **GoDaddy/Namecheap API** - интеграция для покупок

### 🔧 Web Scraping & Automation
- **Autonicgram** - 24/7 автоматизированный скрапинг
- **YellowPage-scraper** - извлечение бизнес-данных
- **Web_Tools** - коллекция скриптов веб-автоматизации

## Конфигурация переменных (.env)

```bash
# Основные настройки
NODE_ENV=production
PORT=3000
FRONTEND_PORT=8080
DOCKER_VERSION=2.2

# База данных
POSTGRES_HOST=siskapiska-postgres
POSTGRES_PORT=5432
POSTGRES_DB=siskapiska
POSTGRES_USER=admin
POSTGRES_PASSWORD=siskapiska_secure_2024

# Redis
REDIS_HOST=siskapiska-redis
REDIS_PORT=6379
REDIS_PASSWORD=redis_password

# OpenAI API
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-4
OPENAI_MAX_TOKENS=2000

# ISPmanager настройки
ISPMANAGER_URL=https://your-ispmanager.com:1500
ISPMANAGER_USER=admin
ISPMANAGER_PASSWORD=your_ispmanager_password
ISPMANAGER_API_VERSION=6

# Domain Providers API
GODADDY_API_KEY=your_godaddy_api_key
GODADDY_API_SECRET=your_godaddy_api_secret
NAMECHEAP_API_USER=your_namecheap_user
NAMECHEAP_API_KEY=your_namecheap_api_key

# Безопасность
JWT_SECRET=siskapiska_jwt_secret_key_2024
ENCRYPTION_KEY=siskapiska_encryption_key_256bit
API_RATE_LIMIT=100

# Мониторинг
PROMETHEUS_PORT=9090
GRAFANA_PORT=3001
LOG_LEVEL=info
```

## Функционал

### 🔄 Полный автоматический workflow:
1. **Мониторинг доменов** - отслеживание освобождающихся/подходящих доменов
2. **Оценка потенциала** - ИИ анализирует SEO потенциал домена
3. **Автопокупка** - автоматическая регистрация подходящих доменов
4. **ISPmanager setup** - автоматическое добавление сайта и настройка DNS
5. **Генерация контента** - ИИ создает полноценный SEO-сайт
6. **Деплой сайта** - автоматическая загрузка и запуск

## Интегрированные скрипты с GitHub

### 📚 Коллекция скриптов:

| Модуль | Источник | Описание | Статус |
|--------|---------|----------|--------|
| AI Content Gen | Mawgaming/Content-Generation-AI-Tool | Генерация SEO контента | ✅ Интегрирован |
| Script Craft | Bhargavisarikonda/Script-Craft | Django API + PostgreSQL | ✅ Интегрирован |
| ChatGPT API | sabrinachowdhuryoshin/Python-Automation | Открытые тексты GPT | ✅ Интегрирован |
| Domain Tools | hackerpain/domaining | GoDaddy оценки + лого | ✅ Интегрирован |
| Web Scraper | BlesslinJerishR/Autonicgram | 24/7 скрапинг | ✅ Интегрирован |
| Data Tools | sushil-rgb/YellowPage-scraper | Поиск бизнес-инфо | ✅ Интегрирован |
| ML Automation | tmrinvee/Script-Automation | Машинное обучение | ✅ Интегрирован |
| Web Deploy | xixu-me/X-WebUI | Автодеплой setup.sh | ✅ Адаптирован |

## Команды Docker

```bash
# Полный перезапуск
docker compose down && docker compose up -d

# Пересборка без кеша
docker compose build --no-cache

# Логи отдельных сервисов
docker compose logs -f frontend
docker compose logs -f backend
docker compose logs -f ai-service

# Очистка всех данных
docker compose down -v
docker system prune -a --volumes

# Мониторинг ресурсов
docker stats
```

## Мониторинг и логи

### 📊 Метрики
- **Prometheus**: сбор метрик со всех компонентов
- **Grafana**: визуальные дашборды
- **Логи**: централизованное логирование через ELK Stack

### Уведомления
- Telegram bot уведомления
- Email отчеты
- Slack интеграция

## Отличия от Авогуру

| Характеристика | Авогуру 7.3 | СИСКАПИСКА v1.0 |
|------------|------------|----------------|
| 🚀 Назначение | Продакшн | Эксперимент/Тест |
| 🤖 ИИ интеграция | Ограниченная | Полная OpenAI интеграция |
| 🌐 Автопокупка | Мануальная | Полная автоматизация |
| ⚙️ ISPmanager | Мануально | API автоматизация |
| 📝 Контент | Статичный | Динамическая ИИ генерация |
| 📊 Мониторинг | Основной | Продвинутые метрики |
| 🔧 Развертывание | Docker базовый | Docker 2.2+ оптимизация |

## Роадмап

### v1.0 (Текущая)
- [x] Основная структура проекта
- [x] Docker 2.2+ конфигурация
- [x] Интеграция скриптов с GitHub
- [ ] Полное тестирование

### v1.1 (Ближайшее будущее)
- [ ] Массовая обработка доменов
- [ ] Адвансед AI фильтры
- [ ] Интеграция с большим количеством регистраторов
- [ ] Machine Learning оптимизация

### v2.0 (Долгосрочно)
- [ ] Мобильное приложение
- [ ] Блокчейн интеграция
- [ ] AI предсказания трендов
- [ ] Мультиязычная поддержка

## Безопасность

⚠️ **Внимание**: Это экспериментальный проект!

- Не используйте на продакшн серверах
- Всегда используйте надежные пароли
- Ограничьте лимиты API ключей
- Регулярно создавайте бэкапы

---

✨ **СИСКАПИСКА** - экспериментальный форк концепций Авогуру 7.3 для исследования новых возможностей автоматизации ✨