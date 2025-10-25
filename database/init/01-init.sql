-- Инициализация базы данных СИСКАПИСКА

CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица доменов
CREATE TABLE IF NOT EXISTS domains (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    domain_name VARCHAR(255) UNIQUE NOT NULL,
    registrar VARCHAR(50),
    purchase_date TIMESTAMP,
    expiry_date TIMESTAMP,
    auto_renew BOOLEAN DEFAULT false,
    status VARCHAR(20) DEFAULT 'pending',
    godaddy_valuation DECIMAL(10,2),
    seo_score INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица сайтов
CREATE TABLE IF NOT EXISTS websites (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    domain_id UUID REFERENCES domains(id) ON DELETE CASCADE,
    site_name VARCHAR(255),
    ispmanager_id VARCHAR(100),
    template_used VARCHAR(100),
    content_generated BOOLEAN DEFAULT false,
    ai_content_type VARCHAR(50),
    deployment_status VARCHAR(20) DEFAULT 'pending',
    ssl_enabled BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица генерируемого контента
CREATE TABLE IF NOT EXISTS generated_content (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    website_id UUID REFERENCES websites(id) ON DELETE CASCADE,
    content_type VARCHAR(50) NOT NULL, -- 'page', 'blog', 'seo_text', 'meta'
    title TEXT,
    content TEXT,
    meta_description TEXT,
    meta_keywords TEXT,
    ai_prompt TEXT,
    openai_model VARCHAR(50),
    word_count INTEGER DEFAULT 0,
    seo_optimized BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица клонированных сайтов (SeoDor интеграция)
CREATE TABLE IF NOT EXISTS cloned_sites (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    source_url TEXT NOT NULL,
    target_directory TEXT NOT NULL,
    pages_cloned INTEGER DEFAULT 0,
    resources_downloaded INTEGER DEFAULT 0,
    total_size BIGINT DEFAULT 0,
    clone_status VARCHAR(20) DEFAULT 'pending',
    clone_started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    clone_completed_at TIMESTAMP,
    error_message TEXT
);

-- Таблица задач автоматизации
CREATE TABLE IF NOT EXISTS automation_tasks (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    task_type VARCHAR(50) NOT NULL,
    task_data JSONB,
    status VARCHAR(20) DEFAULT 'pending',
    priority INTEGER DEFAULT 5,
    scheduled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    started_at TIMESTAMP,
    completed_at TIMESTAMP,
    error_message TEXT,
    created_by UUID REFERENCES users(id)
);

-- Индексы для оптимизации
CREATE INDEX IF NOT EXISTS idx_domains_status ON domains(status);
CREATE INDEX IF NOT EXISTS idx_domains_expiry ON domains(expiry_date);
CREATE INDEX IF NOT EXISTS idx_websites_domain ON websites(domain_id);
CREATE INDEX IF NOT EXISTS idx_automation_tasks_status ON automation_tasks(status);
CREATE INDEX IF NOT EXISTS idx_automation_tasks_type ON automation_tasks(task_type);
CREATE INDEX IF NOT EXISTS idx_cloned_sites_status ON cloned_sites(clone_status);

-- Создание администратора по умолчанию
-- Пароль: admin123 (смените после установки!)
INSERT INTO users (username, email, password_hash, role) 
VALUES (
    'admin', 
    'admin@siskapiska.local',
    '$2a$10$XvL5PtQ9ZG.w1LD8rqG4IuJH7.5PrqOhvQs5wGWqAz.vE2HvzE6iS', -- admin123
    'admin'
) ON CONFLICT (username) DO NOTHING;