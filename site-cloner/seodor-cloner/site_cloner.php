<?php
/**
 * SISKAPISKA Site Cloner v1.0
 * Основан на SeoDor siteCloner с улучшениями для автоматизации
 * Интегрирован с СИСКАПИСКА панелью управления
 */

class SiteCloner {
    private $baseUrl;
    private $targetPath;
    private $maxPages;
    private $userAgent;
    private $timeout;
    private $logFile;
    
    public function __construct($config = []) {
        $this->baseUrl = $config['base_url'] ?? '';
        $this->targetPath = $config['target_path'] ?? './cloned_sites/';
        $this->maxPages = $config['max_pages'] ?? 100;
        $this->userAgent = $config['user_agent'] ?? 'SISKAPISKA/1.0 (SeoDor-based)';
        $this->timeout = $config['timeout'] ?? 30;
        $this->logFile = $config['log_file'] ?? './logs/site_cloner.log';
        
        // Создание необходимых директорий
        if (!file_exists($this->targetPath)) {
            mkdir($this->targetPath, 0755, true);
        }
        if (!file_exists(dirname($this->logFile))) {
            mkdir(dirname($this->logFile), 0755, true);
        }
    }
    
    /**
     * Клонирование сайта (основано на SeoDor логике)
     */
    public function cloneSite($url, $siteName = null) {
        try {
            $this->log("Started cloning: {$url}");
            
            if (empty($siteName)) {
                $siteName = parse_url($url, PHP_URL_HOST);
            }
            
            $siteDir = $this->targetPath . $siteName . '/';
            if (!file_exists($siteDir)) {
                mkdir($siteDir, 0755, true);
            }
            
            // Получение главной страницы
            $mainContent = $this->fetchPage($url);
            if ($mainContent) {
                file_put_contents($siteDir . 'index.html', $mainContent);
                $this->log("Main page cloned for {$siteName}");
                
                // Извлечение всех ссылок
                $links = $this->extractLinks($mainContent, $url);
                $this->log("Found " . count($links) . " links on {$siteName}");
                
                // Клонирование связанных страниц
                $this->clonePages($links, $siteDir, $url);
                
                // Скачивание ресурсов (CSS, JS, изображения)
                $this->downloadResources($mainContent, $siteDir, $url);
                
                $this->log("Site cloning completed: {$siteName}");
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            $this->log("Error cloning site {$url}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Получение страницы (адаптировано из SeoDor)
     */
    private function fetchPage($url) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_USERAGENT => $this->userAgent,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Connection: keep-alive',
                'Cache-Control: no-cache'
            ],
        ]);
        
        $content = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $content) {
            return $content;
        }
        
