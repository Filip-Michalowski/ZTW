@extends('main')

@section('content')
	<h1 class="title">{{trans("messages.units")}}</h1>
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
				<tr><td></td><td>{{trans("messages.unit_name")}}</td><td>{{trans("messages.amount")}}</td><td>{{trans("messages.cost")}}</td><td>{{trans("messages.action")}}</td></tr>
				@if($port_jednostki->count() == 0)
					<tr>
						<td colspan="5" style="text-align: center;">
						Twój port jest równie bezbronny, co pijana papuga!
						<br/>DEBUG: <b>Ani jednej jednostki.</b>
						</td>
					</tr>
				@else				
					@foreach ($port_jednostki as $poj)
					<tr>
					<td></td>

					<td>{{ trans("messages.".$poj->nazwa) }}</td>
						@if($poj->ilosc == null)
						<td>0</td>
						@else
						<td>{{ $poj->ilosc }}</td>
						@endif
					<td>
						@foreach($poj->koszty as $koszt)
						{{$koszt->koszt}} {{trans("messages.".$koszt->surowiec->typ)}} 
						@endforeach
					</td>
					<td>
						@if($poj->produkowana)
						<a href="{{ action('JednostkaController@werbuj', [$poj->id]) }}">{{trans("messages.recruit")}}</a>
						@else
						<a href="{{ action('JednostkaController@werbuj', [$poj->id]) }}">{{trans("messages.recruit")}}</a>
						{{--Na przyszłość: do implementacji drzewa technologicznego--}}
						{{--<span style="text-decoration: line-through;">Werbuj</span>--}}
						@endif
					</td>

					</tr>
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