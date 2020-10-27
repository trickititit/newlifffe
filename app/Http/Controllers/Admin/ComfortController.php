<?php

namespace App\Http\Controllers\Admin;

use App\Comfort;
use App\Repositories\ComfortsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\AdmMenusRepository;
use App\Repositories\AobjectRepository;

class ComfortController extends AdminController
{
    
    protected $c_rep;
    
    public function __construct(ComfortsRepository $c_rep, AdmMenusRepository $m_rep) {
       parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting()), new \App\Repositories\AobjectsRepository(new \App\Aobject()), new \App\User);
//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }
        $this->template = config('settings.theme').'.admin.index';
        $this->c_rep = $c_rep;
        $this->m_rep = $m_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkUser();
        $comforts = $this->c_rep->get();
        $this->content = view(config('settings.theme').'.admin.comforts')->with(array("comforts" => $comforts))->render();
        $this->title = 'Удобства';    
        return $this->renderOutput();          
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $result = $this->c_rep->addComfort($request);
        return back()->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comfort $comfort)
    {
        $this->checkUser();
         if ($this->c_rep->destroy($comfort->id)) {
             return back()->with(["status" => "Удобство удалено"]);
         } else {
             return back()->with(["error" => "Ошибка удаления"]);
         }
    }
}
