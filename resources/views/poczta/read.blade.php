@extends('main')

@section('content')
	 <!-- Begin Form -->

  <h1 class="title">Przeczytaj wiadomość</h1>
  <div class="line"></div>
  <div class="intro"></div>


     Temat: {{ $poczta->temat }} <br>
     Data: {{ $poczta->data }} <br>
     Nadawca: {{ $poczta->nadawca}} <br><br>

     Treść: <br>
     {{ $poczta->tekst }}
    
    
        <!-- End Form -->
@stop