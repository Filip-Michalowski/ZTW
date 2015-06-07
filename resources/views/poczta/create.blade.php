@extends('main')

@section('content')
	 <!-- Begin Form -->

  <h1 class="title">Wyślij wiadomość</h1>
  <div class="line"></div>
  <div class="intro"></div>



          <div class="form-container">
            <form class="forms" action="{{ action('PocztaController@store')}}" method="post">
              <fieldset>
                <ol>
                  <li class="form-row text-input-row">
                    <label>Temat</label>
                    <input type="hidden" name="nadawca" value="{{ $id }}">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="text" name="temat" value="" class="text-input required" title="" />
                  </li>
                  <li class="form-row text-input-row">
                    <label>Odbiorca</label>
                    <input type="text" name="odbiorca" value="" class="text-input required email" title="" />
                  </li>
                  <li class="form-row text-area-row">
                    <label>Treść</label>
                    <textarea name="tekst" class="text-area required"></textarea>
                  </li>
                  <li class="button-row">
                    <input type="submit" value="Wyślij" name="submit" class="btn-submit" />
                  </li>
                </ol>
              </fieldset>
            </form>
            <div class="response"></div>
          </div>
        <!-- End Form -->
@stop