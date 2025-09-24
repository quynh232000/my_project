<?php

namespace App\Services;
use App\Models\General\FileUploadModel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
class FileService
{
    protected $cloudinary;
    protected static $file_default = 'https://res.cloudinary.com/dhglwzgm3/image/upload/v1752071350/red-exclamation-mark-symbol-attention-caution-sign-icon-alert-danger-problem_40876-3505_tdohub.avif';

    public function __construct()
    {
        $this->cloudinary = new Cloudinary();
    }
    public function uploadFile($file, $from = '', $user_id = null)
    {
        try {
            $type_file = $file->getClientMimeType();
            $size_file = $file->getSize();

            if (str_contains($type_file, 'image')) {
                $res    = Cloudinary::upload($file->getRealPath());

            } else if (str_contains($type_file, 'video')) {
                $res    = Cloudinary::uploadVideo($file->getRealPath());
            } else {
                $res    = Cloudinary::uploadFile($file->getRealPath());
            }
            $link       = $res->getSecurePath();
            if (!$link) {
                throw new Exception('Upload failed: Secure URL not found.');
            }
            $public_id  = $res->getPublicId();
            FileUploadModel::create([
                'type'      => $type_file,
                'url'       => $link,
                'size'      => $size_file,
                'from'      => $from,
                'public_id' => $public_id,
                'user_id'   => $user_id
            ]);

            return [
                'status'    => true,
                'url'       => $link,
            ];
        }catch (\Cloudinary\Api\Exception\ApiError $e) {
            // Handle Cloudinary-specific API errors
            return [
                'status'    => false,
                'message'   => "Cloudinary API error: " . $e->getMessage(),
                'url'       => '',
            ];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage(), 'url' => ''];
        }
    }
    public function deleteFile($publicId)
    {
        try {
            $result = Cloudinary::destroy($publicId);
            $file   = FileUploadModel::where('public_id', $publicId)->first();
            if ($file) {
                $file->delete();
                return [
                    'status'    => true,
                    'message'   => 'File deleted successfully.',
                    'result'    => $result,
                ];
            } else {
                return [
                    'status'    => false,
                    'message'   => 'File not found.',
                ];
            }
        } catch (Exception $e) {
            // Handle errors
            return [
                'status'    => false,
                'message'   => "File deletion failed: " . $e->getMessage(),
            ];
        }
    }
    public static function file_upload($params,$file,$name=null) {
        try {
            $type_file = $file->getClientMimeType();
            $size_file = $file->getSize();

            if (str_contains($type_file, 'image')) {
                $res    = Cloudinary::upload($file->getRealPath());

            } else if (str_contains($type_file, 'video')) {
                $res    = Cloudinary::uploadVideo($file->getRealPath());
            } else {
                $res    = Cloudinary::uploadFile($file->getRealPath());
            }
            $link       = $res->getSecurePath();
            if (!$link) {
                return 'https://res.cloudinary.com/dhglwzgm3/image/upload/v1752071350/red-exclamation-mark-symbol-attention-caution-sign-icon-alert-danger-problem_40876-3505_tdohub.avif';
            }
            $public_id  = $res->getPublicId();
            FileUploadModel::create([
                'type'      => $type_file,
                'url'       => $link,
                'size'      => $size_file,
                'from'      => $params['prefix'].'.'.$params['controller'].'.'.$params['action'].'.'.($name ?? 'unknown'),
                'public_id' => $public_id,
                'user_id'   => auth()->id()
            ]);

            return $link ?? 'https://res.cloudinary.com/dhglwzgm3/image/upload/v1752071350/red-exclamation-mark-symbol-attention-caution-sign-icon-alert-danger-problem_40876-3505_tdohub.avif';
        }catch (\Cloudinary\Api\Exception\ApiError $e) {
            // Handle Cloudinary-specific API errors
            return 'https://res.cloudinary.com/dhglwzgm3/image/upload/v1752071350/red-exclamation-mark-symbol-attention-caution-sign-icon-alert-danger-problem_40876-3505_tdohub.avif';
        } catch (Exception $e) {
            return 'https://res.cloudinary.com/dhglwzgm3/image/upload/v1752071350/red-exclamation-mark-symbol-attention-caution-sign-icon-alert-danger-problem_40876-3505_tdohub.avif';
        }
    }
}
