<?php

namespace Tests\Feature;

use App\Services\ContestImageUploadService;
use CodeIgniter\HTTP\Files\UploadedFile;
use Tests\TestCase;

class ContestImageUploadServiceTest extends TestCase
{
    public function testUploadStoresValidContestImage(): void
    {
        if (! function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD extension not available.');
        }

        $source = tempnam(sys_get_temp_dir(), 'contest_img_');
        $image = imagecreatetruecolor(1600, 1132);
        imagefill($image, 0, 0, imagecolorallocate($image, 240, 240, 240));
        imagepng($image, $source);
        imagedestroy($image);

        $clientName = 'contest-upload-' . uniqid('', true) . '.png';
        $uploadedFile = new UploadedFile($source, $clientName, 'image/png', filesize($source), UPLOAD_ERR_OK);

        $service = new ContestImageUploadService();
        $storedFile = $service->upload($uploadedFile);

        $targetPath = FCPATH . 'images/contest/' . $storedFile;

        $this->assertFileExists($targetPath);

        @unlink($targetPath);
        if (is_file($source)) {
            @unlink($source);
        }
    }
}
