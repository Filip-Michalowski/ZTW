@extends('main')

@section('content')
	 <!-- Begin Form -->

  <h1 class="title">{{trans("messages.mail_archive_header")}}</h1>
  <div class="line"></div>
  <div class="intro"></div>


     {{trans("messages.mail_subject")}}: {{ $archiwum->temat }} <br>
     {{trans("messages.mail_date")}}: {{ $archiwum->data }} <br>
     {{trans("messages.mail_recipient")}}: {{ $archiwum->odbiorca}} <br><br>

     {{trans("messages.mail_body")}}: <br>
     {{ $archiwum->tekst }}
    
     
        <!-- End Form -->
@stop