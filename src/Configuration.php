<?php

namespace PhpPacker\Config;

use PhpPacker\Config\Exception\ConfigurationException;
use Psr\Log\LoggerInterface;

/**
 * 配置管理类，负责加载和验证PHP Packer的配置
 */
class Configuration
{
    /**
     * 配置文件路径
     */
    private string $configFile;

    /**
     * 配置数组
     */
    private array $config;

    /**
     * 日志记录器
     */
    private LoggerInterface $logger;

    /**
     * @param string $configFile 配置文件路径
     * @param LoggerInterface $logger 日志记录器
     * @throws ConfigurationException 当配置无效时抛出异常
     */
    public function __construct(string $configFile, LoggerInterface $logger)
    {
        $this->configFile = $configFile;
        $this->logger = $logger;

        $this->logger->debug('Loading config file');

        if (!file_exists($configFile)) {
            throw new ConfigurationException("Config file not found: $configFile");
        }

        $this->config = require $configFile;

        // 使用ConfigurationValidator进行验证
        $validator = new ConfigurationValidator($logger);
        $validator->validate($this->config);
    }

    /**
     * 获取入口文件路径
     */
    public function getEntryFile(): string
    {
        return $this->config['entry'];
    }

    /**
     * 获取输出文件路径
     */
    public function getOutputFile(): string
    {
        return $this->config['output'];
    }

    /**
     * 获取排除的文件模式
     */
    public function getExclude(): array
    {
        return $this->config['exclude'] ?? [];
    }

    /**
     * 获取资源文件映射
     */
    public function getAssets(): array
    {
        return $this->config['assets'] ?? [];
    }

    /**
     * 是否启用代码压缩
     */
    public function shouldMinify(): bool
    {
        return $this->config['minify'] ?? false;
    }

    /**
     * 是否保留注释
     */
    public function shouldKeepComments(): bool
    {
        return $this->config['comments'] ?? true;
    }

    /**
     * 是否为调试模式
     */
    public function isDebug(): bool
    {
        return $this->config['debug'] ?? false;
    }

    /**
     * 获取源代码路径列表
     */
    public function getSourcePaths(): array
    {
        return [
            dirname($this->config['entry']) . '/src',
            dirname($this->config['entry']) . '/vendor',
        ];
    }

    /**
     * 获取资源文件路径列表
     */
    public function getResourcePaths(): array
    {
        $basePath = dirname($this->config['entry']);
        return [
            $basePath,
            $basePath . '/resources',
            $basePath . '/views',
            $basePath . '/templates',
            $basePath . '/config',
        ];
    }

    /**
     * 获取输出目录
     */
    public function getOutputDirectory(): string
    {
        return dirname($this->config['output']);
    }

    /**
     * 获取原始配置数组
     */
    public function getRaw(): array
    {
        return $this->config;
    }

    /**
     * 是否清理输出目录
     */
    public function shouldCleanOutput(): bool
    {
        return $this->config['clean_output'] ?? false;
    }

    /**
     * 是否移除命名空间
     */
    public function shouldRemoveNamespace(): bool
    {
        return $this->config['remove_namespace'] ?? false;
    }

    /**
     * 是否为KPHP生成代码
     */
    public function forKphp(): bool
    {
        return $this->config['for_kphp'] ?? false;
    }

    /**
     * 获取配置文件路径
     */
    public function getConfigFile(): string
    {
        return $this->configFile;
    }
}
