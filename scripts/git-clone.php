<?php
echo "Pre-install script is running!\n";

// 取得當前腳本執行的根目錄（app.yaml 所在目錄）
$rootDir = dirname(__DIR__); // 假設 scripts 在專案根目錄的子目錄下
$destination = $rootDir . '/wp-app';
$repo = 'https://github.com/BGM-Karl/wp-app.git';

// 檢查目錄是否已經存在
if (!is_dir($destination)) {
    echo "Cloning repository to $destination...\n";
    exec("git clone $repo $destination", $output, $returnVar);
    if ($returnVar !== 0) {
        echo "Error cloning repository.\n";
        exit(1);
    }
    echo "Repository cloned to $destination.\n";
} else {
    echo "Directory $destination already exists. Skipping clone.\n";
}
