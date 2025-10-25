# Web Scraping Service - Интеграция всех скрапинг скриптов
FROM python:3.11-slim

WORKDIR /app

# Установка Chromium для Selenium
RUN apt-get update && apt-get install -y \
    wget \
    curl \
    unzip \
    chromium \
    chromium-driver \
    postgresql-client \
    && rm -rf /var/lib/apt/lists/*

# Копирование и установка зависимостей
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

COPY . .

# Настройка Chromium для headless режима
ENV CHROME_BIN=/usr/bin/chromium
ENV CHROME_DRIVER=/usr/bin/chromedriver

RUN mkdir -p /app/data /app/logs

EXPOSE 5003

CMD ["python", "scraper_service.py"]