# Entity Design for PHP Packer Config

本模块主要包含如下实体：

## Configuration

- **说明**：配置管理的核心实体，负责持有和提供所有配置项的数据。
- **属性**：
  - configFile: string 配置文件路径
  - config: array 配置数组（包含所有配置项）
  - logger: LoggerInterface 日志记录器

## ConfigurationValidator

- **说明**：配置验证实体，负责校验配置项的完整性与有效性。
- **属性**：
  - logger: LoggerInterface 日志记录器

## ConfigurationException

- **说明**：配置异常实体，用于在配置校验失败时抛出异常。
- **属性**：
  - 继承自 RuntimeException，无额外属性

### 设计说明

- 本模块并无数据库表，仅为内存实体。
- 配置数据通过 PHP 文件数组返回，加载后存入 Configuration 实例。
- 验证流程独立于配置加载，异常通过 ConfigurationException 抛出。
- 日志记录器 logger 贯穿配置加载与验证过程，便于追踪与调试。
