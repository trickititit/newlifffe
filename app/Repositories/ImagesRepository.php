<?php

namespace App\Repositories;

use App\Image;

class ImagesRepository extends Repository
{
    public function __construct(Image $image)
    {
        $this->model = $image;
    }

    /**
     * @param int $subjectId
     * @return mixed
     */
    public function getTempImages(int $subjectId)
    {
        return $this->model->where([['temp_object_id', "=", $subjectId], ['temp', "=", 1]])->get();
    }

    /**
     * @param int $temp_obj_id
     * @param int $obj_id
     */
    public function replaceFromImportedSubject(int $from_obj_id, int $to_obj_id)
    {
        $images = $this->model->where([['external_subject_id', "=", $from_obj_id]])->get();
        if (!$images->isEmpty()) {
            $newDir = Image::getUploadDir($to_obj_id);
            foreach ($images as $image) {
                $image->external_subject_id = null;
                $this->replace($image, $to_obj_id, $image->src_folder, $newDir);
            }
        }
    }

    /**
     * @param int $temp_obj_id
     * @param int $obj_id
     */
    public function replaceFromTemp(int $temp_obj_id, int $obj_id)
    {
        $images = $this->getTempImages($temp_obj_id);
        if (!$images->isEmpty()) {
            $newDir = Image::getUploadDir($obj_id);
            foreach ($images as $image) {
                $image->temp_object_id = null;
                $image->temp = 0;
                $this->replace($image, $obj_id, $image->src_folder, $newDir);
            }
        }
    }

    /**
     * @param Image $image
     * @param int $obj_id
     * @param string $fromDir
     * @param string $toDir
     */
    private function replace(Image $image, int $obj_id, string $fromDir, string $toDir)
    {
        $fileName = $image->new_name;
        $thumbName = "thumb-" . $fileName;
        rename($fromDir . $fileName, $toDir . $fileName);
        rename($fromDir . $thumbName, $toDir . $thumbName);

        $image->src_folder = $toDir;
        $image->object_id = $obj_id;
        $image->update();
    }
}
