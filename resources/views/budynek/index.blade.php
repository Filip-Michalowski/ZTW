
@extends('main')

@section('content')
	<h1 class="title">Budynki</h1>
	<div class="line"></div>
	<div class="intro"></div>
	
	<div class="items">
			<table>
				<tr><td></td><td>Nazwa budynku</td><td>Poziom</td><td>Koszt</td><td>Akcja</td></tr>
				@foreach ($port_budynki as $bud)
				<tr><td></td><td> {{$bud ->nazwa }}</td><td> {{$bud ->poziom }}</td><td>{{$bud ->koszt * ($bud->poziom+1)}}</td><td><a href="{{ action('BudynekController@update', [$bud->id]) }}">Buduj</a></td></tr>
				@endforeach
			</table>
	</div>
	
	<div id="footer">
   
      
      <br />
      </div>
      <div class="line"></div>
     
   
@stop