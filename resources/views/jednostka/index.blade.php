@extends('main')

@section('content')
	<h1 class="title">Jednostki</h1>
	<div class="line"></div>
	<div class="intro"></div>
	
	<div class="items">
			<table>
				<tr><td></td><td>Nazwa</td><td>Ilość</td><td>Koszt</td><td>Akcja</td></tr>
				@foreach($jednostki as $poj)
				{{--<tr><td></td><td>{{ $poj->nazwa }}</td><td></td><td>{{ $poj->koszt }}</td><td><a href="#">Werbuj</a></td></tr>--}}
				@endforeach
				@if($port_jednostki->count() == 0)
					<tr>
						<td colspan="5" style="text-align: center;">
						Twój port jest równie bezbronny, co pijana papuga!
						<br/><b>Ani jednej jednostki.</b>
						</td>
					</tr>

				@else				
					@foreach ($port_jednostki as $poj)
					<tr><td></td><td>{{ $poj->nazwa }}</td>
						@if($poj->ilosc == null)
						<td>0</td>
						@else
						<td>{{ $poj->ilosc }}</td>
						@endif
					<td>{{ $poj->koszt }}</td><td><a href="{{ action('JednostkaController@werbuj', [$poj->id]) }}">Werbuj</a></td></tr>
					@endforeach
				@endif
					
			</table>
	</div>
	
	<div id="footer">
   
      
      <br />
      </div>
      <div class="line"></div>
      
    <!-- End Footer -->
@stop