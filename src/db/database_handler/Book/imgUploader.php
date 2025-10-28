<?php

class FileUploader {
    public function uploadFile() {
        $targetDir = '../../../uploads/';
        $targetFile = $targetDir . basename($_FILES['image']['name']);

        if (!file_exists($targetFile)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        }
        return $targetFile;
    }
}
