<?php

namespace App\Repositories;

use App\Image;

use Gate;

class ImagesRepository extends Repository {

    public function __construct(Image $image) {
        $this->model = $image;
    }

    public function getTmpImg($id) {
        
        $images = $this->model->where([['temp_object_id', "=",  $id],['temp', "=", 1]])->get();
        return $images;
    }

    public function createImgs($temp_obj_id, $obj_id){
        $images = $this->getTmpImg($temp_obj_id);
        if (!$images->isEmpty()) {
            $storeFolder = public_path() . '/' . config('settings.theme') . '/uploads/images/';   //2
            $newFolder = $storeFolder. $obj_id."/";
            if (!file_exists($newFolder)) {
                mkdir($newFolder);
            }
            foreach ($images as $image) {
                $folder = $image->src_folder;
                $image->src_folder = $newFolder;
                $image->temp_object_id = null;
                $image->temp = 0;
                $image->object_id = $obj_id;
                $image->update();
                rename($folder.$image->new_name, $newFolder.$image->new_name);
                rename($folder."thumb-".$image->new_name, $newFolder."thumb-".$image->new_name);
            }
        }
    }
}

?>