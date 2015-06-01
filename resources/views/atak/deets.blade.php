@extends('main')

@section('content')
	<h1 class="title">Podsumowanie ataku #{{$atak->atak_id}}</h1>
	<div class="line"></div>
	<div class="intro">Atak na 
    @if($nasi)
        <span class="ally">{{$atak->b_nazwa}}</span>
    @else
        <span class="foe">{{$atak->b_nazwa}}</span>
    @endif
    (z 
    @if(!$nasi)
        <span class="ally">{{$atak->a_nazwa}}</span>)
    @else
        <span class="foe">{{$atak->a_nazwa}}</span>)
    @endif
    </div>

    <!-- Begin Portfolio -->
        <div class="clear"></div>
        
        <div class="items">
        <p><b>Data bitwy:</b> {{$atak->dataBojki}}
        @if(!$nasi)
        <br/><b>Data powrotu:</b> {{$atak->dataPowrotu}}
        @endif
        </p>
        
        <table>
            <caption class="ally">Jednostki własne
            @if($atak->status != 0 && $atak->status != 1)
            po bitwie
            @else
            przed bitwą
            @endif
            </caption>
            @foreach($straty_ally as $sa)
            <tr>
                <td class="nazwana">{{$sa->nazwa}}</td>
                <td>
                    @if($sa->ilosc_wyjscie == null)
                        <span class="neutral">0</span>
                    @else                        
                        @if($atak->status != 0 && $atak->status != 1)
                        {{$sa->ilosc_powrot}} <span class="neutral">(-{{$sa->ilosc_wyjscie - $sa->ilosc_powrot}})</span>
                        @else
                        {{$sa->ilosc_wyjscie}}
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach            
        </table>

        @if($atak->status != 0 && $atak->status != 1)
        <table>
            <caption class="foe">Jednostki przeciwnika po bitwie</caption>
            @foreach($straty_foe as $sa)
            <tr>
                <td class="nazwana">{{$sa->nazwa}}</td>
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
            <caption>Surowce
            @if(!$nasi)
                <span class="ally">zrabowane</span>
            @else
                <span class="foe">utracone</span>
            @endif
            </caption>
            @foreach($surowce as $sa)
            <tr>
                <td class="nazwana">{{$sa->typ}}</td>
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
                <td colspan="3">Jednostki z
                @if(!$nasi)
                    <span class="ally">{{$atak->a_nazwa}}</span>
                @else
                    <span class="foe">{{$atak->a_nazwa}}</span>
                @endif
                zostały odparte i nie zdołały wziąć żadnych surowców.
                </td>
                </tr>
            @endif
        </table>
        @endif

        <a href="{{url('/ataki')}}" class="button">Powrót</a>
        </div>
    <!-- End Portfolio -->
   
    <!-- Begin Footer -->
    <div id="footer">
	</div>
      
    <!-- End Footer -->
@stop