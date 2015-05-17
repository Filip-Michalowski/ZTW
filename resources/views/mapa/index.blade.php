@extends('main')

@section('content')
	<h1 class="title">Mapa</h1>
	<div class="line"></div>
	
	<div class="items">
			<table style="border-collapse: collapse; border-spacing: 0; width: 0; margin: 0 auto;">
				<colgroup>
					<col span="1">
					<col span="{{$upper_bond - $lower_bond + 1}}">
					<col span="1">
				</colgroup>

				<tr>
					<td rowspan="{{$upper_bond - $lower_bond + 1 + 2}}" style="padding: 0; height: 100%;">
						<a href="#left" style="display: inline-block; padding: 370px 8px 0 2px; width: 100%; height: 100%;">&lArr;</a>
					</td>
					<td colspan="{{$upper_bond - $lower_bond + 1}}" style="padding: 0;">
						<a href="#up" style="display: inline-block; padding: 2px 50% 8px 50%; width: 100%; height: 100%;">&uArr;</a>
					</td>
					<td rowspan="{{$upper_bond - $lower_bond + 1 + 2}}" style="vertical-align: middle; padding: 0;">
						<a href="#right" style="display: inline-block; padding: 370px 2px 0 8px; width: 100%; height: 100%;">&rArr;</a>
					</td>
				</tr>

				@foreach($mapy as $map)
					@if(($map->pos_x - $lower_bond) % $upper_bond == 0)
						<tr style="border: 0; background: #2faff8;">
					@endif
					
					<td style="margin: 0; padding: 0;">
					@if($map -> typ == 0)
						<a title="Morze ({{$map -> pos_x}},{{$map -> pos_y}})">
							<img src="../../isle_empty.png" alt="empty" style="padding: 0; margin: 0; border: 1px dashed #2faff8;">
						</a>
					@elseif($map -> typ == 1)
						@if(isset($map -> port))
							@if($map -> port -> gracz_id == $gracz)
							<a href="#manage_placeholder" title="{{$map -> port -> nazwa}} ({{$map -> pos_x}},{{$map -> pos_y}})">
							<img src="../../isle_populated.png" alt="populated" style="padding: -1px; margin: 0; border: 1px dashed #16ff01;">
							@else
							<a href="#atak_placeholder" title="{{$map -> port -> nazwa}} ({{$map -> pos_x}},{{$map -> pos_y}})">
							<img src="../../isle_populated.png" alt="populated" style="padding: 0; margin: 0; border: 1px dashed #ee6e22;">
							@endif
						</a>
						@else
						<a href="#atak_placeholder" title="Bezludna wyspa ({{$map -> pos_x}},{{$map -> pos_y}})">
							<img src="../../isle_lush.png" alt="lush" style="padding: 0; margin: 0;  border: 1px dashed #2faff8;">
						</a>
						@endif
					@endif
					</td>
					
					@if(($map->pos_x - $lower_bond) % $upper_bond == $upper_bond - 1)
						</tr>
					@endif
				@endforeach

				<tr>
					<td colspan="{{$upper_bond - $lower_bond + 1}}" style="padding: 0;">
						<a href="#down" style="display: inline-block; padding: 2px 50% 8px 50%; width: 100%; height: 100%;">&dArr;</a>
					</td>
				</tr>
			</table>
	</div>
	
	
      
      
    <div id="footer">
    <a href="mapa.html" class="button" style="position:center">Przełącz widok</a>
    
	</div>
    <!-- End Footer -->
@stop