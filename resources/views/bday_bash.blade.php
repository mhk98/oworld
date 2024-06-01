@extends('layouts.base')
@section('content')
<div class="coming-soon text-center align-items-center">

  <img src="{{ asset('static/images/birthday_bash.gif') }}" class="img-fluid birthday-bash" alt="Birthday Bash">

  <img src="{{ asset('static/images/birthday_bash_image.png') }}" class="img-fluid birthday-bash-second-image" alt="Birthday Bash Image">

</div>

<style>
 

  @media only screen and (max-width: 768px) {
    .birthday-bash-second-image{
    padding-top: 30px;
  }
}

 @media only screen and (max-width: 600px) {
  .birthday-bash-second-image{
    padding-top: 30px;
  }
 }
</style>
@endsection