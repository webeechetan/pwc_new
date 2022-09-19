@extends('layout.index')

@section('title') Events @endsection

@section('body')
<!-- Hero Section -->
@if($recent && file_exists('storage/uploads/event/EventBanner'.$recent->id.'.jpg'))
<section class="hero-banner sec-space" style="background-image: url({{ asset('storage/uploads/event/EventBanner'.$recent->id.'.jpg') }}); background-size: cover;">
@else
<section class="hero-banner sec-space" style="background-image: url({{ asset('assets/images/eventtt.jpg') }});">
@endif
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">
                <h2 class="title text-white mb-3 mb-md-4">@php echo $recent ? $recent->title : 'No Recent Event' @endphp</h2>
                @if($recent)
				<ul class="list-inline list-none justify-content-center mb-4">
                    <li class="bg-dark py-1 px-3">Duration: <b>@php echo $recent ? $recent->duration : '-'  @endphp</b></li>
                </ul>
				@endif
                <ul class="list-inline btn-group list-none justify-content-center mb-4">
					@if($recent)
						<li><a href="{{env('APP_URL')}}/event/{{$recent->id}}" class="btn btn-green">View Details</a></li>
						@if(($recent->event_from <= date('Y-m-d') && $recent->event_to >= date('Y-m-d')) || $recent->event_to > date('Y-m-d'))
						<li><button type="submit" class="btn btn-primary">Register</button></li>
						@endif
					@endif
                </ul>
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
            <li class="breadcrumb-item active" aria-current="page">Events List</li>
        </ol>
        </nav>
    </div>
</section>
<section class="content-sec sec-space">
	<div class="container">
		<div class="row">
			<div class="col-12 text-md-center">
				<h3 class="title text-primary mb-3 mb-md-4">View All Events</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 mb-4 mb-lg-0">
				<form name="event">
					<div id="sidebar" class="sidebar"> <a id="filter" class="text-dark d-lg-none" href="javascript:;">Filter <i class="fas fa-bars ms-2"></i> <i class="fas fa-times ms-2"></i></a>
						<div class="sidebar-inner mt-3 mt-lg-0">
							<div class="sidebar-item">
								<h4 class="sidebar-title has-dropdown mb-0 open"><a href="javascript:void()"><span>Years</span> <i class="bi bi-chevron-down"></i></a></h4>
								<div class="sidebar-item-content">
									<!--<input type="search" class="form-control search  mb-2" placeholder="Search..">-->
									<div class="has-scroll">
										<div class="form-group">
											<div class="form-check mb-2" data-es="category">
												<input type="checkbox" class="form-check-input" name="year[]" value="2021" onclick="searchEvent()">
												<label class="form-check-label" for="check1">2021</label>
											</div>
											<div class="form-check mb-2" data-es="category">
												<input type="checkbox" class="form-check-input" name="year[]" value="2022" onclick="searchEvent()">
												<label class="form-check-label" for="check1">2022</label>
											</div>
											<div class="form-check mb-2" data-es="category">
												<input type="checkbox" class="form-check-input" name="year[]" value="2023" onclick="searchEvent()">
												<label class="form-check-label" for="check1">2023</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="sidebar-item">
								<h4 class="sidebar-title has-dropdown mb-0 open"><a href="javascript:void()"><span>Month</span> <i class="bi bi-chevron-down"></i></a></h4>
								<div class="sidebar-item-content">
									<div class="form-group">
									    @php
									        $allMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
									        $allMonthsCount = 1;
									    @endphp
									    @foreach($allMonths as $aM)
										<div class="form-check mb-2">
											<input type="checkbox" class="form-check-input" name="month[]" value="@php echo $allMonthsCount++; @endphp" onclick="searchEvent()">
											<label class="form-check-label" for="check1">{{ $aM }}</label>
										</div>
										@endforeach
									</div>
								</div>
							</div>
							<div class="sidebar-item">
								<h4 class="sidebar-title has-dropdown mb-0 open"><a href="javascript:void()"><span>Fees</span> <i class="bi bi-chevron-down"></i></a></h4>
								<div class="sidebar-item-content">
									<div class="form-group">
										<div class="form-check mb-2">
											<input type="checkbox" class="form-check-input" name="type[]" value="free" onclick="searchEvent()">
											<label class="form-check-label" for="check1">Free</label>
										</div>
										<div class="form-check mb-2">
											<input type="checkbox" class="form-check-input" name="type[]" value="paid" onclick="searchEvent()">
											<label class="form-check-label" for="check1">Paid</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-lg-9 list-sec">
				<div class="row">
					<div class="col-12">
						<div class="text-center text-secondary h-25" style="display: none;" data-error="upcoming-event">
							<h5>No Event Found</h5>
						</div>
						<div class="event-list" data-container="upcoming-event"></div>
					</div>
				</div>
				<div class="row">
                    <div class="col-12 mt-0 mb-4">
                        <div class="title-line">
                            <h4 class="text-green m-0">Ongoing and Upcoming Events</h4>
                            <hr class="m-0">
                        </div>
                    </div>
					<div class="col-12">
						@if(count($upcoming) === 0)
						<div class="text-center text-secondary h-25" style="display: none;" data-error="past-event">
							<h5>No Event Found</h5>
						</div>
						@endif
						<div class="events slider-dots" data-append="up_event-card">
							@foreach($upcoming as $u)
							<!-- eventdefaultimage -->
							<div class="events-list">
								<div class="events-top">
									@if(file_exists('storage/uploads/event/Event'.$u->id.'.jpg'))
										<img src="{{ asset('storage/uploads/event/Event'.$u->id.'.jpg') }}">
									@else
										<img src="{{ asset('assets/images/eventdefaultimage.jpg') }}">
									@endif
									<div class="date-batch"><span>@php echo date('d', strtotime($u -> event_from)) @endphp</span>@php echo date('M', strtotime($u -> event_from))."<br>".date('Y', strtotime($u -> event_from)) @endphp</div>
								</div>
								<div class="events-bot">
									<div class="events-bot-top">
										<h4 class="events-title text-truncate">{{ $u -> title }}</h4>
									</div>
									<p style="height: 108px; overflow:hidden">{!! $u -> short_description !!}</p>
									<a href="{{env('APP_URL')}}/event/{{ $u->id }}" class="btn-link">Read More <i class="bi bi-arrow-right"></i></a>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
                <!--  -->
				<div class="row mt-3 mt-md-4">
                    <div class="col-12 mt-0 mb-4">
						<div class="title-line">
							<h4 class="text-green m-0">Past Events</h4>
							<hr class="m-0">
						</div>
					</div>
					<div class="col-12">
						@if(count($past) === 0)
						<div class="text-center text-secondary h-25" style="display: none;" data-error="past-event">
							<h5>No Event Found</h5>
						</div>
						@endif
						<div class="events slider-dots" data-append="re_event-card">
							@foreach($past as $p)
							<div class="events-list">
								<div class="events-top">
									@if(file_exists('storage/uploads/event/Event'.$p->id.'.jpg'))
										<img src="{{ asset('storage/uploads/event/Event'.$p->id.'.jpg') }}">
									@else
										<img src="{{ asset('assets/images/eventdefaultimage.jpg') }}">
									@endif
									<div class="date-batch"><span>@php echo date('d', strtotime($p -> event_from)) @endphp</span>@php echo date('M', strtotime($p -> event_from))."<br>".date('Y', strtotime($p -> event_from)) @endphp</div>
								</div>
								<div class="events-bot">
									<div class="events-bot-top">
										<h4 class="events-title text-truncate">{{$p->title}}</h4>
									</div>
									<p style="height: 108px; overflow:hidden">{!! $p->short_description !!}</p>
									<a href="{{env('APP_URL')}}/event/{{$p->id}}" class="btn-link">Read More <i class="bi bi-arrow-right"></i></a>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('script')
