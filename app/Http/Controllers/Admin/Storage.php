<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Photo;
use App\Image;
use App\Repositories\ImagesRepository;
use App\Repositories\ObjectsRepository;
use Illuminate\Support\Facades\Auth;

class Storage extends Controller
{

    public function objUploadImage(Request $request, ObjectsRepository $o_rep)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $storeFolder = public_path() . '/' . config('settings.theme') . '/uploads/images/';   //2
                $user = Auth::user();
                $hashed = md5($user->email);
                $data = $request->except('_token','image');
                $obj_id = $data["obj_id"];
                $tmp_img = $data["tmp_img"];
                if ($tmp_img == 1){
                    $uploadDir = $storeFolder.$hashed."-".$obj_id."/";
                } else {
                    $uploadDir = $storeFolder.$obj_id."/";
                }
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777);
                }
                $img = Photo::make($image)->orientate();
//                $img->brightness(15);
//                $img->contrast(15);
//                $img->gamma(1.3);
                $img_type = $this->getTypeImg($img->mime());
                if($img_type == ".err") {
                    return false;
                }
                $str = str_random(8);
                $image_path = $str . $img_type;
                $image_thumb_path = "thumb-" . $str . $img_type;

                $img_model = new Image;
                $img_model->type = $img_type;
                $img_model->src_folder = $uploadDir;
                $img_model->org_name = $image->getClientOriginalName();
                $img_model->new_name = $image_path;
                if($tmp_img == 1) {
                    $img_model->temp = 1;
                    $img_model->temp_object_id = $obj_id;
                } else {
                    $img_model->temp = 0;
                    $img_model->object_id = $obj_id;
                }
                $img_model->save();
                $img->save($uploadDir . $image_path);
                $img->fit($this->getWidthImg($img, 550), 550)->save($uploadDir . $image_thumb_path);
            }
        }
    }

    private function getWidthImg($img, $need_height) {
        $height = $img->height();
        $width = $img->width();
        return intval($width / ($height / $need_height));

    }

    private function getex($filename) {
        return end(explode(".", $filename));
    }

    public function UploadImage(Request $request)
    {
        if($request->hasFile('upload'))
        {
            $full_path="";
            $image = $request->file('upload');
            if (($image == "none") OR (empty($image->getClientOriginalName() )))
            {
                $message = "Вы не выбрали файл";
            }
            else if ($image->getClientSize()  == 0 OR $image->getClientSize()  > 20050000)
            {
                $message = "Размер файла не соответствует нормам";
            }
            else if (($image->getMimeType()  != "image/jpeg") AND ($image->getMimeType()  != "image/gif") AND ($image->getMimeType()  != "image/png"))
            {
                $message = "Допускается загрузка только картинок JPG и PNG.";
            }
            else{
                $ROOT = $_SERVER['DOCUMENT_ROOT'];
                $img = Photo::make($image);
                $storeFolder = $ROOT . '/uploads/post/';   //2
                if (!file_exists($storeFolder)) {
                    mkdir($storeFolder, 0777);
                }
                $name = rand(1, 1000).'-'.md5($image->getClientOriginalName());
                $img->fit(300)->save($storeFolder. $name);
                $full_path = "/uploads/post/".$name;
                $message = "Файл ".$image->getClientOriginalName()." загружен";
            }
            $callback = $_REQUEST['CKEditorFuncNum'];
            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'", "'.$message.'" );</script>';
        }
    }

    public function objGetImage(Request $request) {
            $result = array();
            $obj_id = $request['objid'];
            $scandir = public_path() . '/' . config('settings.theme') . '/uploads/images/'.$obj_id."/";
            $files = scandir($scandir);                 //1
            if (false !== $files) {
                foreach ($files as $file) {
                    if ('.' != $file && '..' != $file && !preg_match("/^thumb-.*/", $file)) {       //2
                        $obj['name'] = $file;
                        $obj['size'] = filesize($scandir . $file);
                        $result[] = $obj;
                    }
                }
            }
            return \Response::json($result);
    }
    
    public function objDeleteImage(Request $request, ImagesRepository $i_rep) {
        if ($request->has('file')) {
            $filename = $request['file'];
            $obj_id = $request['obj_id'];
            $tmp_img = $request['tmp_img'];
            if ($tmp_img == 1){
                $images = $i_rep->getTmpImg($obj_id);
            } else {
                $images = $i_rep->get("*",false, false, ["object_id", $obj_id]);
            }
            foreach ($images as $image) {
                if ($image->org_name == $filename) {
                    $filename = $image->new_name;
                    $image_id = $image->id;
                    $uploadDir = $image->src_folder;
                } else if ($image->new_name == $filename) {
                    $image_id = $image->id;
                    $uploadDir = $image->src_folder;
                }
            }
            $del_image = $i_rep->destroy($image_id);
            if (!$del_image) {
                return false;
            }
            unlink($uploadDir."/".$filename);
            unlink($uploadDir."/". "thumb-". $filename);
        }
    }

    private function getTypeImg($mime) {
        if ($mime == "image/gif") {
            return ".gif";
        } else if ($mime == "image/jpeg") {
            return ".jpg";
        } else if ($mime == "image/png") {
            return ".png";
        } else {
            return ".err";
        }

    }
}