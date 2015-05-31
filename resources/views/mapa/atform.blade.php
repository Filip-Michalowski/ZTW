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
	
			<?php $i=0
			?>
			<div class="form-container">
			<div class="items">
				<form class="forms"  method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table>
				<tr><td></td><td>Nazwa jednostki</td><td>Ilość</td><td>Ilość do wysłania</td></tr>
				@foreach ($port_jednostki as $bud)
				
				<tr>
				<td></td>
				<td>{{$bud->nazwa}}</td>
				<td>{{$bud->ilosc}}</td>
				<td>
				<fieldset>
				<input type="text" name="name[{{ $i }}]" value="" class="text-input2 required" title=""/><?php $i++?>
				</fieldset>
				</form>
				</div>
				</td>
				</tr>
				@endforeach
			</table>
			
				<input type="submit" name="submit" class="btn-submit" value="Atakuj" />
		</div>
		
	<div id="footer"> 
      <br />
      </div>
      <div class="line"></div>
      
@stop