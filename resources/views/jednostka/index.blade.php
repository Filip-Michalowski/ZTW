@extends('main')

@section('content')
	<h1 class="title">Jednostki</h1>
	<div class="line"></div>
	<div class="intro"></div>
	
	<div class="items">
			<table>
				<tr><td></td><td>Nazwa</td><td>Ilość</td><td>Koszt</td><td>Akcja</td></tr>
				
				@foreach ($port_jednostki as $poj)
				<tr><td></td><td>{{ $poj->nazwa }}</td><td>{{ $poj->ilosc }}</td><td>{{ $poj->koszt }}</td><td><a href="{{ action('JednostkaController@werbuj', [$poj->id]) }}">Werbuj</a></td></tr>
				@endforeach
					
			</table>
	</div>
	
	<div id="footer">
   
      
      <br />
      </div>
      <div class="line"></div>
      
    <!-- End Footer -->
@stop