@extends('main')

@section('content')
	<h1 class="title">{{trans("messages.resources")}}</h1>
	<div class="line"></div>
	<div class="intro">{{trans("messages.resource_header")}}</div>

    <!-- Begin Portfolio -->
     
        
        <div class="clear"></div>
        <div class="items">
          <table>
            <tr><td>{{trans("messages.resource")}}</td><td style="text-align: right;">{{trans("messages.reserve")}}</td><td>{{trans("messages.rate_per_hour")}}</td></tr>
            @foreach($port_surowce as $sur)
            <tr>
                <td>{{trans("messages.".$sur->typ)}}</td>

                {{--PHP traktuje 0 jako null, zatem bierzemy wartość, która nie jest nullem--}}
                @if($sur->updated_at != null)
                    <td style="text-align: right; 
                    @if(floor( $sur -> ilosc + (time() - strtotime($sur->updated_at))/60 * $sur -> rate ) >= $sur -> magazyn)
                        color: #ee1111;">
                        {{$sur -> magazyn}}
                        /
                        {{$sur -> magazyn}}
                    @else
                        ">
                        {{floor( $sur -> ilosc + (time() - strtotime($sur->updated_at))/60 * $sur -> rate )}}
                        /
                        {{$sur -> magazyn}}</td>
                    @endif
                    <td>{{round($sur -> rate * 60)}}</td>
                @else
                    <td style="text-align: right;">port_id: {{$port_id}}</td>
                    <td>BŁĄĄĄĄĄĄĄĄĄĄĄD trzeba wszystkie wiersze port_surowce tworzyć przy tworzeniu portu</td>
                @endif
            </tr>
            @endforeach
        </table>

        </div>

        {{-- uaktualniane: {{$sur->updated_at}} teraz jest: {{date('H:i:s m/d/Y',time())}} --}}
        <!-- .wrap --> 
    
    <!-- End Portfolio -->
   
    <!-- Begin Footer -->
    <div id="footer">
	</div>
      
    <!-- End Footer -->
@stop