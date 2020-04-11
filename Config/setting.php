<?php
/**
 * [Config] 設定ファイル
 *
 * @link https://yutori-shine.com/
 * @author yutori
 * @package UserImport
 * @license MIT
 */

/**
 * 専用ログ
 */
define('LOG_USER_IMPORT', 'log_user_import');
CakeLog::config('log_user_import', [
	'engine' => 'FileLog',
	'types' => ['log_user_import'],
	'file' => 'log_user_import',
	'size' => '3MB',
	'rotate' => 5,
]);
