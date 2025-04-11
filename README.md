# PHP Packer Config

PHP Packer的配置管理组件，负责配置的加载、验证和管理。

## 功能

- 配置文件加载和解析
- 配置验证和错误处理
- 提供统一的配置接口

## 安装

```bash
composer require tourze/php-packer-config
```

## 使用方法

### 基本用法

```php
use PhpPacker\Config\Configuration;
use Psr\Log\LoggerInterface;

// 创建配置实例
$configuration = new Configuration('path/to/config.php', $logger);

// 读取配置
$entryFile = $configuration->getEntryFile();
$outputFile = $configuration->getOutputFile();
```

### 配置文件示例

```php
// config.php
return [
    'entry' => 'src/index.php',
    'output' => 'dist/app.php',
    'exclude' => [
        'vendor/some-package',
        'tests',
    ],
    'assets' => [
        'src/assets/image.png' => 'assets/image.png',
    ],
    'minify' => true,
    'comments' => false,
    'debug' => false,
];
```

## 配置选项

| 选项 | 类型 | 默认值 | 描述 |
|------|------|--------|------|
| entry | string | - | 入口文件路径（必需） |
| output | string | - | 输出文件路径（必需） |
| exclude | array | [] | 要排除的文件或目录模式 |
| assets | array | [] | 要复制的资源文件(源路径 => 目标路径) |
| minify | bool | false | 是否压缩代码 |
| comments | bool | true | 是否保留注释 |
| debug | bool | false | 是否启用调试模式 |
| clean_output | bool | false | 是否在生成前清理输出目录 |
| remove_namespace | bool | false | 是否移除命名空间 |

## 许可证

MIT
