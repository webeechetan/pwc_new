<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ACMA PWC</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Slabo+27px&family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">

</head>

<body class="h-100">
    <!--
    SNACKBAR
    ======== -->
    <div id="snackbar"></div>
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <p class="text-center"><img src="{{ asset('/assets/images/logo.jpg') }}"></p>
                                    <form name="login" action="" method="POST">
                                    @csrf()
                                        <div class="form-group">
                                            <label><strong>Username</strong></label>
                                            <input type="text" class="form-control" name="email" required>
                                        </div>
                                        <small class="text-danger">@error('email'){{ $message }}@enderror</small>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <small class="text-danger">@error('password'){{ $message }}@enderror</small>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<!--<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">-->
													<!--<label class="custom-control-label" for="basic_checkbox_1">Remember my preference</label>-->
												</div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                        @if(Session::get('success'))
                                            <h6 class="text-success text-center d-block">{{ Session::get('success') }}</h6>
                                        @endif
                                        @if(Session::get('fail'))
                                            <h6 class="text-danger text-center d-block fs-3">{{ Session::get('fail') }}</h6>
                                        @endif
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/assets/js/common.js') }}"></script>
</body>
</html>