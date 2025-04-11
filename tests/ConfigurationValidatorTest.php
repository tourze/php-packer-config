<?php

namespace PhpPacker\Config\Tests;

use PhpPacker\Config\ConfigurationValidator;
use PhpPacker\Config\Exception\ConfigurationException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ConfigurationValidatorTest extends TestCase
{
    /**
     * @var LoggerInterface&MockObject
     */
    private $logger;

    protected function setUp(): void
    {
        // 创建模拟日志记录器
        $this->logger = $this->createMock(LoggerInterface::class);
    }

    public function testValidateRequiredKeys(): void
    {
        $validator = new ConfigurationValidator($this->logger);

        // 缺少entry键
        $invalidConfig = ['output' => 'output.php'];
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('Missing required config: entry');
        $validator->validate($invalidConfig);
    }

    public function testValidateOutputDirectory(): void
    {
        $validator = new ConfigurationValidator($this->logger);

        // 创建临时目录和文件
        $tempDir = sys_get_temp_dir() . '/php_packer_test_' . uniqid();
        mkdir($tempDir, 0755, true);
        $tempFile = $tempDir . '/test_file.php';
        file_put_contents($tempFile, '<?php');

        // 有效配置，应该不抛出异常
        $validConfig = [
            'entry' => $tempFile,
            'output' => $tempDir . '/non_existent_dir/output.php',
        ];

        try {
            $validator->validate($validConfig);
            $this->assertTrue(true); // 不应抛出异常

            // 检查输出目录是否已创建
            $this->assertTrue(is_dir(dirname($validConfig['output'])));

            // 清理
            rmdir(dirname($validConfig['output']));
        } finally {
            // 清理临时文件和目录
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
            if (is_dir($tempDir)) {
                rmdir($tempDir);
            }
        }
    }

    public function testValidatePatterns(): void
    {
        $validator = new ConfigurationValidator($this->logger);

        // 使用临时文件作为entry
        $tempFile = sys_get_temp_dir() . '/php_packer_test_' . uniqid() . '.php';
        file_put_contents($tempFile, '<?php');

        // exclude不是数组
        $invalidConfig = [
            'entry' => $tempFile,
            'output' => 'output.php',
            'exclude' => 'not an array',
        ];

        try {
            $this->expectException(ConfigurationException::class);
            $this->expectExceptionMessage('Exclude patterns must be an array');
            $validator->validate($invalidConfig);
        } finally {
            // 清理临时文件
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    public function testValidateAssetPatterns(): void
    {
        $validator = new ConfigurationValidator($this->logger);

        // 使用临时文件作为entry
        $tempFile = sys_get_temp_dir() . '/php_packer_test_' . uniqid() . '.php';
        file_put_contents($tempFile, '<?php');

        // assets不是数组
        $invalidConfig = [
            'entry' => $tempFile,
            'output' => 'output.php',
            'assets' => 'not an array',
        ];

        try {
            $this->expectException(ConfigurationException::class);
            $this->expectExceptionMessage('Asset patterns must be an array');
            $validator->validate($invalidConfig);
        } finally {
            // 清理临时文件
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    public function testValidateOptions(): void
    {
        $validator = new ConfigurationValidator($this->logger);

        // 使用临时文件作为entry
        $tempFile = sys_get_temp_dir() . '/php_packer_test_' . uniqid() . '.php';
        file_put_contents($tempFile, '<?php');

        // minify不是布尔值
        $invalidConfig = [
            'entry' => $tempFile,
            'output' => 'output.php',
            'minify' => 'not a boolean',
        ];

        try {
            $this->expectException(ConfigurationException::class);
            $this->expectExceptionMessage("Option 'minify' must be a boolean");
            $validator->validate($invalidConfig);
        } finally {
            // 清理临时文件
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }
}
