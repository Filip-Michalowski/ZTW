@extends('main')

@section('content')


<div id="content">
	<h1 class="title">{{trans("messages.overview_title")}}</h1>
	<div class="line"></div>
	<div class="intro">{{trans("messages.overview_header")}}</div>
	
    <!-- Wiosko -->
    <h2>{{trans("messages.overview_ports")}}</h2>
    <div class="carousel">
      <!-- <div id="carousel-scroll"><a href="#" id="prev"></a><a href="#" id="next"></a></div> -->
      <ul>
        
      @foreach ($gracz_porty as $gp )
        <li><a href="{{ action('HomeController@get_id_port', [$gp->id]) }}"> {{$gp -> nazwa }}</a></li>
      @endforeach
        
      </ul>
    </div>
    <!-- Wioski -->
    
    <div class="line"></div>
    
   
	<div id="portfolio">
    <div id="footer">
  		<h3>{{trans("messages.events")}}</h3>
			<p>{{trans("messages.events_desc")}}</p>
			<a href="{{url('/ataki')}}" class="button">{{trans("messages.attacks")}}</a>
			{{--<a href="#" class="button">Wywiad</a>--}}
    </div>
  </div>
		
    <div class="clear"></div>
        
        {{--<div class="items">
          <div class="box col4 web">
          <div class="image">
          	<a href="style/images/art/p1-full.jpg" rel="prettyPhoto[portfolio]" title="Caption"><span class="overlay zoom"></span><img src="style/images/art/p1.jpg" alt="" /></a>
        </div>--}}
@stop