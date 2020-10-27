<div class="box-typical box-typical-padding">
<h1>Удобства</h1>
<div class="table-responsive">
<table class="table table-hover">
    <thead>
    <tr>
        <th>Название</th>
        <th>Описание</th>
        <th>Псевдоним</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    @if (isset($comforts))
        @foreach($comforts as $comfort)
            <tr>
                <td>{{$comfort->title}}</td>
                <td>{{$comfort->desc}}</td>
                <td>{{$comfort->alias}}</td>
                <td>{!! Form::open(["url" => route('comfort.destroy', ["comfort" => $comfort->alias]), 'method' => "POST", "id" => "comfortDelete"]) !!}
                    {!! Form::button('Удалить', ['class' => 'btn btn-danger','type'=>'submit']) !!}
                    {!! Form::hidden('_method', "DELETE") !!}
                    {!! Form::close() !!}
                    </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
</div>
<br />
<button class="btn btn-primary" data-toggle="modal" data-target="#addComfort">
    Добавить новое
</button>
<!-- Modal -->
<div class="modal fade" id="addComfort" tabindex="-1" role="dialog" aria-labelledby="addComfortLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addComfortLabel">Добавить новое удобство</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(["url" => route('comfort.store'), 'method' => "POST", "id" => "comfortCreate"]) !!}
                    <div class="form-group">
                        <label for="title">Название</label>
                        {!! Form::text('title', old('title'), ['placeholder'=>'Введите название', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="desc">Описание</label>
                        {!! Form::textarea('desc', old('desc'), ['placeholder'=>'Введите описание', 'class' => 'form-control']) !!}
                    </div>
                {!! Form::button('Добавить', ['class' => 'btn btn-success','type'=>'submit']) !!}
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
</div>