@extends('layout.index')

@section('title') Case Studies @endsection

@section('body')
<!-- Hero Section -->
<section class="hero-banner sec-space" style="background-image: url(@if($recent && file_exists('storage/uploads/case_studies/BannerImage'.$recent->id.'.jpg')) {{ asset('storage/uploads/case_studies/BannerImage'.$recent->id.'.jpg') }} @else {{asset('assets/images/casestudyyy.jpg')}} @endif); background-size:cover;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">
               <h2 class="title text-white mb-3 mb-md-4">@php echo ($recent ? $recent->title : ( $caseStudies && count($caseStudies) == 0 ? 'Coming Soon' : 'Recent Case Study')) @endphp</h2>
               <a href="/case-studies/@php echo $recent ? $recent->id : '#' @endphp" class="btn btn-green">Read More</a>
            </div>
         </div>
    </div>
</section>
<!-- Breadcrumps -->
<section class="bg-primary py-2">
    <div class="container">
        <nav aria-label="breadcrumb" data-aos="zoom-in" class="aos-init aos-animate">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Case Studies</li>
        </ol>
        </nav>
    </div>
</section>
<!-- Content Section -->
<section class="content-sec case-study-list sec-space">
    <div class="container">
        <div class="row">
            @if(!empty($caseStudies) && count($caseStudies) > 0)
                @foreach($caseStudies as $case)
                <div class="col-md-4">
                    <div class="case-item">
                        <a href="{{env('APP_URL')}}/case-studies/{{$case->id}}">
                            <div class="case-img">
                                <img src="{{ asset('storage/uploads/case_studies/OverviewImage'.$case->id.'.jpg') }}">
                                <img class="case-over" src="/assets/images/case-overlay.png">
                            </div>
                            <div class="case-text">
                                <div><p>{{$case->title}}</p></div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            @else
            <div class="col-md-12 text-center">
                <h3>Case study will be uploaded in due course of this project</h3>
            </div>
            @endif
            <!--<div class="col-12 text-center mt-4 mt-md-5">-->
            <!--    <a href="javascript:void(0);" class="btn btn-green">Show More <i class="bi bi-arrow-counterclockwise"></i></a>-->
            <!--</div>-->
        </div>
    </div>
</section>
<!-- Upcoming Events -->
<section class="list-sec sec-space pt-0">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-12 text-center mb-3 mb-md-4">
                    <h3 class="title">Upcoming Events</h3>
                </div>
                <div class="col-12">
                    @if(count($event) == 0)
                    <div class="text-center text-secondary h-25" style="display: none;" data-error="past-event">
                        <h5>No Event Found</h5>
                    </div>
                    @endif
                    <div class="events slider-dots">
                        @foreach($event as $e)
                        <div class="events-list">
                            <div class="events-top">
                                @if(file_exists('storage/uploads/event/Event'.$e->id.'.jpg'))
                                    <img src="{{ asset('storage/uploads/event/Event'.$e->id.'.jpg') }}">
                                @else
                                    <img src="{{ asset('assets/images/eventdefaultimage.jpg') }}">
                                @endif
                                <div class="date-batch"><span>@php echo date('d', strtotime($e -> event_from)) @endphp</span>@php echo date('M', strtotime($e -> event_from))."<br>".date('Y', strtotime($e -> event_from)) @endphp</div>
                            </div>
                            <div class="events-bot">
                                <div class="events-bot-top">
                                    <h4 class="events-title">{{$e -> title}}</h4>
                                </div>
                                <p style="height: 108px; overflow:hidden;">{!! $e -> short_description !!}</p>
                                <a href="{{env('APP_URL')}}/case_studies/{{$e->id}}" class="btn-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection