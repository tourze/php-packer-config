<?php

namespace PhpPacker\Config\Tests;

use PhpPacker\Config\Configuration;
use PhpPacker\Config\Exception\ConfigurationException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ConfigurationTest extends TestCase
{
    /**
     * @var LoggerInterface&MockObject
     */
    private $logger;
    private string $tempConfigFile;

    protected function setUp(): void
    {
        // 创建模拟日志记录器
        $this->logger = $this->createMock(LoggerInterface::class);

        // 创建临时配置文件
        $this->tempConfigFile = sys_get_temp_dir() . '/php_packer_config_test.php';
        file_put_contents($this->tempConfigFile, '<?php return [
            "entry" => "' . __FILE__ . '",
            "output" => "' . sys_get_temp_dir() . '/output.php"
        ];');
    }

    protected function tearDown(): void
    {
        // 删除临时配置文件
        if (file_exists($this->tempConfigFile)) {
            unlink($this->tempConfigFile);
        }
    }

    public function testConstructor(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertInstanceOf(Configuration::class, $configuration);
    }

    public function testGetEntryFile(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertEquals(__FILE__, $configuration->getEntryFile());
    }

    public function testGetOutputFile(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertEquals(sys_get_temp_dir() . '/output.php', $configuration->getOutputFile());
    }

    public function testExcludeDefaultsToEmptyArray(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertEquals([], $configuration->getExclude());
    }

    public function testAssetsDefaultsToEmptyArray(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertEquals([], $configuration->getAssets());
    }

    public function testShouldMinifyDefaultsToFalse(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertFalse($configuration->shouldMinify());
    }

    public function testShouldKeepCommentsDefaultsToTrue(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertTrue($configuration->shouldKeepComments());
    }

    public function testIsDebugDefaultsToFalse(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertFalse($configuration->isDebug());
    }

    public function testGetConfigFile(): void
    {
        $configuration = new Configuration($this->tempConfigFile, $this->logger);
        $this->assertEquals($this->tempConfigFile, $configuration->getConfigFile());
    }

    public function testThrowsExceptionWhenConfigFileNotFound(): void
    {
        $this->expectException(ConfigurationException::class);
        new Configuration('/non-existent-file.php', $this->logger);
    }
}
