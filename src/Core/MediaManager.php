<?php

namespace Cloudstorage\Core;

class MediaManager
{
    protected $uploadDir;

    public function __construct()
    {
        $this->uploadDir = __DIR__ . '/../../public/uploads/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    /**
     * Upload a file.
     *
     * @param array $file The file from $_FILES array
     * @param string $subDirectory Optional subdirectory within uploads
     * @return string|false Path to uploaded file or false on failure
     */
    public function upload(array $file, string $subDirectory = '')
    {
        if (!$this->isValidFile($file)) {
            throw new \Exception("Invalid file upload.");
        }

        $subDirectory = rtrim($subDirectory, '/') . '/';
        $targetDir = $this->uploadDir . $subDirectory;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $filename = $this->generateFileName($file['name']);
        $filePath = $targetDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return '/uploads/' . $subDirectory . $filename;
        }

        return false;
    }

    /**
     * Validate if the file is acceptable.
     *
     * @param array $file
     * @return bool
     */
    protected function isValidFile(array $file): bool
    {
        return isset($file['error']) && $file['error'] === UPLOAD_ERR_OK &&
            in_array($file['type'], ['image/jpeg', 'image/png', 'image/gif']); // Add allowed types as needed
    }

    /**
     * Generate a unique file name.
     *
     * @param string $originalName
     * @return string
     */
    protected function generateFileName(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '.' . $extension;
    }

    /**
     * Delete a file.
     *
     * @param string $filePath
     * @return bool
     */
    public function delete(string $filePath): bool
    {
        $fullPath = __DIR__ . '/../../public' . $filePath;
        return file_exists($fullPath) ? unlink($fullPath) : false;
    }
}
