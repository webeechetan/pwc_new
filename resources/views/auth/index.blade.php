@extends('layout.index')

@section('title') Home @endsection

@section('body')
<!-- Hero Section -->
<section class="hero-banner sec-space bg-primary">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">
               <h2 class="title text-white">Login / Register</h2>
            </div>
         </div>
    </div>
</section>
<!-- For Startups -->
<section class="sec-space">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-3 mb-md-4">
                <h3 class="title">For Startups</h3>
            </div>
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="p-4 p-lg-5 shadow">
                    <h3 class="sub-title text-green mb-3 mb-md-4">Login</h3>
                    <form name="signin">
                    @csrf()
                        <div class="  mb-3">
                            <input type="text" class="form-control" placeholder="Email ID" name="email" required>
                            <small class="text-danger" data-error-signin="email"></small> 
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                            <small class="text-danger" data-error-signin="password"></small> 
                        </div>
                        <!-- <input type="number" class="form-control mb-3" placeholder="Enter OTP (6-Digit)" required> -->
                        <button class="btn btn-primary" name="signin_btn" type="submit">Login</button>
                        @if(Session::get('success'))
                            <small class="text-success text-center d-block">{{ Session::get('success') }}</small>
                        @endif
                        @if(Session::get('fail'))
                            <small class="text-danger text-center d-block">{{ Session::get('fail') }}</small>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 p-lg-5 shadow">
                    <h3 class="sub-title text-green mb-3 mb-md-4">Register</h3>
                    <form name="signup">
                        @csrf()
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <input type="text" class="form-control" placeholder="Name" name="fullname" required>
                                <small class="text-danger" data-error-signup="fullname"></small>                           
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control " placeholder="Email ID" name="email" required> 
                                <small class="text-danger" data-error-signup="email"></small>                              
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="tel" class="form-control" placeholder="Mobile Number" name="mobile" required>
                                <small class="text-danger" data-error-signup="mobile"></small>                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                                <small class="text-danger" data-error-signup="password"></small>                          
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
                                <small class="text-danger" data-error-signup="confirm_password"></small>                       
                            </div>
                        </div>
                        <button class="btn btn-primary" name="signup_btn" type="submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
    <!--    
        <hr class="my-5">
        <div class="row">
            <div class="col-12 text-center mb-3 mb-md-4">
                <h3 class="title">For ACMA Evaluators</h3>
            </div>
            <div class="col-md-6 mx-auto">
                <div class="p-4 p-lg-5 shadow">
                    <h3 class="sub-title text-green mb-3 mb-md-4">Login</h3>
                    <form action="">
                        <input type="text" class="form-control mb-3" placeholder="Email ID / Mobile Number" required>
                        <input type="number" class="form-control mb-3" placeholder="Enter OTP (6-Digit)" required>
                        <input type="text" class="form-control mb-4" placeholder="Password" required>
                        <button class="btn btn-primary" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    -->
    </div>
</section>
@endsection
@section('script')
    <script>
        const signin = event => {
            event.preventDefault();
            event.target[`${event.target.name}_btn`].innerHTML = `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...`;
            const formData = new FormData(event.target);

            const errorHandle = document.querySelectorAll(`small[data-error-signin]`)
            for(let eH of errorHandle) eH.innerHTML = ""

            commonAjax({
                "page": 'auth/signin',
                "params": formData
            })
            .then((response) => {
                event.target[`${event.target.name}_btn`].innerHTML = "Login";

                snackbar(response?.message || "Something went wrong!");
                if(response.success)window.location.href="./";
                let errors = response.errors || {};
                for(let [key, name] of Object.entries(errors)) {
                    try{
                        document.querySelector(`small[data-error-signin='${key}']`).innerHTML = name;
                    }catch(err) {console.log(err);}
                }
            })
            .catch(err => {
                event.target[`${event.target.name}_btn`].innerHTML = "Login";
                snackbar("Something went wrong!");
            })
        }

        document.forms.signin.addEventListener("submit", signin);
        /*
        |Singup
        ----------- */
        const signup = event => {
            event.preventDefault();
            if(event.target.password.value !== event.target.confirm_password.value){
                snackbar("confirm password do not match!");
                return false;
            }
            event.target[`${event.target.name}_btn`].innerHTML = `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...`;
            const formData = new FormData(event.target);

            const errorHandle = document.querySelectorAll(`small[data-error-signup]`)
            for(let eH of errorHandle) eH.innerHTML = ""

            commonAjax({
                "page": 'auth/signup',
                "params": formData
            })
            .then((response) => {
                event.target[`${event.target.name}_btn`].innerHTML = "Register";

                snackbar(response?.message || "Something went wrong!");
                if(response.success)window.location.href="/auth";
                let errors = response.errors || {};
                for(let [key, name] of Object.entries(errors)) {
                    try{
                        document.querySelector(`small[data-error-signup='${key}']`).innerHTML = name;
                    }catch(err) {console.log(err);}
                }
            })
            .catch(err => {
                event.target[`${event.target.name}_btn`].innerHTML = "Register";
                snackbar("Something went wrong!");
            })
        }

        document.forms.signup.addEventListener("submit", signup);
    </script>
@endsection