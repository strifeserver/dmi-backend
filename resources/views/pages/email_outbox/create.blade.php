
@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('content')
<section id="basic-horizontal-layouts">
  <div class="row match-height">
      
      <div class="col-md-6 col-12 offset-md-3">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">Test Email</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form class="form form-horizontal" method="POST" action="{{(($mode == 'Update') ? route('email_outbox.update', $edit->id) : route('email_outbox.store'))}}">
                        @csrf
                          <div class="form-body">
                              <div class="row">


                              <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Email</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{($mode == 'Update') ? $edit->email: old('email')}}"  autocomplete="email" autofocus>
                                                  @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>



                                  <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Email Subject</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{($mode == 'Update') ? $edit->subject: old('subject')}}"  autocomplete="subject" autofocus>
                                                  @error('subject')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>


                                  <div class="col-12">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <span>Email Content</span>
                                      </div>
                                      <div class="col-md-8">
                                        <div class="position-relative has-icon-left">
                                          <fieldset class="form-label-group">
                                              <textarea class="form-control @error('content') is-invalid @enderror" id="label-textarea" rows="3" name="content">{{($mode == 'Update') ? $edit->content: old('content')}}</textarea>
                                          </fieldset>
                                        </div>
                                      </div>
                                    </div>



 
                                  </div>

                                  @if ($mode == 'Update')
                                    @method('PUT')
                                    <input type="hidden" name="id" value = "{{($mode == 'Update') ? $edit->id: ''}}">
                                  @endif
                                  <div class="col-md-10 offset-md-2">
                                      <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                      <button type="reset" class="btn btn-primary mr-1 mb-1">Reset</button>
                                      <a href="{{route('email_outbox.index')}}" class="btn btn-primary mr-1 mb-1">Back</a>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection
