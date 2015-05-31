@extends('main')

@section('content')
	<h1 class="title">Atak</h1>
	<div class="line"></div>
	<div class="intro">
			@if($errors->any())
				@foreach($errors->all() as $e)
				<h4>{{$e}}</h4>
				@endforeach
			@endif
	</div>
	
			<?php $i=0; ?>
			<div class="form-container">
			<div class="items">
				<form class="forms"  method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table>
				<tr><td></td><td>Nazwa jednostki</td><td>Ilość</td><td>Ilość do wysłania</td></tr>
				@foreach ($port_jednostki as $poj)
					
					<tr>
					<td></td>
					<td>{{$poj->nazwa}}</td>
					<td>{{$poj->ilosc}}</td>
					<td>
					<fieldset>
					<input type="text" 
					@if($poj->jednostka_id == 100)
						name="major-general"
					@else
						name="amount[{{ $i }}]"
					@endif
					value="" class="text-input2 required" title=""/>
					<?php $i++; ?>
					</fieldset>
					</form>
					</div>
					</td>
					</tr>
				@endforeach				
			</table>
				@if($wyspa->port_id == null)
				<input type="hidden" name="colonization" value="1">
				<input type="text" name="newport" value="" class="text-input2 required" title="Wpisz nazwę portu"/>
				<input type="submit" name="submit" class="btn-submit" value="Załóż ten port" />
				@else
				<input type="hidden" name="colonization" value="0">
				<input type="submit" name="submit" class="btn-submit" value="Atakuj!" />
				@endif
			
				
		</div>
		
	<div id="footer"> 
      <br />
      </div>
      <div class="line"></div>
      
@stop