# PHP Packer 配置组件

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/php-packer-config.svg?style=flat-square)](https://packagist.org/packages/tourze/php-packer-config)
[![Build Status](https://img.shields.io/travis/tourze/php-packer-config/master.svg?style=flat-square)](https://travis-ci.org/tourze/php-packer-config)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/php-packer-config.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/php-packer-config)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/php-packer-config.svg?style=flat-square)](https://packagist.org/packages/tourze/php-packer-config)

简洁高效的 PHP Packer 配置管理组件，负责配置文件的加载、验证和统一管理。

## 功能特性

- 配置文件加载与解析
- 配置项校验与异常处理
- 提供统一的配置访问接口
- 支持多种配置选项与灵活扩展

## 安装说明

系统要求：PHP >= 8.1，依赖 psr/log

```bash
composer require tourze/php-packer-config
```

## 快速开始

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

## 配置项说明

| 选项             | 类型    | 默认值 | 说明                       |
|------------------|---------|--------|----------------------------|
| entry            | string  | -      | 入口文件路径（必填）       |
| output           | string  | -      | 输出文件路径（必填）       |
| exclude          | array   | []     | 排除的文件或目录模式       |
| assets           | array   | []     | 资源文件映射（源=>目标）   |
| minify           | bool    | false  | 是否压缩代码               |
| comments         | bool    | true   | 是否保留注释               |
| debug            | bool    | false  | 是否开启调试模式           |
| clean_output     | bool    | false  | 是否生成前清理输出目录     |
| remove_namespace | bool    | false  | 是否移除命名空间           |

## 贡献指南

- 欢迎提交 Issue 和 PR
- 遵循 PSR 代码规范
- 提交前请确保通过测试

## 版权和许可

MIT License

## 更新日志

详见 [CHANGELOG](../../CHANGELOG.md)
