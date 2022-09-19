@extends('layout.index')

@section('title') Home @endsection

@section('body')
<!-- Hero Section -->
<section class="hero-sec" style="background-image: url({{asset('storage/uploads/homepage/banner.jpg')}})">
    <div class="container">
        <div class="row">
            <div class="col-12 sec-space">
                <h4 class="sub-title text-white">{{$data->banner_title}}</h4>
                <h2 class="banner-text text-green">{{$data->banner_caption1}}</h2>
                <h3 class="banner-sub-text text-green">{{$data->banner_caption2}}</h3>
                <p class="text-big text-white py-3 py-md-4">{{$data->banner_subtitle}}</p>
                @if(!session()->has('pilot') && !session()->has('startup'))
                <a href="{{$data->banner_button_action}}" class="btn btn-green">{{$data->banner_button}}</a>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Section 1 Counter Section -->
<section class="counter-sec bg-primary sec-space">
    <div class="container-fluid">
        <div class="row counters">
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="counter-item">
                    @if($data->id == 1)
                        <p class="text-big text-white mb-0"><span class="text-green"><b class="counters-value" data-count="{{$data->s1_count1}}">{{$data->s1_count1}}</b>+</span> {{$data->s1_heading1}}</p>
                    @else
                        <p class="text-big text-white mb-0"><span class="text-green"><b class="counters-value" data-count="{{$data->s1_count1}}">{{$data->s1_count1}}</b>+</span> {{$data->s1_heading1}}</p>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="counter-item">
                @if($data->id == 1)
                    <p class="text-big text-white mb-0"><span class="text-green"><b class="counters-value" data-count="{{$data->s1_count2}}">{{$data->s1_count2}}</b>+</span>  {{$data->s1_heading2}}</p>
                @else
                    <p class="text-big text-white mb-0 mt-4">{{$data->s1_heading2}}</p>
                @endif 
                    
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="counter-item">
                @if($data->id == 1)
                    <p class="text-big text-white mb-0"><span class="text-green"><b class="counters-value" data-count="{{$data->s1_count3}}">{{$data->s1_count3}}</b>+</span> {{$data->s1_heading3}}</p>
                @else
                    <p class="text-big text-white mb-0"><span class="text-green"><b class="counters-value" data-count="{{$data->s1_count3}}">{{$data->s1_count3}}</b>+</span> {{$data->s1_heading3}}</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Overview Section -->
<section class="over-sec sec-space position-relative overflow-hidden">
    <div class="ani-sec">
        <img src="{{env('APP_URL')}}/assets/images/green-dot-small.png">
        <img src="{{env('APP_URL')}}/assets/images/green-dot-big.png">
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h4 class="sub-title text-green">{{$data->s2_heading}}</h4>
                <h3 class="title mb-3 mb-md-4">{{$data->s2_title}}</h3>
                <div> {!! $data->s2_description !!} </div>
                <!--<p class="mb-3 mb-md-4">The Start-Up Connect Initiative aims at helping early-stage automotive startups to learn from the Industry's top companies through various challenges and programs and work with them to further</p>
                <ul class="mb-0">
                    <li>Build a roadmap for their business</li>
                    <li>Think of solutions for efficiency and improvement projects</li>
                    <li>Get Investment opportunities</li>
                    <li>Be a part of a vibrant community that stimulates growth</li>
                </ul>-->
            </div>
            <div class="col-md-6 position-relative">
                <img src="{{ asset('storage/uploads/homepage/s2_image.jpg') }}">
                <img class="img1-shape" src="{{env('APP_URL')}}images/img1-shape.png">
            </div>
        </div>
    </div>
</section>
<!-- Events Section -->
@if(count($upcomingevent) > 0)
<section class="events-sec sec-space bg-light overflow-hidden">
    <div class="container">
        <div class="row">
            <div class="col-12 text-md-center mb-3 mb-md-5">
                <h4 class="sub-title text-green">{{$data->event_title}}</h4>
                <h3 class="title">{{$data->event_subtitle}}</h3>
            </div>
            <div class="col-12">
                <div class="events slider-dots">
                    @foreach($upcomingevent as $ue)
                    <div class="events-list">
                        <div class="events-top">
                            @if(file_exists('storage/uploads/event/Event'.$ue->id.'.jpg'))
                                <img src="{{ asset('storage/uploads/event/Event'.$ue->id.'.jpg') }}">
                            @else
                                <img src="{{ asset('assets/images/eventdefaultimage.jpg') }}">
                            @endif
                            <div class="date-batch"><span>@php echo date('d', strtotime($ue -> event_from)) @endphp</span>@php echo date('M', strtotime($ue -> event_from)) @endphp</div>
                        </div>
                        <div class="events-bot">
                            <div class="events-bot-top">
                                <h4 class="events-title">{{ $ue -> title }}</h4>
                            </div>
                            <div class="mb-2" style="max-height: 104px; overflow: hidden;">{!! $ue -> short_description !!}</div>
                            <a href="{{ env('APP_URL').'/event/'.$ue->id }}" class="btn-link">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Case Study Section -->
