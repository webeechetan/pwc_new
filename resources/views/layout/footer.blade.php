<!-- Footer -->
@php $footer = getFooterData(); @endphp
<footer class="sec-space bg-light pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <img class="mb-3" src="{{env('APP_URL')}}/assets/images/logo-transparent.png">
                <p>{!! $footer->f->description !!}</p>
                <!--<a href="#" class="btn-link">Read more <i class="bi bi-arrow-right"></i></a>-->
            </div>
            <div class="col-md-2 mb-4 mb-md-0">
                <h4 class="sub-title mb-3 mb-md-4">Quick Links</h4>
                <ul class="footer-nav">
                    @php
                        $QL = $footer -> ql ?? [];
                    @endphp
                    @foreach($QL as $ql)
                        <li> <a href="{{ $ql->content2 }}">{{ $ql->content1}}</a></li>
                    @endforeach
                </ul>
            </div>
            <!--<div class="col-md-3 mb-4 mb-md-0">-->
            <!--    <h4 class="sub-title mb-3 mb-md-4">Recent post</h4>-->
            <!--    <div class="footer-post">-->
            <!--        <div class="footer-post-item">-->
            <!--            <a href="#">What you need to know about wisdom</a>-->
            <!--            <p class="mt-2"><small>October 25, 2018</small></p>-->
            <!--        </div>-->
            <!--        <div class="footer-post-item">-->
            <!--            <a href="#">What you need to know about</a>-->
            <!--            <p class="mt-2"><small>October 25, 2018</small></p>-->
            <!--        </div>-->
            <!--        <div class="footer-post-item">-->
            <!--            <a href="#">What you need to know about</a>-->
            <!--            <p class="mt-2"><small>October 25, 2018</small></p>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-md-3">-->
            <!--    <h4 class="sub-title mb-3 mb-md-4">Newslatter</h4>-->
            <!--    <p>Lorem ipsum dolor sit aconsect etur adipisicing elit eiusmte incid idunt ut labore et dolore magna</p>-->
            <!--    <form action="">-->
            <!--        <input type="text" class="form-control mb-3" placeholder="Email">-->
            <!--        <button type="submit" class="btn btn-green">Submit</button>-->
            <!--    </form>-->
            <!--</div>-->
        </div>
    </div>
    <div class="container">
        <hr>
        <div class="row align-items-center">
            <div class="col-md-7">
                <p class="mb-md-0">{!! $footer->f->copyright_title !!}</b></a></p>
            </div>
            <div class="col-md-5">
                <ul class="social-icons justify-content-md-end">
                    <li><a href="{{ $footer->f->fb }}"><i class="bi bi-facebook"></i></a></li>
                    <li><a href="{{ $footer->f->twitter }}"><i class="bi bi-twitter"></i></a></li>
                    <li><a href="{{ $footer->f->linkedin }}"><i class="bi bi-linkedin"></i></a></li>
                    <li><a href="{{ $footer->f->youtube }}"><i class="bi bi-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>