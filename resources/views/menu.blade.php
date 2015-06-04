 <div id="menu" class="menu-v">
      <ul style="flex: 0 0 auto;">
        <li><a href="{{ action('HomeController@index') }}">{{trans("messages.overview")}}</a></li>
        <li><a href="{{ action('SurowiecController@index') }}">{{trans("messages.resources")}}</a></li>
        <li><a href="{{ action('BudynekController@index') }}">{{trans("messages.buildings")}}</a></li>
        <li><a href="{{ action('JednostkaController@index') }}">{{trans("messages.units")}}</a></li>
		    <li><a href="{{ action('KlanController@index') }}">{{trans("messages.clan")}}</a></li>
		    <li><a href="{{ action('MapaController@index') }}">{{trans("messages.map")}}</a></li>
        <li><a href="{{ action('PocztaController@index') }}">{{trans("messages.inbox")}}</a></li>
        <li><a href="{{ action('HomeController@actual_logout') }}">{{trans("messages.logout_button")}}</a></li>
      </ul>
      <div style="flex: 1 1 auto;"></div>
      <p style="flex: 0 0 40px; margin-bottom: 50px; width: 100%; text-align: center; padding: 0; margin: 3px auto;">
        <a href="{{ url('/en') }}" title="English"><img src="{{url('images/flag_en.gif')}}" alt="English"/></a>
        <a href="{{ url('/pl') }}" title="Polski"> <img src="{{url('images/flag_pl.gif')}}" alt="Polski"/></a>
      </p>
    </div>