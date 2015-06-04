@extends('main')

@section('content')
	<h1 class="title">{{trans("messages.attacks")}}</h1>
	<div class="line"></div>
	<div class="intro">{{trans("messages.attack_header")}}</div>

    <!-- Begin Portfolio -->
        <div class="clear"></div>
        
        <div class="items">
          <table>
            <tr><td>{{trans("messages.event_date")}}</td><td>{{trans("messages.attack_from")}}</td><td>{{trans("messages.attack_on")}}</td><td>{{trans("messages.status")}}</td><td></td></tr>
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
                    <span class="neutral">{{trans("messages.desert_island")}}</span>
                @endif
                </td>
                <td>
                @if($at->status == 0 || $at->status == 1)
                    {{trans("messages.omw_attack")}}
                @elseif($at->status == 2)
                    @if($at->atakujacy_gracz_id == $id)
                        {{trans("messages.omw_return")}}
                    @else
                        {{trans("messages.came_battle")}}
                    @endif
                @elseif($at->status == 3)
                    @if($at->atakujacy_gracz_id == $id)
                        {{trans("messages.came_back")}}
                    @else
                        {{trans("messages.came_battle")}}
                    @endif
                @elseif($at->status == 4)
                    {{trans("messages.came_reinforcements")}}
                @elseif($at->status == 5)
                    {{trans("messages.founding_pre")}}
                    <span class="ally"><a href="{{url('/')}}/{{$at->new_port_id}}">{{$at->wydarzenie}}</a></span>{{trans("messages.founding_post")}}
                @else
                    ???
                @endif
                </td>
                <td>
                @if($at->status <= 4)
                    <a href="{{url('/atak')}}/{{$at->atak_id}}">{{trans("messages.details")}}</a>
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