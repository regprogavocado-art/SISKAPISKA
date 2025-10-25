# Frontend Dockerfile - Основан на Авогуру 7.3 UI
FROM node:18-alpine

# Установка рабочей директории
WORKDIR /app

# Копирование package.json и package-lock.json
COPY package*.json ./

# Установка зависимостей
RUN npm install --production

# Копирование исходного кода
COPY . .

# Сборка проекта
RUN npm run build

# Открытие порта
EXPOSE 3000

# Создание пользователя для безопасности
RUN addgroup -g 1001 -S nodejs
RUN adduser -S nextjs -u 1001
USER nextjs

# Запуск сервера
CMD ["npm", "start"]