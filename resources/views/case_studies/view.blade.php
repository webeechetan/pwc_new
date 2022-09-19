@extends('layout.index')

@section('title') Case Studies @endsection

@section('body')
<!-- Hero Section -->
<section class="hero-banner sec-space" style="background-image: url(@if($case && file_exists('storage/uploads/case_studies/BannerImage'.$case->id.'.jpg')) {{ asset('storage/uploads/case_studies/BannerImage'.$case->id.'.jpg') }} @else {{asset('assets/images/casestudyyy.jpg')}} @endif);background-size:cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">
               <h2 class="title text-white">{{$case->title}}</h2>
            </div>
         </div>
    </div>
</section>
<!-- Breadcrumps -->
<section class="bg-primary py-2">
    <div class="container">
        <nav aria-label="breadcrumb" data-aos="zoom-in" class="aos-init aos-animate">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/case_studies">Case Studies</a></li>
            <li class="breadcrumb-item active" aria-current="page">Case Study</li>
        </ol>
        </nav>
    </div>
</section>
<!-- Content Section -->
<section class="sec-space bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="title mb-3 mb-md-4">{{$case->title}}</h3>
                <p>{!! $case->overview !!}</p>
            </div>
        </div>
    </div>
</section>
<section class="sec-space">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3 mb-md-4">
                {!! $case->description !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
                <h6 class="text-center">Share on Social Media</h6>
                <ul class="social-icons justify-content-center">
                    <li><a href="#" data-button="fb"><i class="bi bi-facebook"></i></a></li>
                    <li><a href="#" data-button="twitter"><i class="bi bi-twitter"></i></a></li>
                    <li><a href="#" data-button="instagram"><i class="bi bi-instagram"></i></a></li>
                    <!-- <li><a href="#"><i class="bi bi-youtube"></i></a></li> -->
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    const shareFB = event => {
        const imgUrl_ = encodeURIComponent('http://webeetest.com/s&t/images/logo.png');
        const shareId = event.target.getAttribute('data-id');
        let shareLink = encodeURIComponent(`https://webeetest.com/Acma-PWC/case-studies/${shareId}`);
        let fbShareLink = shareLink + '&picture=' + imgUrl_ + '&description=ACMA Event';
        let twShareLink = 'text=ACMA PWC Event&url=' + shareLink;
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + fbShareLink, "pop", "width=600, height=400, scrollbars=no");
        return false;
    }
    const shareTwitter = event => {
        const imgUrl_ = encodeURIComponent('http://webeetest.com/s&t/images/logo.png');
        const shareId = event.target.getAttribute('data-id');
        let shareLink = encodeURIComponent(`https://webeetest.com/Acma-PWC/case-studies/${shareId}`);
        let twitterShareLink = shareLink + '&picture=' + imgUrl_ + '&description=ACMA Event';
        let twShareLink = 'text=ACMA Event&url=' + shareLink;
        
        window.open("http://twitter.com/intent/tweet?" + twitterShareLink , "pop", "width=600, height=400, scrollbars=no");
        return false;
    }
    
    const shareInstagram = event => {
        const imgUrl_ = encodeURIComponent('http://webeetest.com/s&t/images/logo.png');
        const shareId = event.target.getAttribute('data-id');
        let shareLink = encodeURIComponent(`https://webeetest.com/Acma-PWC/case-studies/${shareId}`);
        let instagramShareLink = shareLink + '&picture=' + imgUrl_ + '&description=ACMA Event';
        let twShareLink = 'text=ACMA Event&url=' + shareLink;
        
        window.open("https://www.instagram.com/share?u=" + instagramShareLink , "pop", "width=600, height=400, scrollbars=no");
        return false;
    }
    document.querySelector(`a[data-button="fb"]`).addEventListener("click", shareFB);
    document.querySelector(`a[data-button="twitter"]`).addEventListener("click", shareTwitter);
    document.querySelector(`a[data-button="instagram"]`).addEventListener("click", shareInstagram);
</script>
@endsection