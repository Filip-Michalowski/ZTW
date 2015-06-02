@extends('main')

@section('content')
	<h1 class="title">Poczta</h1>
	<div class="line"></div>
	<div class="intro"></div>
	
	
	<div class="items">
			<table>
				<tr><td>Nadawca</td><td>Temat</td><td>Data</td><td>Akcja</td></tr>
				@foreach ($poczty as $poczta)
					@if($poczta->odbiorca_id == $id)
						<tr><td>{{ $poczta->nadawca }}</td><td>{{ $poczta->temat }}</td><td>{{ $poczta->data }}</td><td><a href="{{ action('PocztaController@read', [$poczta->id]) }}" class="button">Odczytaj</a><a href="{{ action('PocztaController@delete', [$poczta->id]) }}" class="button">Usuń</a></td></tr>
					@endif
				@endforeach
			</table>
	</div>
	<div id="footer">
			<a href="{{  url('/poczta/create')}}" class="button" style="position:center">Nowa wiadomość</a>
      
      
      </div>
      <div class="line"></div>
      
    <!-- End Footer -->
@stop