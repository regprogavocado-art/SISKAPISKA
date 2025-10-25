# Backend Dockerfile - Node.js API сервер
FROM node:18-alpine

# Установка рабочей директории
WORKDIR /app

# Установка системных зависимостей
RUN apk add --no-cache \
    python3 \
    py3-pip \
    build-base \
    postgresql-client

# Копирование package.json
COPY package*.json ./

# Установка зависимостей
RUN npm install --production

# Копирование исходного кода
COPY . .

# Создание директорий для логов
RUN mkdir -p /app/logs

# Открытие порта
EXPOSE 3001

# Настройка health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
  CMD node healthcheck.js || exit 1

# Запуск сервера
CMD ["node", "server.js"]