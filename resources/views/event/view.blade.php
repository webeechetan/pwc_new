@extends('layout.index')

@section('title') Events @endsection

@section('body')
<!-- Hero Section -->
<section class="hero-banner sec-space" style="background-image: url(@if(file_exists('storage/uploads/event/EventBanner'.$event->id.'.jpg')) {{ asset('storage/uploads/event/EventBanner'.$event->id.'.jpg') }} @else {{asset('assets/images/eventtt.jpg')}} @endif);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">
               <h2 class="title text-white">{{ $event->title }}</h2>
            </div>
         </div>
    </div>
</section>
<!-- Breadcrumps -->
<section class="bg-primary py-2">
    <div class="container">
        <nav aria-label="breadcrumb" data-aos="zoom-in" class="aos-init aos-animate">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ env('APP_URL').'/' }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ env('APP_URL').'/event' }}">Events List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Event Details</li>
        </ol>
        </nav>
    </div>
</section>
<!-- Content Section -->
<section class="content-sec sec-space">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-8">
				<h3 class="title mb-3">{{ $event->title }}</h3>
				<ul class="list-none d-sm-flex gap-3 gap-sm-5">
					<li><i class="bi bi-calendar3 text-green me-1"></i> @php echo date('d M Y', strtotime($event->event_from)) . ' - ' . date('d M Y', strtotime($event->event_to)) @endphp</li>
					<li><i class="bi bi-clock text-green me-1"></i> @php echo date('h:i a', strtotime($event->event_start)) . ' - ' . date('h:i a', strtotime($event->event_end)) @endphp</li>
					<li class="text-capitalize"><i class="bi bi-wallet2 text-green me-1"></i> {{$event->type}}</li>
				</ul>
				<div class="mt-3 mt-md-4">
					<h4 class="text-primary"><strong>About the Event</strong></h4>
					<p>{!! $event->description !!}</p>
				</div>
				@php
                    $collateral = !empty($event) ? explode(",", $event->collateral) : [];
                @endphp
                <div class="row">
                    @foreach($collateral as $c)
                    @if($c != '')
                    <div class="col-md-3">
                        <div class="shadow-sm">
                            <a href="{{ asset('storage/uploads/event/'.$c) }}" target="_blank">
                                <div class="d-flex align-items-center justify-content-center" style="height: 100px">
                                    <i class="fa fa-file-o fa-2x"></i>
                                </div>
                                <hr class="mb-0">
                                <div class="text-center"><i class="fa fa-file-o mr-2"></i><small>{{$c}}</small></div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
			</div>
			<div class="col-md-4 mt-3 mt-md-0">
                @if(($event->event_from <= date('Y-m-d') && $event->event_to >= date('Y-m-d')) || $event->event_to > date('Y-m-d'))
                    @if(session() -> has('pilot') || session() -> has('startup'))
				        <button type="submit" class="btn btn-green w-100 mb-3" onclick="{{ count($eventregistered) === 1 ? "" : "registermyself(this)" }}">
                            {{ count($eventregistered) === 1 ? "Registered" : "Register Now" }}
                        </button>
                    @endif
                @endif
                @if(($event->event_from <= date('Y-m-d') && $event->event_to >= date('Y-m-d')) || $event->event_to > date('Y-m-d')) 
                    @php
                        $date_from = implode('', explode('-', date(DATE_ISO8601, strtotime($event->event_from.$event->event_start))));
                        $date_to = implode('', explode('-', date(DATE_ISO8601, strtotime($event->event_from.$event->event_end))));
                    @endphp
                <a class="btn btn-primary w-100" href="http://www.google.com/calendar/event?action=TEMPLATE&text={{$event->title}}&dates={{$date_from}}/{{$date_to}}&details={{$event->short_description}}" target="_blank">
                    Add to Calender
                </a>
                @endif
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
<!-- Upcoming Events -->
<section class="list-sec sec-space bg-light">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-12 text-center mb-3 mb-md-4">
                    <h3 class="title">Upcoming Events</h3>
                </div>
                <div class="col-12">
                    @if(count($upcoming) == 0)
                    <div class="text-center text-secondary h-25"  data-error="past-event">
                        <h5>No Event Found</h5>
                    </div>
                    @endif
                    @if(count($upcoming) > 0)
                    <div class="events slider-dots">
                        @foreach($upcoming as $u)
                        <div class="events-list">
                            <div class="events-top">
                                @if(file_exists('storage/uploads/event/Event'.$u->id.'.jpg'))
                                    <img src="{{ asset('storage/uploads/event/Event'.$u->id.'.jpg') }}">
                                @else
                                    <img src="{{ asset('assets/images/eventdefaultimage.jpg') }}">
                                @endif
                                <div class="date-batch"><span>@php echo date('d', strtotime($u -> event_from)) @endphp</span>@php echo date('M', strtotime($u -> event_from)) @endphp</div>
                            </div>
                            <div class="events-bot">
                                <div class="events-bot-top">
                                    <h4 class="events-title">{{ $u -> title }}</h4>
                                </div>
                                <p class="height: 107px; overflow: hidden">{!! $u -> short_description !!}</p>
                                <a href="{{env('APP_URL')}}/event/{{ $u->id }}" class="btn-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Case Study Section -->