<section class="case-study bg-primary sec-space pb-0">
    <div class="case-study-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 col-xl-6 mx-auto text-md-center mb-4 mb-md-5">
                    <h4 class="sub-title text-green">{{$data->case_study_title}}</h4>
                    <h3 class="title text-white">{{$data->case_study_subtitle}}</h3>
                </div>
            </div>
            @if(count($caseStudies) > 0)
            <div class="row">
                @foreach($caseStudies as $case)
                <div class="col-md-4">
                    <div class="case-item">
                        <a href="/case-studies/{{$case->id}}">
                            <div class="case-img">
                                <img src="{{ asset('storage/uploads/case_studies/OverviewImage'.$case->id.'.jpg') }}">
                                <img class="case-over" src="/assets/images/case-overlay.png">
                            </div>
                            <div class="case-text">
                                <div>
                                    <p>
                                        {{$case->title}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="col-12 text-center mt-4 mt-md-5">
                    <a href="{{env('APP_URL')}}/case-studies" class="btn btn-green">View All <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            @else
                <div class="row justify-content-center align-items-center" style="height: 300px;">
                    <div class="col-lg-6 text-center text-white card bg-primary">
                        <h2 class="py-3">Coming Soon</h2>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="case-black-space"></div>
</section>
<!-- Knowledge Sharing Section -->
<section class="case-study bg-primary sec-space pb-0">
    <div class="case-study-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 col-xl-6 mx-auto text-md-center mb-4 mb-md-5">
                <h4 class="sub-title text-green">{{$data->knowledge_title}}</h4>
                <h3 class="title text-white">{{$data->knowledge_subtitle}}</h3>
                </div>
            </div>
            @if(count($KnowledgeSharing) > 0)
            <div class="row">
                @foreach($KnowledgeSharing as $knowledge)
                <div class="col-md-4">
                    <div class="case-item">
                        <a @if(session()->has('startup') || session()->has('pilot')) href="/knowledge_sharing/{{$knowledge->id}}" @endif >
                            <div class="case-img">
                                <img src="{{ asset('uploads/knowledge_sharing') }}/{{ $knowledge->overview_image }}">
                                <img class="case-over" src="{{ asset('uploads/knowledge_sharing') }}/{{ $knowledge->banner_image }}">
                            </div>
                            <div class="case-text">
                                <div>
                                    <p>{{$knowledge->title}}</p>
                                    <span>{!! $knowledge->overview !!}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="col-12 text-center mt-4 mt-md-5">
                    <a @if(session()->has('startup') || session()->has('pilot')) href="{{env('APP_URL')}}/knowledge_sharing" @endif  class="btn btn-green">View All <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            @else
                <div class="row justify-content-center align-items-center" style="height: 300px;">
                    <div class="col-lg-6 text-center text-white card bg-primary">
                        <h2 class="py-3">Coming Soon</h2>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="case-black-space"></div>
</section>
<!-- Get In Touch -->
<section class="getInTouch sec-space">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h4 class="sub-title text-white">{{$data->s3_heading}}</h4>
                <h3 class="title text-white mb-3 mb-md-4">{{$data->s3_title}}</h3>
                <div class="text-white">{!! $data->s3_description !!}</div>
                <a href="mailto:support@acma.in" class="text-big text-white"><b>{{$data->s3_email}}</b></a>
            </div>
            <div class="d-none d-xl-inline-block col-xl-2"></div>
            <div class="col-md-6 col-xl-4">
                <div class="footer-form">
                    <h3 class="title text-white">{{$data->s3_contact_heading}}</h3>
                    <div class="text-white"><i>{{$data->s3_contact_subheading}}</i></div>
                    <form name="contact">
                        @csrf()
                        <input type="text" class="form-control mb-3" name="name" placeholder="Name" required>
                        <input type="email" class="form-control mb-3"  name="email" placeholder="Email" required>
                        <textarea class="form-control mb-4" name="message" cols="30" rows="5" placeholder="Message" required></textarea>
                        <button type="submit" class="btn btn-green">Submit <i class="bi bi-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    document.forms.contact.addEventListener("submit", event => {
        event.preventDefault();
        const fd = new FormData(event.target);
        commonAjax({
            page: 'contact',
            params: fd
        })
        .then(response => {
            snackbar(response?.message || 'Something went wrong! Try again later')
            event.target.reset()
        })
        .catch(err => snackbar("Something went wrong! Try again later"))
    })
</script>
@endsection