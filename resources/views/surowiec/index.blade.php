@extends('main')

@section('content')
	<h1 class="title">Surowce</h1>
	<div class="line"></div>
	<div class="intro">Statystyki wydobycia Twoich surowców.</div>

    <!-- Begin Portfolio -->
     
        
        <div class="clear"></div>
        <div class="items">
          <table>
            <tr><td>Surowiec</td><td>Zapas</td><td>Wydobycie na godz.</td></tr>
            @foreach($port_surowce as $sur)
            <tr>
                <td>{{$sur -> typ}}</td>

                {{--PHP traktuje 0 jako null, zatem bierzemy wartość, która nie jest nullem--}}
                @if($sur->updated_at != null)
                    <td>{{$sur -> ilosc + (time() - strtotime($sur->updated_at))/60 * $sur -> rate }}</td>
                    <td>{{$sur -> rate}}</td>
                @else
                    <td>0</td>
                    <td>0</td>
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