<section class="case-study sec-space">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-3 mb-md-4">
                <h3 class="title">Case Study</h3>
            </div>
        </div>
        <div class="row">
        @foreach($caseStudies as $case)
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="case-item">
                    <div class="case-img">
                        <img src="{{ asset('storage/uploads/case_studies/OverviewImage'.$case->id.'.jpg') }}">
                        <img class="case-over" src="{{env('APP_URL')}}/assets/images/case-overlay.png">
                    </div>
                    <div class="case-text">
                        <div><p>{{$case->title}}</p></div>
                    </div>
                </div>
            </div>
        @endforeach
            <div class="col-12 text-center mt-4 mt-md-5">
                <a href="{{env('APP_URL')}}/case-studies" class="btn btn-green">View All <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    const registermyself = (t) => {
        t.innerHTML = "Loading..."
        commonAjax({
            page: 'event/register/{{request()->id}}?_token={{ csrf_token() }}',
            type: 'GET',
        })
        .then(res => {
            snackbar(res?.message || 'Something went wrong!');
            if(res.success)
            {
                t.innerHTML = "Registered";
                t.removeAttribute('onclick');
                return;
            }
            t.innerHTML = "Register Now";
        })
        .catch(err => t.innerHTML = "Register Now")
    }

    const shareFB = event => {
        const imgUrl_ = encodeURIComponent('http://webeetest.com/s&t/images/logo.png');
        const shareId = event.target.getAttribute('data-id');
        let shareLink = encodeURIComponent(`https://webeetest.com/Acma-PWC/event/${shareId}`);
        let fbShareLink = shareLink + '&picture=' + imgUrl_ + '&description=ACMA PWC Event';
        let twShareLink = 'text=ACMA Event&url=' + shareLink;
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + fbShareLink, "pop", "width=600, height=400, scrollbars=no");
        return false;
    }
    const shareTwitter = event => {
        const imgUrl_ = encodeURIComponent('http://webeetest.com/s&t/images/logo.png');
        const shareId = event.target.getAttribute('data-id');
        let shareLink = encodeURIComponent(`https://webeetest.com/Acma-PWC/event/${shareId}`);
        let twitterShareLink = shareLink + '&picture=' + imgUrl_ + '&description=ACMA Event';
        let twShareLink = 'text=ACMA Event&url=' + shareLink;
        
        window.open("http://twitter.com/intent/tweet?" + twitterShareLink , "pop", "width=600, height=400, scrollbars=no");
        return false;
    }
    
    const shareInstagram = event => {
        const imgUrl_ = encodeURIComponent('http://webeetest.com/s&t/images/logo.png');
        const shareId = event.target.getAttribute('data-id');
        let shareLink = encodeURIComponent(`https://webeetest.com/Acma-PWC/event/${shareId}`);
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