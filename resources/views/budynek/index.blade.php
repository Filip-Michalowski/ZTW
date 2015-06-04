@extends('main')

@section('content')
	<h1 class="title">{{trans("messages.buildings")}}</h1>
	<div class="line"></div>
	<div class="intro">
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
	</div>
	
	<div class="items">
			<table>
				<tr><td></td><td>{{trans("messages.building_name")}}</td><td>{{trans("messages.level")}}</td><td>{{trans("messages.cost")}}</td><td>{{trans("messages.action")}}</td></tr>
				@foreach ($port_budynki as $bud)
				<tr>
				<td></td>
				<td>{{trans("messages.".$bud->nazwa)}}</td>
				<td>{{$bud->poziom}}</td>
				<td>
						@foreach($bud->koszty as $koszt)
						{{$koszt->koszt * ($bud->poziom + 1)}} {{trans("messages.".$koszt->surowiec->typ)}} 
						@endforeach
				</td>
				<td><a href="{{ action('BudynekController@update', [$bud->id]) }}">{{trans("messages.build")}}</a></td>
				</tr>
				@endforeach
			</table>
	</div>
	
	<div id="footer">
   
      
      <br />
      </div>
      <div class="line"></div>
     
   
@stop