@extends('main')

@section('content')
	<h1 class="title">Mapa</h1>
	<div class="line"></div>
	<div class="intro">tabela pozycji</div>
	
	<div class="items">
			<table>
				<tr><td>Obszar</td><td>Pozycja X</td><td>Pozycja Y</td><td> Gracz</td><td> Akcja</td></tr>
				@foreach($mapy as $map)
				<tr><td>{{$map -> id}}</td><td></td><td></td><td>-</td><td></td></tr>
				@endforeach
			</table>
	</div>
	
	
      
      
    <div id="footer">
    <a href="mapa.html" class="button" style="position:center">Przełącz widok</a>
    
	</div>
    <!-- End Footer -->
@stop