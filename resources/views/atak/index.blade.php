@extends('main')

@section('content')
	<h1 class="title">Ataki</h1>
	<div class="line"></div>
	<div class="intro">Ataki Twoje i na Ciebie.</div>

    <!-- Begin Portfolio -->
        <div class="clear"></div>
        
        <div class="items">
          <table>
            <tr><td>Data wydarzenia</td><td>Atak z</td><td>Atak na</td><td>Stan</td><td></td></tr>
            @foreach($ataki as $at)
            @if(!($at->atakujacy_gracz_id != $id && $at->status < 2))
            <tr>
                <td style="width: 150px;">{{$at->dataBojki}}</td>
                <td>
                @if($at->atakujacy_gracz_id == $id)
                    <span class="ally"><a href="{{url('/')}}/{{$at->atakujacy_port_id}}">{{$at->a_nazwa}}</a></span>
                @else
                    <span class="foe">{{$at->a_nazwa}}</span>
                @endif
                </td>
                <td>
                @if($at->b_nazwa != null)
                    @if($at->broniacy_gracz_id == $id)
                        <span class="ally"><a href="{{url('/')}}/{{$at->broniacy_port_id}}">{{$at->b_nazwa}}</a></span>
                    @else
                        <span class="foe">{{$at->b_nazwa}}</span>
                    @endif                
                @else
                    <span class="neutral">bezludna wyspa</span>
                @endif
                </td>
                <td>
                @if($at->status == 0 || $at->status == 1)
                    W drodze...
                @elseif($at->status == 2)
                    @if($at->atakujacy_gracz_id == $id)
                        Wracają z bitwy...
                    @else
                        Po bitwie.
                    @endif
                @elseif($at->status == 3)
                    @if($at->atakujacy_gracz_id == $id)
                        Wrócili z łupami!
                    @else
                        Po bitwie.
                    @endif
                @elseif($at->status == 4)
                    Posiłki doszły.
                @elseif($at->status == 5)
                    Założono port <span class="ally">{{$at->wydarzenie}}</span>.
                @else
                    ???
                @endif
                </td>
                <td>
                @if($at->status <= 4)
                    <a href="{{url('/atak')}}/{{$at->atak_id}}">Szczegóły</a>
                @endif
                </td>
            </tr>
            @endif
            @endforeach
        </table>

        </div>
    <!-- End Portfolio -->
   
    <!-- Begin Footer -->
    <div id="footer">
	</div>
      
    <!-- End Footer -->
@stop