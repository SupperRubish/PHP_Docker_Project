<?php
require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('my_logger');
// 创建 Logger 实例


// 创建处理程序，将日志写入文件
$logFile = './file.log';
$handler = new StreamHandler($logFile, Logger::DEBUG);

// 将处理程序添加到记录器
$logger->pushHandler($handler);

// 记录日志消息
$logger->info('Adding a new user', array('username' => 'cr'));

//$logger->warning('This is a warning message.');

// 更多日志级别：emergency, alert, critical, error, notice, info, debug

//echo 'Log messages written to ' . $logFile . PHP_EOL;
?>
