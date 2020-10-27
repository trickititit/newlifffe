@if($menu)
	<nav class="side-menu">
		<ul class="side-menu-list">
			@include(config('settings.theme').'.admin.menuitems',['items'=>$menu->roots()])
		</ul>
	</nav><!--.side-menu-->
	<div class="modal fade modal-export"
		 tabindex="-1"
		 role="dialog"
		 aria-labelledby="exportModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="modal-close" data-dismiss="modal" aria-label="Закрыть">
						<i class="font-icon-close-2"></i>
					</button>
					<h4 class="modal-title" id="exportModalLabel">Экспорт объектов</h4>
				</div>
				<div class="modal-body">
					{!! Form::open(["url" => route("object.export"), "class" => "", 'method' => "GET", "id" => ""]) !!}
					{!! Form::select('user', $inputs["rieltors"], old('user'), ["class" => "form-control", "id" => "obj_type"]) !!}
					{!! Form::button('Получить', ['class' => 'form-control btn btn-success','type'=>'submit', 'style' => 'margin-top: 15px;']) !!}
					{!! Form::close() !!}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Закрыть</button>
				</div>
			</div>
		</div>
	</div><!--.modal-->
@endif
