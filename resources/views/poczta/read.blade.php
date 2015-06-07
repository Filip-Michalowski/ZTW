@extends('main')

@section('content')
	 <!-- Begin Form -->

  <h1 class="title">{{trans("messages.mail_read_header")}}</h1>
  <div class="line"></div>
  <div class="intro"></div>


     {{trans("messages.mail_subject")}}: {{ $poczta->temat }} <br>
     {{trans("messages.mail_date")}}: {{ $poczta->data }} <br>
     {{trans("messages.mail_sender")}}: {{ $poczta->nadawca}} <br><br>

     {{trans("messages.mail_body")}}: <br>
     {{ $poczta->tekst }}
    
    
        <!-- End Form -->
@stop