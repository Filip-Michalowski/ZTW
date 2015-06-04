@extends('main')

@section('content')
	<h1 class="title">{{trans("messages.attack_summary")}} #{{$atak->atak_id}}</h1>
	<div class="line"></div>
	<div class="intro">
    @if($atak->atakujacy_gracz_id != $atak->broniacy_gracz_id)
    {{trans("messages.attack_on")}}
        @if($nasi)
            <span class="ally">{{$atak->b_nazwa}}</span>
        @else
            <span class="foe">{{$atak->b_nazwa}}</span>
        @endif
        ({{trans("messages.from")}}
        @if(!$nasi)
            <span class="ally">{{$atak->a_nazwa}}</span>)
        @else
            <span class="foe">{{$atak->a_nazwa}}</span>)
        @endif
    @else
    {{trans("messages.reinforcements")}} <span class="ally">{{$atak->b_nazwa}}</span> ({{trans("messages.from")}} <span class="ally">{{$atak->a_nazwa}}</span>)
    @endif
    
   
    </div>

    <!-- Begin Portfolio -->
        <div class="clear"></div>
        
        <div class="items">
        <p><b>{{trans("messages.date_battle")}}</b> {{$atak->dataBojki}}
        @if(!$nasi)
        <br/><b>{{trans("messages.date_return")}}</b> {{$atak->dataPowrotu}}
        @endif
        </p>
        
        <table>
            <caption class="ally">{{trans("messages.units_own")}}
            @if($atak->atakujacy_gracz_id == $atak->broniacy_gracz_id)
            {{trans("messages.in_reinforcements")}}
            @elseif($atak->status != 0 && $atak->status != 1)
            {{trans("messages.after_battle")}}
            @else
            {{trans("messages.before_battle")}}
            @endif
            </caption>
            @foreach($straty_ally as $sa)
            <tr>
                <td class="nazwana">{{trans("messages.".$sa->nazwa)}}</td>
                <td>
                    @if($sa->ilosc_wyjscie == null)
                        <span class="neutral">0</span>
                    @else                        
                        @if($atak->status != 0 && $atak->status != 1 && $atak->status != 4)
                        {{$sa->ilosc_powrot}} <span class="neutral">(-{{$sa->ilosc_wyjscie - $sa->ilosc_powrot}})</span>
                        @else
                        {{$sa->ilosc_wyjscie}}
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach            
        </table>

        @if($atak->status != 0 && $atak->status != 1 && $atak->status != 4)
        <table>
            <caption class="foe">{{trans("messages.units_foe")}} {{trans("messages.after_battle")}}</caption>
            @foreach($straty_foe as $sa)
            <tr>
                <td class="nazwana">{{trans("messages.".$sa->nazwa)}}</td>
                <td>
                    @if($sa->ilosc_wyjscie == null)
                        <span class="neutral">0</span>
                    @else
                        {{$sa->ilosc_powrot}} <span class="neutral">(-{{$sa->ilosc_wyjscie - $sa->ilosc_powrot}})</span>
                    @endif
                </td>
            </tr>
            @endforeach            
        </table>

        <?php $zerosCount = 0; ?>

        <table>
            <caption>{{trans("messages.resources")}}
            @if(!$nasi)
                <span class="ally">{{trans("messages.res_robbed")}}</span>
            @else
                <span class="foe">{{trans("messages.res_lost")}}</span>
            @endif
            </caption>
            @foreach($surowce as $sa)
            <tr>
                <td class="nazwana">{{trans("messages.".$sa->typ)}}</td>
                <td>
                @if($sa->ilosc == 0)
                    <span class="neutral">0</span>
                    <?php $zerosCount++; ?>
                @else
                    @if(!$nasi)
                        <span class="ally">+{{$sa->ilosc}}</span>
                    @else
                        <span class="foe">-{{$sa->ilosc}}</span>
                    @endif
                @endif
                </td>
            </tr>
            @endforeach
            @if($zerosCount == count($surowce))
                <tr>
                <td colspan="3">{{trans("messages.units_from")}}
                @if(!$nasi)
                    <span class="ally">{{$atak->a_nazwa}}</span>
                @else
                    <span class="foe">{{$atak->a_nazwa}}</span>
                @endif
                {{trans("messages.driven_back")}}
                </td>
                </tr>
            @endif
        </table>
        @endif

        <a href="{{url('/ataki')}}" class="button">{{trans("messages.back")}}</a>
        </div>
    <!-- End Portfolio -->
   
    <!-- Begin Footer -->
    <div id="footer">
	</div>
      
    <!-- End Footer -->
@stop