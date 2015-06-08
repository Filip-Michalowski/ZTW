@extends('main')

@section('content')
	<h1 class="title">{{trans("messages.attack")}}</h1>
	<div class="line"></div>
	<div class="intro">
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>{{trans("messages.whoops")}}</strong> {{trans("messages.there_was")}}<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
	</div>
	
			<?php $i=0; ?>
			<div class="form-container">
			<div class="items">
				<form class="forms"  method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table>
				<tr><td></td><td>{{trans("messages.unit_name")}}</td><td>{{trans("messages.amount")}}</td><td>{{trans("messages.amount")}} {{trans("messages.to_send")}}</td></tr>
				@foreach ($port_jednostki as $poj)
					
					<tr>
					<td></td>
					<td>{{trans("messages.".$poj->nazwa)}}</td>
					<td>{{$poj->ilosc}}</td>
					<td>
					<fieldset>
					<input type="text" 
					@if($poj->jednostka_id == 100)
						<?php $gah = 'major-general'; ?>
						name="major-general" value="{{-- old($gah) --}}"
						{{--@if($errors->has('major-general'))
							style="border-color: #bb1100;"
						@endif--}}
					@else
						<?php $gah = 'amount['.$i.']'; ?>
						name="amount[{{ $i }}]" value="{{--old('amount.'.$i)--}}"
					@endif
					class="text-input2 required" title=""/>
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
				<input type="text" name="newport" value="" class="text-input2 required" title="{{trans("messages.enter_port_name")}}"/>
				<input type="submit" name="submit" class="btn-submit" value="{{trans("messages.founding_button")}}" />
				@else
				<input type="hidden" name="colonization" value="0">
				<input type="submit" name="submit" class="btn-submit" value="{{trans("messages.attack_button")}}" />
				@endif
			
				
		</div>
		
	<div id="footer"> 
      <br />
      </div>
      <div class="line"></div>
      
@stop