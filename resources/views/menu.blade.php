 <div id="menu" class="menu-v">
      <ul>
        <li><a href="{{ action('HomeController@index') }}">Przegląd</a></li>
        <li><a href="{{ action('SurowiecController@index') }}">Surowce</a></li>
        <li><a href="{{ action('BudynekController@index') }}">Budynki</a></li>
        <li><a href="{{ action('JednostkaController@index') }}">Jednostki</a></li>
		    <li><a href="{{ action('KlanController@index') }}">Klan</a></li>
		    <li><a href="{{ action('MapaController@index') }}">Mapa</a></li>
        <li><a href="{{ action('PocztaController@index') }}">Poczta</a></li>
        <li><a href="{{ url('/auth/logout') }}">Wyloguj</a></li>
        <li><a href="{{ action('HomeController@hardlogout') }}">Hard Logout</a></li>
        <li><a href="{{ action('HomeController@get_id_port') }}">get id port</a></li>
        <li><a href="{{ action('HomeController@get_id_port2') }}">get id port 2</a></li>
        <li><a href="{{ action('HomeController@actual_logout') }}">actual logout</a></li>
      </ul>
    </div>