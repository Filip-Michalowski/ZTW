@extends('main')

@section('content')
	<h1 class="title">Mapa</h1>
	<div class="line"></div>
	
	<div class="items">
<<<<<<< HEAD
			<table>
				<tr><td>Obszar</td><td>Pozycja X</td><td>Pozycja Y</td><td> Gracz</td><td> Akcja</td></tr>
				@foreach($mapy as $map)
				<tr><td>{{$map -> id}}</td><td></td><td></td><td>-</td><td></td></tr>
				@endforeach
			</table>
=======
			<table style="border-collapse: collapse; border-spacing: 0; width: 0; margin: 0 auto;">
				<colgroup>
					<col span="1">
					<col span="{{$upper_bond_x - $lower_bond_x + 1}}">
					<col span="1">
				</colgroup>

				<tr>
					<td rowspan="{{$upper_bond_y - $lower_bond_y + 1 + 2}}" style="padding: 0; height: 100%;">
						<a href="{{ action('MapaController@left') }}" style="display: inline-block; padding: 370px 8px 0 2px;
						 width: 100%; height: 100%;">&lArr;</a>
					</td>
					<td colspan="{{$upper_bond_x - $lower_bond_x + 1}}" style="padding: 0;">
						<a href="{{ action('MapaController@up') }}" style="display: inline-block; padding: 2px 50% 8px 50%; width: 100%; height: 100%;">&uArr;</a>
					</td>
					<td rowspan="{{$upper_bond_y - $lower_bond_y + 1 + 2}}" style="vertical-align: middle; padding: 0;">
						<a href="{{ action('MapaController@right') }}" style="display: inline-block; padding: 370px 2px 0 8px; width: 100%; height: 100%;">&rArr;</a>
					</td>
				</tr>

				@foreach($mapy as $map)
					@if(($map->pos_x - $lower_bond_x) % ($upper_bond_x-$lower_bond_x+1) == 0)
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
					
					@if(($map->pos_x - $lower_bond_x) % ($upper_bond_x-$lower_bond_x+1) == ($upper_bond_x-$lower_bond_x))
						</tr>
					@endif
				@endforeach

				<tr>
					<td colspan="{{$upper_bond_x - $lower_bond_x + 1}}" style="padding: 0;">
						<a href="{{ action('MapaController@down') }}" style="display: inline-block; padding: 2px 50% 8px 50%; width: 100%; height: 100%;">&dArr;</a>
					</td>
				</tr>
			</table>

			<ul>
				<li>lower_bond_x = {{$lower_bond_x}}</li>
				<li>upper_bond_x = {{$upper_bond_x}}</li>
				<li>lower_bond_y = {{$lower_bond_y}}</li>
				<li>upper_bond_y = {{$upper_bond_y}}</li>
				<li>{{Cache::get('id_akt')}}</li>
			</ul>
>>>>>>> origin/mapy_eksperymentalna
	</div>
	
	
      
      
    <div id="footer">
    <a href="{{ action('MapaController@center') }}" class="button" style="margin: 0 400px 0 auto;">Wycentruj na obecnej wiosce</a>    
	</div>
    <!-- End Footer -->
@stop