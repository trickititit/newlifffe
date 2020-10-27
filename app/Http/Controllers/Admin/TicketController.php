<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\TicketsRepository;

class TicketController extends AdminController
{

    protected $t_rep;

    public function __construct(TicketsRepository $t_rep) {
        parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting()), new \App\Repositories\AobjectsRepository(new \App\Aobject()), new \App\User);
//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }
        $this->inc_css_lib = array_add($this->inc_css_lib,'profile', array('url' => '<link rel="stylesheet" href="'.$this->pub_path.'/css/separate/pages/profile.min.css">'));
        $this->t_rep = $t_rep;
        $this->template = config('settings.theme').'.admin.index';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkUser();
        $tickets = $this->t_rep->get("*", false, false, ["user_id", $this->user->id], false, ["created_at", "desc"]);
        $this->content = view(config('settings.theme').'.admin.tickets')->with(array("tickets" => $tickets))->render();
        $this->title = 'Поддержка';
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
        $result = $this->t_rep->add($request, $this->user->id);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect(route("ticket.index"))->with($result);
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
    public function destroy($id)
    {
        $this->checkUser();
        $ticket = $this->t_rep->get("*", false, false, array("id", $id))->first();
        $result = $this->t_rep->delete($ticket);
        return back()->with($result);
    }
}
