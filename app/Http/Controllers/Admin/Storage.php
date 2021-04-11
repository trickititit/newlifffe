<?php

namespace App\Http\Controllers\Admin;

use Photo;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ImagesRepository;
use App\Repositories\ObjectsRepository;

class Storage extends Controller
{
    public function objUploadImage(Request $request, ObjectsRepository $o_rep)
    {
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            if ($uploadedFile->isValid()) {
                $data = $request->except('_token', 'image');
                Image::upload($uploadedFile, $uploadedFile->getClientOriginalName(), $data["obj_id"], 'agency',
                    $data["tmp_img"]);
            }
        }
    }

    private function getex($filename)
    {
        return end(explode(".", $filename));
    }

    public function UploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $full_path = "";
            $image = $request->file('upload');
            if (($image == "none") OR (empty($image->getClientOriginalName()))) {
                $message = "Вы не выбрали файл";
            } else {
                if ($image->getClientSize() == 0 OR $image->getClientSize() > 20050000) {
                    $message = "Размер файла не соответствует нормам";
                } else {
                    if (($image->getMimeType() != "image/jpeg") AND ($image->getMimeType() != "image/gif") AND ($image->getMimeType() != "image/png")) {
                        $message = "Допускается загрузка только картинок JPG и PNG.";
                    } else {
                        $ROOT = $_SERVER['DOCUMENT_ROOT'];
                        $img = Photo::make($image);
                        $storeFolder = $ROOT . '/uploads/post/';   //2
                        if (!file_exists($storeFolder)) {
                            mkdir($storeFolder, 0777);
                        }
                        $name = rand(1, 1000) . '-' . md5($image->getClientOriginalName());
                        $img->fit(300)->save($storeFolder . $name);
                        $full_path = "/uploads/post/" . $name;
                        $message = "Файл " . $image->getClientOriginalName() . " загружен";
                    }
                }
            }
            $callback = $_REQUEST['CKEditorFuncNum'];
            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '", "' . $full_path . '", "' . $message . '" );</script>';
        }
    }

    public function objGetImage(Request $request)
    {
        $result = array();
        $obj_id = $request['objid'];
        $obj_type = $request['objtype'];
        $dir = public_path() . '/' . config('settings.theme') . "/uploads/images/$obj_type/$obj_id/";
        if (is_dir($dir)) {
            $files = scandir($dir);
            if (false !== $files) {
                foreach ($files as $file) {
                    if ('.' != $file && '..' != $file && !preg_match("/^thumb-.*/", $file)) {
                        $obj['name'] = $file;
                        $obj['size'] = filesize($dir . $file);
                        $result[] = $obj;
                    }
                }
            }
        }
        return \Response::json($result);
    }

    public function objDeleteImage(Request $request, ImagesRepository $i_rep)
    {
        if ($request->has('file')) {
            $filename = $request['file'];
            $obj_id = $request['obj_id'];
            $tmp_img = $request['tmp_img'];
            if ($tmp_img == 1) {
                $images = $i_rep->getTempImages($obj_id);
            } else {
                $images = $i_rep->get("*", false, false, ["object_id", $obj_id]);
            }
            foreach ($images as $image) {
                if ($image->org_name == $filename) {
                    $filename = $image->new_name;
                    $image_id = $image->id;
                    $uploadDir = $image->src_folder;
                } else {
                    if ($image->new_name == $filename) {
                        $image_id = $image->id;
                        $uploadDir = $image->src_folder;
                    }
                }
            }
            $del_image = $i_rep->destroy($image_id);
            if (!$del_image) {
                return false;
            }
            unlink($uploadDir . "/" . $filename);
            unlink($uploadDir . "/" . "thumb-" . $filename);
        }
    }
}
