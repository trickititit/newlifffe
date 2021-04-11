<?php

namespace App;

use Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function object()
    {
        return $this->belongsTo('App\Subject');
    }

    public static function uploadWithCurl($url, $subjectID, $subjectType, $isTemp = 0, $isExternalSubject = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $uploadedFile = curl_exec($ch);
        curl_close($ch);

        self::upload($uploadedFile, $url, $subjectID, $subjectType, $isTemp, $isExternalSubject);
    }

    public static function upload($uploadedFile, $origName, $subjectID, $subjectType = 'agency', $isTemp = 0, $isExternalSubject = false)
    {
        $uploadDir = self::getUploadDir($subjectID, $subjectType, $isTemp);

        $image = Photo::make($uploadedFile)->orientate();
//                $img->brightness(15);
//                $img->contrast(15);
//                $img->gamma(1.3);
        $type = self::getTypeImg($image->mime());
        if ($type == ".err") {
            return false;
        }

        $image_path = str_random(8) . $type;
        $image_thumb_path = "thumb-" . $image_path;

        $image->save($uploadDir . $image_path);
        $image->fit(self::getWidthImg($image, 550), 550)->save($uploadDir . $image_thumb_path);

        $subjectImage = new self;
        $subjectImage->type = $type;
        $subjectImage->src_folder = $uploadDir;
        $subjectImage->org_name = $origName;
        $subjectImage->new_name = $image_path;
        if ($isTemp == 1) {
            $subjectImage->temp = 1;
            $subjectImage->temp_object_id = $subjectID;
        } else {
            $subjectImage->temp = 0;
            if ($isExternalSubject) {
                $subjectImage->external_subject_id = $subjectID;
            } else {
                $subjectImage->object_id = $subjectID;
            }
        }
        $subjectImage->save();
    }

    public static function getUploadDir($subjectID, $subjectType = 'agency', $isTemp = 0)
    {
        $storeFolder = public_path() . '/' . config('settings.theme') . '/uploads/images/';   //2
        if ($isTemp == 1) {
            $uploadDir = $storeFolder . md5(Auth::user()->email) . "-" . $subjectID . "/";
        } else {
            $uploadDir = $storeFolder . $subjectType . "/". $subjectID . "/";
        }
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        return $uploadDir;
    }

    public function getUrl($subjectType = 'agency')
    {
        return asset(config('settings.theme')) . "/uploads/images/$subjectType/{$this->object_id}/{$this->new_name}";
    }

    private static function getTypeImg($mime)
    {
        if ($mime == "image/gif") {
            return ".gif";
        } elseif ($mime == "image/jpeg") {
            return ".jpg";
        } elseif ($mime == "image/png") {
            return ".png";
        } else {
            return ".err";
        }
    }

    private static function getWidthImg($img, $need_height)
    {
        return intval($img->width() / ($img->height() / $need_height));
    }
}
