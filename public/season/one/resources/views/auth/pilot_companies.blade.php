@extends('layout.index')

@section('title') Home @endsection

@section('body')
<!-- Hero Section -->
<section class="hero-banner sec-space bg-primary">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">
               <h2 class="title text-white">Login / Signup</h2>
            </div>
         </div>
    </div>
</section>
<!-- For Startups -->
<section class="sec-space">
    <div class="container">
        <!-- <hr class="my-5"> -->
        <div class="row">
            <div class="col-12 text-center mb-3 mb-md-4">
                <h3 class="title">Pilot Companies</h3>
            </div>
            <div class="col-md-6 mx-auto">
                <div class="p-4 p-lg-5 shadow">
                    <h3 class="sub-title text-green mb-3 mb-md-4">Login</h3>
                    <form name="signin">
                        @csrf()
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email ID" required name="email">
                            <small class="text-danger" data-error-signin="email"></small> 
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control" placeholder="Password" required name="password">
                            <small class="text-danger" data-error-signin="password"></small> 
                        </div>
                        <button class="btn btn-primary" type="submit" name="signin_btn">Login</button>
                    </form>
                </div>
            </div>
        </div>
   
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
                "page": 'pilot_companies/signin',
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
    </script>
@endsection