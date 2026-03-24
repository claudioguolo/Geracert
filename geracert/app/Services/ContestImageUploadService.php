<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class ContestImageUploadService
{
    private const MAX_FILE_SIZE = 3145728;
    private const MIN_WIDTH = 1400;
    private const MIN_HEIGHT = 900;
    private const TARGET_RATIO = 1.4145;
    private const RATIO_TOLERANCE = 0.20;
    private const ALLOWED_MIME_MAP = [
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
    ];

    public function upload(UploadedFile $file): string
    {
        if ($file->getError() !== UPLOAD_ERR_OK || ! is_file($file->getTempName())) {
            throw new RuntimeException(lang('UI.imageUploadInvalid'));
        }

        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new RuntimeException(lang('UI.imageUploadTooLarge'));
        }

        $mimeType = $file->getMimeType();
        if (! isset(self::ALLOWED_MIME_MAP[$mimeType])) {
            throw new RuntimeException(lang('UI.imageUploadInvalidFormat'));
        }

        $imageInfo = @getimagesize($file->getTempName());
        if ($imageInfo === false) {
            throw new RuntimeException(lang('UI.imageUploadInvalid'));
        }

        [$width, $height] = $imageInfo;

        if ($width < self::MIN_WIDTH || $height < self::MIN_HEIGHT) {
            throw new RuntimeException(lang('UI.imageUploadTooSmall'));
        }

        $ratio = $width / max(1, $height);
        if (abs($ratio - self::TARGET_RATIO) > self::RATIO_TOLERANCE) {
            throw new RuntimeException(lang('UI.imageUploadInvalidRatio'));
        }

        $extension = self::ALLOWED_MIME_MAP[$mimeType];
        $originalName = pathinfo($file->getClientName(), PATHINFO_FILENAME);
        $safeBaseName = strtolower(trim((string) preg_replace('/[^A-Za-z0-9_-]+/', '-', $originalName), '-'));

        if ($safeBaseName === '') {
            $safeBaseName = 'contest-image';
        }

        $finalName = $safeBaseName . '.' . $extension;
        $targetDir = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'contest';
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $finalName;

        if (is_file($targetPath)) {
            throw new RuntimeException(lang('UI.imageUploadAlreadyExists'));
        }

        if (! is_dir($targetDir) && ! mkdir($targetDir, 0775, true) && ! is_dir($targetDir)) {
            throw new RuntimeException(lang('UI.imageUploadFailed'));
        }

        if (! @rename($file->getTempName(), $targetPath)) {
            if (! @copy($file->getTempName(), $targetPath)) {
                throw new RuntimeException(lang('UI.imageUploadFailed'));
            }
        }

        @chmod($targetPath, 0644);

        return $finalName;
    }
}
