# Content Generator Service - Интеграция скриптов с GitHub
FROM python:3.11-alpine

WORKDIR /app

# Установка системных пакетов
RUN apk add --no-cache \
    gcc \
    musl-dev \
    postgresql-dev \
    libffi-dev \
    chromium \
    chromium-chromedriver

# Копирование зависимостей
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Копирование исходного кода
COPY . .

# Создание директорий
RUN mkdir -p /app/templates /app/logs /app/generated

EXPOSE 5001

CMD ["python", "content_service.py"]