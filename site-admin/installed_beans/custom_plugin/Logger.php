<?php
class Logger
{
    private $logFile;

    public function __construct($logFile)
    {
        $this->logFile = $logFile;
    }

    public function log($message, $category)
    {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "$timestamp~[$category]:~$message" . PHP_EOL;

        $this->rotateLogFileIfExceedsLimit();

        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }

    private function rotateLogFileIfExceedsLimit()
    {
        $fileSize = filesize($this->logFile);
        $fileSizeLimit = 1024 * 1024; // 1GB or 214,748,364 words before last 1000 entries get deleted

        if ($fileSize >= $fileSizeLimit) {
            $this->rotateLogFile();
        }
    }

    private function rotateLogFile()
    {
        $logBackupFile = $this->logFile . '.bak';

        // Delete backup file if it already exists
        if (file_exists($logBackupFile)) {
            unlink($logBackupFile);
        }

        // Rename the current log file to the backup file
        rename($this->logFile, $logBackupFile);
    }
}
