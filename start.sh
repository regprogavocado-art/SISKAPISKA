#!/bin/bash
# SISKAPISKA Quick Start Script
# Быстрый запуск для Docker 2.2+

set -e

echo "🚀 СИСКАПИСКА v1.0 - Экспериментальная панель управления"
echo "📋 Основано на Авогуру 7.3 с интеграцией ИИ"
echo ""

# Проверка Docker версии
DOCKER_VERSION=$(docker --version | grep -oP '\d+\.\d+' | head -1)
if [ "$(echo "$DOCKER_VERSION < 2.2" | bc -l)" -eq 1 ]; then
    echo "❌ Требуется Docker версии 2.2 или выше"
    echo "   Текущая версия: $DOCKER_VERSION"
    exit 1
fi

echo "✅ Docker $DOCKER_VERSION поддерживается"

# Проверка .env файла
if [ ! -f .env ]; then
    echo "📄 Создание .env файла из шаблона..."
    cp .env.example .env
    echo "⚠️  Пожалуйста, отредактируйте .env файл перед продолжением"
    echo "   Особенно важны:"
    echo "   - OPENAI_API_KEY"
    echo "   - POSTGRES_PASSWORD"
    echo "   - JWT_SECRET"
    echo ""
    read -p "Нажмите Enter после редактирования .env файла..."
fi

echo "🏗️  Сборка образов Docker..."
docker compose build --no-cache

echo "🗄️  Создание volumes..."
docker compose up -d postgres redis

echo "⏱️  Ожидание запуска базы данных..."
sleep 10

echo "📊 Запуск остальных сервисов..."
docker compose up -d

echo "🔍 Проверка состояния сервисов..."
docker compose ps

echo ""
echo "🎉 СИСКАПИСКА успешно запущена!"
echo ""
echo "📱 Доступные интерфейсы:"
echo "   🌐 Веб-интерфейс:    http://localhost:8080"
echo "   📡 API:              http://localhost:3000"
echo "   🤖 ИИ модуль:        http://localhost:5000"
echo "   📊 Мониторинг:       http://localhost:9090"
echo "   📈 Grafana:          http://localhost:3001"
echo "   🔄 Site Cloner:      http://localhost/cloner/"
echo ""
echo "👤 Учетные данные по умолчанию:"
echo "   📧 Email: admin@siskapiska.local"
echo "   🔑 Пароль: admin123"
echo "   ⚠️  ОБЯЗАТЕЛЬНО смените пароль после первого входа!"
echo ""
echo "📚 Документация: https://github.com/regprogavocado-art/SISKAPISKA"
echo "🐛 Логи: docker compose logs -f"
echo "🔄 Перезапуск: docker compose restart"
echo "🛑 Остановка: docker compose down"
echo ""
echo "🎯 Основной workflow:"
echo "   1. Настройте API ключи в .env"
echo "   2. Добавьте домены через веб-интерфейс"
echo "   3. Настройте ISPmanager интеграцию"
echo "   4. Включите автоматизацию"
echo ""
echo "✨ Экспериментальные функции:"
echo "   • Автопокупка доменов (GoDaddy/Namecheap)"
echo "   • ИИ генерация контента (OpenAI GPT-4)"
echo "   • Автоматическое развертывание (ISPmanager)"
echo "   • Site Cloner на базе SeoDor"
echo "   • Продвинутый веб-скрапинг"
echo "   • Real-time мониторинг"
echo ""
echo "⚠️  ВНИМАНИЕ: Это экспериментальная версия!"
echo "   Не используйте на продакшн серверах"
echo "   Регулярно создавайте бэкапы"
echo "   Ограничьте лимиты API ключей"
echo ""