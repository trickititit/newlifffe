   <div class="row">
       <div class="col-12">
           {!! Form::open(["url" => route('ticket.store'), 'method' => "POST", "class" => "box-typical"]) !!}
           <input name="title" type="text" class="write-something" placeholder="Заголовок тикета"/>
           <textarea name="text" class="write-something" placeholder="Текст тикета"></textarea>
           <div class="box-typical-footer">
               <div class="tbl">
                   <div class="tbl-row">
                       <div class="tbl-cell">
                       </div>
                       <div class="tbl-cell tbl-cell-action">
                           <button type="submit" class="btn btn-rounded">Добавить</button>
                       </div>
                   </div>
               </div>
           </div>
           {!! Form::close() !!}
       </div>
   </div>
@foreach($tickets as $ticket)
    <section class="card {{ ($ticket->status == 0)? "card-blue-fill" : "card-green" }}">
        <header class="card-header">{{ $ticket->title }}</header>
        <div class="card-block">
            <header class="profile-info-item-header">
                <i class="font-icon font-icon-notebook-bird"></i>
                {{ $ticket->created_at }}
            </header>
            <div class="text-block text-block-typical">
                <p>{{ $ticket->text }}</p>
            </div>
            {!! Form::open(["url" => route('ticket.destroy', ["id" => $ticket->id]), 'method' => "POST", "id" => "newDelete"]) !!}
            {!! Form::button('Удалить', ['class' => 'btn btn-danger news-delete','type'=>'submit']) !!}
            {!! Form::hidden('_method', "DELETE") !!}
            {!! Form::close() !!}
        </div>
    </section>
@endforeach