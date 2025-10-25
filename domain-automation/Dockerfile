# Domain Automation Service - Интеграция hackerpain/domaining
FROM python:3.11-alpine

WORKDIR /app

# Установка зависимостей
RUN apk add --no-cache \
    gcc \
    musl-dev \
    postgresql-dev \
    curl \
    whois

COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

COPY . .

# Создание директорий для данных
RUN mkdir -p /app/data /app/logs /app/cache

EXPOSE 5002

CMD ["python", "domain_service.py"]