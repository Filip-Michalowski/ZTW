@extends('main')

@section('content')
	 <!-- Begin Form -->

  <h1 class="title">Przeczytaj archiwalną wiadomość</h1>
  <div class="line"></div>
  <div class="intro"></div>


     Temat: {{ $archiwum->temat }} <br>
     Data: {{ $archiwum->data }} <br>
     Odbiorca: {{ $archiwum->odbiorca}} <br><br>

     Treść: <br>
     {{ $archiwum->tekst }}
    
    
        <!-- End Form -->
@stop