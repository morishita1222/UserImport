<?php
/**
 * 必要フォルダ初期化
 */

$filesPath = WWW_ROOT . 'files';
$savePath = $filesPath . DS . 'user_import';
if (is_writable($filesPath) && !is_dir($savePath)) {
    mkdir($savePath);
    chmod($savePath, 0777);
}
if (!is_writable($savePath)) {
    chmod($savePath, 0777);
}
