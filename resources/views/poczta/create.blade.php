@extends('main')

@section('content')
	 <!-- Begin Form -->

  <h1 class="title">{{trans("messages.mail_send_title")}}</h1>
  <div class="line"></div>
  <div class="intro"></div>



          <div class="form-container">
            <form class="forms" action="{{ action('PocztaController@store')}}" method="post">
              <fieldset>
                <ol>
                  <li class="form-row text-input-row">
                    <label>{{trans("messages.mail_recipient")}}</label>
                    <input type="text" name="odbiorca" value="" class="text-input required email" title="" />
                  </li>
                  <li class="form-row text-input-row">
                    <label>{{trans("messages.mail_subject")}}</label>
                    <input type="hidden" name="nadawca" value="{{ $id }}">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="text" name="temat" value="" class="text-input required" title="" />
                  </li>
                  <li class="form-row text-area-row">
                    <label>{{trans("messages.mail_body")}}</label>
                    <textarea name="tekst" class="text-area required"></textarea>
                  </li>
                  <li class="button-row">
                    <input type="submit" value="{{trans("messages.mail_send")}}" name="submit" class="btn-submit" />
                  </li>
                </ol>
              </fieldset>
            </form>
            <div class="response"></div>
          </div>
        <!-- End Form -->
@stop