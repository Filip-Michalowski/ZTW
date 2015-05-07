@extends('main')

@section('content')
	<h1 class="title">Surowce</h1>
	<div class="line"></div>
	<div class="intro">Statystyki wydobycia Twoich surowców.</div>

    <!-- Begin Portfolio -->
     
        
        <div class="clear"></div>
        <div class="items">
          <table>
			<tr><td>Surowiec</td><td>Wydobycie</td><td>Wydobycie na godz.</td></tr>
			@foreach($surowce as $sur)
			<tr><td>{{$sur -> typ}}</td><td></td><td></td></tr>
			@endforeach
		</table>

        </div>
        <!-- .wrap --> 
    
    <!-- End Portfolio -->
   
    <!-- Begin Footer -->
    <div id="footer">
	</div>
      
    <!-- End Footer -->
@stop