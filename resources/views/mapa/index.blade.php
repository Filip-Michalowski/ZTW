@extends('main')

@section('content')
	<h1 class="title">Mapa</h1>
	<div class="line"></div>
	<div class="intro">tabela pozycji</div>
	
	<div class="items">
			<table>
				<tr><td>Obszar</td><td>Pozycja X</td><td>Pozycja Y</td><td>Gracz</td><td>Akcja</td></tr>
				@foreach($mapy as $map)
				<tr><td>{{$map -> id}}</td><td>{{$map -> pos_x}}</td><td>{{$map -> pos_y}}</td><td>-</td><td></td></tr>
				@endforeach
			</table>

			<!php $stan_wyspy = ''; ?>
			<table style="border-collapse: collapse; border-spacing: 0; width: 0;">
				@for($y = 0; $y < 6; $y++)
					<tr style="border: 0;">
					@for($x = 0; $x < 6; $x++)
						<td style="padding: 0; margin: 0; border: 0; border-image-width: 0;">
						@foreach($mapy_alt as $map)
							@if($map->pos_x == $x && $map->pos_y == $y && $stan_wyspy == '')
								@if($map->port_id == null)
									<?php $stan_wyspy = 'lush'; ?>
									{{}}
								@else
									<?php $stan_wyspy = 'populated'; ?>
								@endif
							@else
								<?php $stan_wyspy = 'empty'; ?>
							@endif
						@endforeach
						
						@if($stan_wyspy == "empty")
							<a title="(pusta)"><img src="../../isle_empty.png" alt="pusta" style="padding: 0px; margin: 0px;"></a>
						@elseif($stan_wyspy == "populated")
							<a title="Niezajęta wyspa"><img src="../../isle_lush.png" alt="lush" style="padding: 0px; margin: 0px;"></a>
						@else
							<a title=""><img src="../../isle_populated.png" alt="populated" style="padding: 0px; margin: 0px;"></a>
						@endif
						<!-- href="#placeholder_na_ataki" -->
						</td>
					@endfor
					</tr>
				@endfor
			</table>
			<img src="../../isle_lush.png" alt="wolna wyspa"/>
			<img src="../../isle_barren.png" alt="pustkowie"/>
			<img src="../../isle_populated.png" alt="(info gracza))"/>
	</div>
	
	
      
      
    <div id="footer">
    <a href="mapa.html" class="button" style="position:center">Przełącz widok</a>
    
	</div>
    <!-- End Footer -->
@stop