        return false;
    }
    
    /**
     * Извлечение ссылок со страницы
     */
    private function extractLinks($content, $baseUrl) {
        $links = [];
        preg_match_all('/<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\1/i', $content, $matches);
        
        foreach ($matches[2] as $link) {
            $fullLink = $this->makeAbsoluteUrl($link, $baseUrl);
            if ($this->isValidLink($fullLink, $baseUrl)) {
                $links[] = $fullLink;
            }
        }
        
        return array_unique($links);
    }
    
    /**
     * Преобразование относительной ссылки в абсолютную
     */
    private function makeAbsoluteUrl($link, $baseUrl) {
        if (filter_var($link, FILTER_VALIDATE_URL)) {
            return $link;
        }
        
        $parsedBase = parse_url($baseUrl);
        $baseHost = $parsedBase['scheme'] . '://' . $parsedBase['host'];
        
        if (strpos($link, '/') === 0) {
            return $baseHost . $link;
        }
        
        return rtrim($baseUrl, '/') . '/' . ltrim($link, '/');
    }
    
    /**
     * Проверка валидности ссылки
     */
    private function isValidLink($link, $baseUrl) {
        $baseHost = parse_url($baseUrl, PHP_URL_HOST);
        $linkHost = parse_url($link, PHP_URL_HOST);
        
        // Клонируем только ссылки с того же домена
        return $linkHost === $baseHost && !preg_match('/\.(pdf|doc|docx|zip|rar|exe)$/i', $link);
    }
    
    /**
     * Клонирование найденных страниц
     */
    private function clonePages($links, $siteDir, $baseUrl) {
        $count = 0;
        foreach ($links as $link) {
            if ($count >= $this->maxPages) break;
            
            $content = $this->fetchPage($link);
            if ($content) {
                $filename = $this->generateFilename($link);
                file_put_contents($siteDir . $filename, $content);
                $count++;
                
                // Оптимизация нагрузки на сервер
                usleep(500000); // 0.5 секунды задержки
            }
        }
        
        $this->log("Cloned {$count} pages");
    }
    
    /**
     * Генерация имени файла из URL
     */
    private function generateFilename($url) {
        $path = parse_url($url, PHP_URL_PATH);
        if (empty($path) || $path === '/') {
            return 'index.html';
        }
        
        $filename = basename($path);
        if (pathinfo($filename, PATHINFO_EXTENSION) === '') {
            $filename .= '.html';
        }
        
        return $filename;
    }
    
    /**
     * Скачивание ресурсов (CSS, JS, изображения)
     */
    private function downloadResources($content, $siteDir, $baseUrl) {
        // Поиск CSS файлов
        preg_match_all('/<link[^>]*href=["\']([^"\']*)["\']/i', $content, $cssMatches);
        
        // Поиск JS файлов
        preg_match_all('/<script[^>]*src=["\']([^"\']*)["\']/i', $content, $jsMatches);
        
        // Поиск изображений
        preg_match_all('/<img[^>]*src=["\']([^"\']*)["\']/i', $content, $imgMatches);
        
        $resources = array_merge(
            $cssMatches[1] ?? [],
            $jsMatches[1] ?? [],
            $imgMatches[1] ?? []
        );
        
        foreach ($resources as $resource) {
            $this->downloadResource($resource, $siteDir, $baseUrl);
        }
    }
    
    /**
     * Скачивание отдельного ресурса
     */
    private function downloadResource($resourceUrl, $siteDir, $baseUrl) {
        try {
            $absoluteUrl = $this->makeAbsoluteUrl($resourceUrl, $baseUrl);
            $resourceContent = $this->fetchPage($absoluteUrl);
            
            if ($resourceContent) {
                $filename = basename(parse_url($resourceUrl, PHP_URL_PATH));
                $resourceDir = dirname($resourceUrl);
                
                if ($resourceDir !== '.') {
                    $fullDir = $siteDir . ltrim($resourceDir, '/');
                    if (!file_exists($fullDir)) {
                        mkdir($fullDir, 0755, true);
                    }
                }
                
                $fullPath = $siteDir . ltrim($resourceUrl, '/');
                file_put_contents($fullPath, $resourceContent);
            }
        } catch (Exception $e) {
            $this->log("Failed to download resource {$resourceUrl}: " . $e->getMessage());
        }
    }
    
    /**
     * Логирование
     */
    private function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$message}\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND | LOCK_EX);
        echo $logMessage;
    }
    
    /**
     * Получение статистики клонирования
     */
    public function getClonedSites() {
        $sites = [];
        $dirs = glob($this->targetPath . '*', GLOB_ONLYDIR);
        
        foreach ($dirs as $dir) {
            $siteName = basename($dir);
            $files = glob($dir . '/*');
            $sites[] = [
                'name' => $siteName,
                'path' => $dir,
                'files_count' => count($files),
                'created_at' => filemtime($dir),
                'size' => $this->getDirectorySize($dir)
            ];
        }
        
        return $sites;
    }
    
    /**
     * Получение размера директории
     */
    private function getDirectorySize($directory) {
        $size = 0;
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );
        
        foreach ($files as $file) {
            $size += $file->getSize();
        }
        
        return $size;
    }
}

// API эндпоинт для интеграции с СИСКАПИСКА
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action']) && $input['action'] === 'clone_site') {
        $url = $input['url'] ?? '';
        $siteName = $input['site_name'] ?? null;
        
        if (empty($url)) {
            http_response_code(400);
            echo json_encode(['error' => 'URL is required']);
            exit;
        }
        
        $cloner = new SiteCloner([
            'max_pages' => $input['max_pages'] ?? 50,
            'timeout' => $input['timeout'] ?? 30,
            'user_agent' => 'SISKAPISKA/1.0 (SeoDor-Enhanced)'
        ]);
        
        $result = $cloner->cloneSite($url, $siteName);
        
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Site cloned successfully' : 'Failed to clone site',
            'cloned_sites' => $cloner->getClonedSites()
        ]);
        exit;
    }
    
    if (isset($input['action']) && $input['action'] === 'get_cloned_sites') {
        $cloner = new SiteCloner();
        echo json_encode([
            'success' => true,
            'sites' => $cloner->getClonedSites()
        ]);
        exit;
    }
}

?>