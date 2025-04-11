<?php

namespace PhpPacker\Config;

use PhpPacker\Config\Exception\ConfigurationException;
use Psr\Log\LoggerInterface;

/**
 * 配置验证器，确保配置符合要求
 */
class ConfigurationValidator
{
    /**
     * 日志记录器
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger 日志记录器
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * 验证配置
     *
     * @param array $config 配置数组
     * @throws ConfigurationException 当验证失败时抛出
     */
    public function validate(array $config): void
    {
        $this->validateRequired($config);
        $this->validatePaths($config);
        $this->validatePatterns($config);
        $this->validateOptions($config);
    }

    /**
     * 验证必需的配置项
     *
     * @param array $config 配置数组
     * @throws ConfigurationException 当缺少必需配置项时抛出
     */
    private function validateRequired(array $config): void
    {
        $required = ['entry', 'output'];
        foreach ($required as $key) {
            if (!isset($config[$key])) {
                $this->logger->error('Missing required config', ['key' => $key]);
                throw new ConfigurationException("Missing required config: $key");
            }
        }
    }

    /**
     * 验证路径配置
     *
     * @param array $config 配置数组
     * @throws ConfigurationException 当路径无效时抛出
     */
    private function validatePaths(array $config): void
    {
        if (!file_exists($config['entry'])) {
            $this->logger->error('Entry file not found', ['file' => $config['entry']]);
            throw new ConfigurationException("Entry file not found: {$config['entry']}");
        }

        $outputDir = dirname($config['output']);
        if (!is_dir($outputDir)) {
            $this->logger->info('Creating output directory', ['dir' => $outputDir]);
            if (!mkdir($outputDir, 0755, true)) {
                throw new ConfigurationException("Failed to create output directory: $outputDir");
            }
        }
    }

    /**
     * 验证模式配置
     *
     * @param array $config 配置数组
     * @throws ConfigurationException 当模式配置无效时抛出
     */
    private function validatePatterns(array $config): void
    {
        if (isset($config['exclude']) && !is_array($config['exclude'])) {
            throw new ConfigurationException('Exclude patterns must be an array');
        }

        if (isset($config['assets']) && !is_array($config['assets'])) {
            throw new ConfigurationException('Asset patterns must be an array');
        }
    }

    /**
     * 验证选项配置
     *
     * @param array $config 配置数组
     * @throws ConfigurationException 当选项配置无效时抛出
     */
    private function validateOptions(array $config): void
    {
        $booleanOptions = ['minify', 'comments', 'debug', 'clean_output', 'remove_namespace', 'for_kphp'];
        foreach ($booleanOptions as $option) {
            if (isset($config[$option]) && !is_bool($config[$option])) {
                throw new ConfigurationException("Option '$option' must be a boolean");
            }
        }
    }
}
