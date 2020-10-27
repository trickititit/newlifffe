<?php

namespace App\Http\Controllers\Admin;

use App\Components\JavaScriptMaker;
use App\Post;
use App\Repositories\PostsRepository;
use App\Repositories\SectionsRepository;
use App\Repositories\AdmMenusRepository;
use App\Repositories\RolesRepository;
use Illuminate\Http\Request;

class PostController extends AdminController
{

    protected $r_rep;
    protected $s_rep;

    public function __construct(RolesRepository $r_rep ,PostsRepository $p_rep, AdmMenusRepository $m_rep, SectionsRepository $s_rep) {
       parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting()), new \App\Repositories\AobjectsRepository(new \App\Aobject()), new \App\User);
//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }
        $this->inc_js_lib = array_add($this->inc_js_lib, 'filestyle', array('url' => '<script src="'.$this->pub_path.'/js/bootstrap-filestyle.min.js"></script>'));
        $this->inc_css_lib = array_add($this->inc_css_lib, 'ckeditor', array('url' => '<script src="'.$this->pub_path.'/ckeditor/ckeditor.js"></script>'));
        $this->inc_css_lib = array_add($this->inc_css_lib,'adm-post', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/adm.post.css">'));
        $this->template = config('settings.theme').'.admin.index';
        $this->p_rep = $p_rep;
        $this->r_rep = $r_rep;
        $this->m_rep = $m_rep;
        $this->s_rep = $s_rep;
    }


    /**
     * Display a listing of the resource.
     *
     * @return PostController
     */
    public function index()
    {
        $this->checkUser();
        $posts = $this->p_rep->get();
        $this->content = view(config('settings.theme').'.admin.posts')->with(array("posts" => $posts))->render();
        $this->title = 'Статьи';
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return PostController
     */
    public function create(JavaScriptMaker $jsmaker)
    {
        $this->checkUser();
        $jsmaker->setJs("post-create", "", true, csrf_token(), $this->randStr);
        $sections = $this->s_rep->get();
        $post_sec = array();
        foreach ($sections as $section) {
            $post_sec = array_add($post_sec, $section->id, $section->title );
        }
        $this->inputs = array_add($this->inputs, "sections", $post_sec);
        $this->content = view(config('settings.theme').'.admin.postCreate')->with(['inputs' => $this->inputs])->render();
        $this->title = 'Создание новой статьи';
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkUser();
        $result = $this->p_rep->addPost($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect(route("post.index"))->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(JavaScriptMaker $jsmaker, Post $post)
    {
        $this->checkUser();
        $jsmaker->setJs("post-create", "", true, csrf_token(), $this->randStr);
        $sections = $this->s_rep->get();
        $post_sec = array();
        foreach ($sections as $section) {
            $post_sec = array_add($post_sec, $section->id, $section->title );
        }
        $this->inputs = array_add($this->inputs, "sections", $post_sec);
        $this->content = view(config('settings.theme').'.admin.postCreate')->with(['inputs' => $this->inputs, 'post' => $post])->render();
        $this->title = $post->title;
        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->checkUser();
        $result = $this->p_rep->editPost($request, $post);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect(route("post.index"))->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->checkUser();
        $result = $this->p_rep->deletePost($post);
        return back()->with($result);
    }
}
