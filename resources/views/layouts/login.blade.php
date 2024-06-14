@extends('partials.mainlogin')

@section('isi_login')
<div class="form-container">

    <div class="srouce"><a title="PASTALIA" href="www.PASTALIA.com">PASTALIA</a></div>
        </div>
        <form action="" class="the-form">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password">

            <input type="submit" value="Log In">
           
        </form>
    </div><!-- FORM BODY-->

    <div class="form-footer">
        <div>
            <span>Don't have an account?</span> <a href="/register">Sign Up</a>
        </div>
    </div><!-- FORM FOOTER -->

</div><!-- FORM CONTAINER -->
@endsection
