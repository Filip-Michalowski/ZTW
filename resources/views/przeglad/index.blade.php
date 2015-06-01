@extends('main')

@section('content')


<div id="content">
	<h1 class="title">Witaj w swoim imperium!</h1>
	<div class="line"></div>
	<div class="intro">Twoje królestwo czeka na Ciebie</div>
	
	
    <!-- Wiosko -->
    <h2>Przegląd wiosek</h2>
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
		<h3>Wydarzenia</h3>
			<p>Najważniejsze wydarzenia dotyczące Twoich wiosek!</p>
			<a href="{{url('/ataki')}}" class="button">Ataki</a>
			<a href="#" class="button">Wywiad</a>
      
      <br />
      </div>
		
        <div class="clear"></div>
        <div class="items">
          <div class="box col4 web">
          <div class="image">
          	<a href="style/images/art/p1-full.jpg" rel="prettyPhoto[portfolio]" title="Caption"><span class="overlay zoom"></span><img src="style/images/art/p1.jpg" alt="" /></a>
          </div>
@stop