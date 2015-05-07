@extends('main')

@section('content')
	 <!-- Begin Form -->
          <div class="form-container">
            <form class="forms" action="contact/form-handler.php" method="post">
              <fieldset>
                <ol>
                  <li class="form-row text-input-row">
                    <label>Name</label>
                    <input type="text" name="name" value="" class="text-input required" title="" />
                  </li>
                  <li class="form-row text-input-row">
                    <label>Email</label>
                    <input type="text" name="email" value="" class="text-input required email" title="" />
                  </li>
                  <li class="form-row text-input-row">
                    <label>Subject</label>
                    <input type="text" name="subject" value="" class="text-input required" title="" />
                  </li>
                  <li class="form-row text-area-row">
                    <label>Message</label>
                    <textarea name="message" class="text-area required"></textarea>
                  </li>
                  <li class="form-row hidden-row">
                    <input type="hidden" name="hidden" value="" />
                  </li>
                  <li class="button-row">
                    <input  value="Submit" name="submit" class="btn-submit" />
                  </li>
                </ol>
                <input type="hidden" name="v_error" id="v-error" value="Required" />
                <input type="hidden" name="v_email" id="v-email" value="Enter a valid email" />
              </fieldset>
            </form>
            <div class="response"></div>
          </div>
        <!-- End Form -->
@stop