<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class FileUploadHelper
{
    private $path, $fileIndex, $uploadData, $errors, $status;

    public function __construct($path, $fileIndex)
    {
        $this->path = rtrim($path, '/') . '/';  // Ensure path ends with a slash
        $this->fileIndex = $fileIndex;
        $this->uploadData = [];
        $this->errors = [];
        $this->status = false;
    }

    private function addError($fileName, $fileType, $msg)
    {
        $this->errors[] = [
            'file_name' => $fileName,
            'file_type' => $fileType,
            'error' => $msg,
        ];
    }

    public function handleFile(Request $request)
    {
        if ($request->hasFile($this->fileIndex)) {
            $files = $request->file($this->fileIndex);

            if (is_array($files)) {
                foreach ($files as $file) {
                    $this->processFile($file);
                }
            } else {
                $this->processFile($files);
            }

            return [
                'status' => $this->status,
                'upload_data' => $this->uploadData,
                'errors' => $this->errors
            ];
        } else {
            $fileInput = $request->input($this->fileIndex);
            if (is_array($fileInput)) {
                foreach ($fileInput as $file) {
                    $this->processFile($file);
                }
            } else {
                $this->processFile($fileInput);
            }

            return [
                'status' => $this->status,
                'upload_data' => $this->uploadData,
                'errors' => $this->errors
            ];
        }

        return [
            'status' => $this->status,
            'upload_data' => [],
            'errors' => [
                [
                    'error' => 'No File Selected',
                ]
            ]
        ];
    }

    private function processFile($file)
    {
        if (is_string($file) && $this->isBase64($file)) {
            $this->uploadBase64File($file);
        } elseif ($file instanceof UploadedFile) {
            $this->uploadFile($file);
        } else {
            $this->addError('Unknown', 'Unknown', 'Invalid file input.');
        }
    }

    private function isBase64($file)
    {
        return is_string($file) && preg_match('/^data:([a-zA-Z0-9]+\/[a-zA-Z0-9-.+]+).*,/', $file);
    }

    private function uploadBase64File($base64)
    {
        if (!$this->isBase64($base64)) {
            $this->addError('base64_string', 'base64', 'Invalid base64 format.');
            return;
        }

        $fileData = explode(',', $base64);
        $fileInfo = explode(';', $fileData[0]);
        $fileType = explode(':', $fileInfo[0])[1];
        $fileExtension = explode('/', $fileType)[1];
        $fileContent = base64_decode($fileData[1]);

        if ($fileContent === false) {
            $this->addError('base64_string', $fileType, 'Base64 decode failed.');
            return;
        }

        $filename = now()->format('YmdHis') . '_' . Str::random(10) . '.' . $fileExtension;

        $this->createDirectoryIfNeeded();

        $filePath = $this->path . $filename;

        if (File::put($filePath, $fileContent) !== false) {
            $this->status = true;

            $this->uploadData[] = [
                'name' => $filename,
                'type' => $fileType,
                'file_name' => $filename,
            ];
        } else {
            $this->addError($filename, $fileType, 'Failed to save Base64 file.');
        }
    }

    private function uploadFile($file)
    {
        if (!$file->isValid()) {
            $this->addError($file->getClientOriginalName(), $file->getClientMimeType(), $file->getErrorMessage());
            return;
        }

        $filename = now()->format('YmdHis') . '_' . Str::random(10) . '_' . $file->getClientOriginalName();

        $this->createDirectoryIfNeeded();

        if ($file->move($this->path, $filename)) {
            $this->status = true;

            $this->uploadData[] = [
                'name' => $filename,
                'type' => $file->getClientMimeType(),
                'file_name' => $filename,
            ];
        } else {
            $this->addError($file->getClientOriginalName(), $file->getClientMimeType(), 'Failed to move uploaded file.');
        }
    }

    private function createDirectoryIfNeeded()
    {
        if (!File::exists($this->path)) {
            File::makeDirectory($this->path, 0755, true);
        }
    }
}