<script src="https://www.datejs.com/build/date.js" type="text/javascript"></script>
<script>
    const searchEvent = event => {
        // event.preventDefault();
        document.querySelector(`div[data-append="up_event-card"]`).innerHTML = `<div class="py-3 text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="visually-hidden">Loading...</span></div>`;
        document.querySelector(`div[data-append="re_event-card"]`).innerHTML = `<div class="py-3 text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="visually-hidden">Loading...</span></div>`;
        const fd = new FormData(document.forms.event);
        commonAjax({
            page: 'event/search/view?_token={{ csrf_token() }}',
            params: fd
        })
        .then(response => {
            if ($('.events').hasClass('slick-initialized')) {
                $('.events').slick('destroy');
            }
            let element = '';
            const upcoming = response?.upcoming || []
            const monthsArray = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            let eventDate = '';
            for(let d of upcoming) {
                eventDate = new Date(d.event_from);
                element += `<div class="events-list">
					<div class="events-top">
						<img src="{{ asset('storage/uploads/event/Event${d.id}.jpg') }}">
						<div class="date-batch">${eventDate.getDay()}</span><br>${monthsArray[eventDate.getMonth()]}<br>${eventDate.getFullYear()}</div>
					</div>
					<div class="events-bot">
						<div class="events-bot-top">
							<h4 class="events-title text-truncate">${d.title}</h4>
						</div>
						<p style="height: 108px; overflow:hidden">${d.short_description}</p>
						<a href="{{env('APP_URL')}}/event/${d.id}" class="btn-link">Read More <i class="bi bi-arrow-right"></i></a>
					</div>
				</div>`;
            }
            if(element == '') {
                element = '<h3 class="text-secondary py-3 text-center">No Data Found</h3>'
            }
            $(`div[data-append="up_event-card"]`).html(element)
            
            element = ''
            const past = response?.past || []
            for(let d of past) {
                eventDate = new Date(d.event_from);
                element += `<div class="events-list">
					<div class="events-top">
						<img src="{{ asset('storage/uploads/event/Event${d.id}.jpg') }}">
						<div class="date-batch">${eventDate.getDay()}</span><br>${monthsArray[eventDate.getMonth()]}<br>${eventDate.getFullYear()}</div>
					</div>
					<div class="events-bot">
						<div class="events-bot-top">
							<h4 class="events-title text-truncate">${d.title}</h4>
						</div>
						<p style="height: 108px; overflow:hidden">${d.short_description}</p>
						<a href="{{env('APP_URL')}}/event/${d.id}" class="btn-link">Read More <i class="bi bi-arrow-right"></i></a>
					</div>
				</div>`;
            }
            if(element == '') {
                element = '<h3 class="text-secondary py-3 text-center">No Data Found</h3>'
            }
            $(`div[data-append="re_event-card"]`).html(element)
            addSlickSlider();
        })
        .catch(err => console.log(err))
    }
    
    function addSlickSlider() {
        $('.events').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                  arrows: false,
                  centerMode: true,
                  centerPadding: '150px',
                  slidesToShow: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                  arrows: false,
                  centerMode: true,
                  centerPadding: '70px',
                  slidesToShow: 1
                }
            },
            {
                breakpoint: 576,
                settings: {
                  arrows: false,
                  centerMode: true,
                  centerPadding: '30px',
                  slidesToShow: 1
                }
            }
        ]
    });
    }
    
    window.onload = () => {
        if ($('.events').hasClass('slick-initialized')) {
            $('.events').slick('destroy');
        }
        addSlickSlider();
    }
</script>
@endsection