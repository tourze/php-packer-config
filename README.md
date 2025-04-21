# PHP Packer Config

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/php-packer-config.svg?style=flat-square)](https://packagist.org/packages/tourze/php-packer-config)
[![Build Status](https://img.shields.io/travis/tourze/php-packer-config/master.svg?style=flat-square)](https://travis-ci.org/tourze/php-packer-config)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/php-packer-config.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/php-packer-config)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/php-packer-config.svg?style=flat-square)](https://packagist.org/packages/tourze/php-packer-config)

A lightweight and robust configuration management component for PHP Packer, responsible for loading, validating, and managing configuration files.

## Features

- Load and parse configuration files
- Validate configuration and handle errors
- Unified configuration access interface
- Flexible configuration options and extensibility

## Installation

**Requirements:** PHP >= 8.1, psr/log

```bash
composer require tourze/php-packer-config
```

## Quick Start

### Basic Usage

```php
use PhpPacker\Config\Configuration;
use Psr\Log\LoggerInterface;

// Create a configuration instance
$configuration = new Configuration('path/to/config.php', $logger);

// Read configuration values
$entryFile = $configuration->getEntryFile();
$outputFile = $configuration->getOutputFile();
```

### Example Config File

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

## Configuration Options

| Option           | Type    | Default | Description                            |
|------------------|---------|---------|----------------------------------------|
| entry            | string  | -       | Entry file path (required)             |
| output           | string  | -       | Output file path (required)            |
| exclude          | array   | []      | Patterns for files/directories to skip |
| assets           | array   | []      | Asset files mapping (source => target) |
| minify           | bool    | false   | Whether to minify code                 |
| comments         | bool    | true    | Keep comments in output                |
| debug            | bool    | false   | Enable debug mode                      |
| clean_output     | bool    | false   | Clean output directory before build    |
| remove_namespace | bool    | false   | Remove namespace from output           |

## Contribution Guide

- Issues and PRs are welcome
- Follow PSR coding standards
- Please ensure tests pass before submitting

## License

MIT License

## Changelog

See [CHANGELOG](../../CHANGELOG.md)
