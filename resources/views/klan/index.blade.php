@extends('main')

@section('content')
	<h1 class="title">Klan</h1>
	<div class="line"></div>
	<div class="intro">Nie należysz do żadnego klanu!</div>
	
	<div class="items">
			<table>
				<tr><td>Logo klanu</td><td>Nazwa klanu</td><td>strona klanu</td></tr>
				@foreach ($klany as $klan)
				<tr><td><img src="{{ asset('images/art/s1.jpg') }}" alt="" /></td><td>{{ $klan->nazwa }}</td><td>www.{{ $klan->nazwa}}.com</td></tr>
				@endforeach
			</table>
	</div>
	
	<div id="footer">
   	<a href="{{ url('/klan/create') }} " class="button">Załóż klan</a>
	<a href="#" class="button">Wyszukaj klan</a>
      
      <br />
      </div>
      <div class="line"></div>
      
    <!-- End Footer -->
@stop