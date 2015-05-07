@extends('main')

@section('content')
	<h1 class="title">Poczta</h1>
	<div class="line"></div>
	<div class="intro"></div>
	
	
	<div class="items">
			<table>
				<tr><td>Tytuł</td><td>Nadawca</td><td> akcja</td></tr>
				@foreach ($poczty as $poczta)
				<tr><td>{{ $poczta->temat }}</td><td></td><td><a href="#" class="button">Odczytaj</a><a href="#" class="button">Usuń</a></td></tr>
				@endforeach
			</table>
	</div>
	<div id="footer">
			<a href="{{  url('/poczta/create')}}" class="button" style="position:center">Nowa wiadomość</a>
      
      
      </div>
      <div class="line"></div>
      
    <!-- End Footer -->
@stop