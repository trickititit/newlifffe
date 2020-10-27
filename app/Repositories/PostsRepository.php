<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 18.06.2017
 * Time: 21:14
 */

namespace App\Repositories;

use App\Post;
use Photo;

class PostsRepository extends Repository
{

    public function __construct(Post $post) {
        $this->model = $post;
    }

    public function one($alias,$attr = array()) {
        $article = parent::one($alias,$attr);
//        if($article && !empty($attr)) {
//            $article->load('comments');
//            $article->comments->load('user');//        }
        return $article;
    }

    public function addPost($request) {
//		if (\Gate::denies('create',$this->model)) {
////            abort(403);
//        }
        $data = $request->all();
        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }
        if($this->one($data['alias'],FALSE)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Статья с таким названием уже существует'];
        }
        $data['image'] = $this->uploadImage($request);
        $this->model->create([
            'title' => $data['title'],
            'text' => $data['text'],
            'desc' => $data['desc'],
            'on_main' => isset($data['on_main']) ? 1 : 0,
            'image' => $data['image'],
            'alias' => $data['alias'],
            'section_id' => $data['section']
        ]);

        return ['status' => 'Статья добавлена'];

    }

    public function editPost($request, $post) {
//		if (\Gate::denies('create',$this->model)) {
////            abort(403);
//        }
        $data = $request->all();
        if(empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        $result = $this->one($data['alias'],FALSE);

        if(isset($result->id) && ($result->id != $post->id)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => 'Статья с таким названием уже существует'];
        }
        $data['image'] = $this->uploadImage($request);
        $post->update([
            'title' => $data['title'],
            'text' => $data['text'],
            'desc' => $data['desc'],
            'on_main' => isset($data['on_main']) ? 1 : 0,
            'image' => $data['image'],
            'alias' => $data['alias'],
            'section_id' => $data['section']
        ]);

        return ['status' => 'Статья обновлена'];

    }

    public function deletePost($post) {
        if($post->delete()) {
            return ['status' => 'Статья удалена'];
        } else {
            return ["error" => "Ошибка удаления статьи"];
        }
    }

    private function uploadImage($request) {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $uploadDir = public_path() . '/' . config('settings.theme') . '/uploads/post/';   //2
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777);
                }
                $img = Photo::make($image);
                $img_type = $this->getTypeImg($img->mime());
                if($img_type == ".err") {
                    return false;
                }
                $str = str_random(8);
                $image_path = $str . $img_type;
                $img->fit(480, 360)->save($uploadDir ."/". $image_path);
                return $image_path;
            }
        }
        return $request->has('old_image') ? $request->old_image : '';
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