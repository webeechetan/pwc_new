@extends('layout.index')



@section('title') My Dashboard @endsection



@section('body')



@php

    $dateFilter = $aditionalFilter = '';

    if(Request::get('from')) $dateFilter .= "&from=".Request::get('from');

    if(Request::get('to')) $dateFilter .= "&to=".Request::get('to');



    if(Request::get('s_pending')) $aditionalFilter .= "&s_pending=".Request::get('s_pending');

    if(Request::get('s_interested')) $aditionalFilter .= "&s_interested=".Request::get('s_interested');

    if(Request::get('s_notinterested')) $aditionalFilter .= "&s_notinterested=".Request::get('s_notinterested');



    if(Request::get('m1_pending')) $aditionalFilter .= "&m1_pending=".Request::get('m1_pending');

    if(Request::get('m1_interested')) $aditionalFilter .= "&m1_interested=".Request::get('m1_interested');

    if(Request::get('m1_notinterested')) $aditionalFilter .= "&m1_notinterested=".Request::get('m1_notinterested');



    if(Request::get('m2_pending')) $aditionalFilter .= "&m2_pending=".Request::get('m2_pending');

    if(Request::get('m2_interested')) $aditionalFilter .= "&m2_interested=".Request::get('m2_interested');

    if(Request::get('m2_notinterested')) $aditionalFilter .= "&m2_notinterested=".Request::get('m2_notinterested');



    if(Request::get('final_pending')) $aditionalFilter .= "&final_pending=".Request::get('final_pending');

    if(Request::get('final_interested')) $aditionalFilter .= "&final_interested=".Request::get('final_interested');

    if(Request::get('final_notinterested')) $aditionalFilter .= "&final_notinterested=".Request::get('final_notinterested');

    

@endphp

<!-- Hero Section -->

<section class="hero-banner sec-space" style="background-image: url({{env('APP_URL')}}/assets/images/startup_image_banner.jpg);">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">

               <h2 class="title text-white">My Dashboard</h2>

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

            <li class="breadcrumb-item active" aria-current="page">My Dashboard</li>

        </ol>

        </nav>

    </div>

</section>

<!-- Content Section -->

<section class="content-sec sec-space overflow-hidden">

    <div class="container">

        <div class="row mb-5">

            <div class="col-md-12">

                <!-- |Date Filter| -->

                <form name="date" method="GET">

                    <div class="row justify-content-center align-items-end">

                        <div class="col-lg-4 mb-2">

                            <label>From</label>

                            <input type="date" name="from" required class="form-control" value="{{Request::get('from')}}">

                        </div>

                        <div class="col-lg-4 mb-2">

                            <label>To</label>

                            <input type="date" name="to" required class="form-control" value="{{Request::get('to')}}">

                        </div>

                        <div class="col-lg-2 mb-2 text-center">

                            <input type="submit" class="btn btn-sm btn-primary form-control">

                        </div>

                        <div class="col-lg-2 mb-2 text-center">

                            <a href="{{env('APP_URL')}}/startups" class="btn btn-secondary form-control">Reset</a>

                        </div>

                    </div>

                </form>

            </div>

            <!--

            <div class="col-md-6">

                @if(count($data_recent) !== 0)

                <small class="text-success">{{count($data_recent)}} New startup Added Today</small>

                <div class="row fw-bold text-center">

                    <div class="col"><small>IMAGE</small></div>

                    <div class="col"><small>COMPANY NAME</small></div>

                    <div class="col"><small>STATE</small></div>

                    <div class="col-12"><hr></div>

                </div>

                @foreach($data_recent as $key => $dR)

                    @php

                        if($key > 2) break;

                    @endphp

                    <div class="row text-center align-items-center">

                        <div class="col"><small><img src="{{asset('storage/uploads/startup/Startup'.$dR->id.'.jpg')}}" alt="ACMA PWC" class="img-fluid rounded-circle" style="width: 40px"></small></div>

                        <div class="col"><a href="{{ env('APP_URL') }}/startups/{{$dR->id}}"><small>{{$dR->company_name}}</small></a></div>

                        <div class="col"><small>{{$dR->state}}</small></div>

                    </div>

                @endforeach

                @endif



                @if(count($data_recent) === 0)

                    <small class="text-success">No Recent Startup Added</small>

                @endif

            </div>

-->

            <div class="col-sm-12 mt-3">

                <div class="row">

                    <div class="col-sm-6 mb-3">

                        <!-- | Result after Screening | -->

                        <div class="p-3 border shadow-sm">

                            <div class="mb-2">

                                <h5 class="mb-0">Stage 1: <span class="text-secondary">Screening Result</span></h5>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-primary p-2">

                                    <a href="{{env('APP_URL')}}/startups?s_pending=true{{$dateFilter}}" class=" text-white">

                                        Pending evaluation <span data-filter="s_pending">({{$s_pending}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card  bg-success p-2">

                                    <a href="{{env('APP_URL')}}/startups?s_interested=true{{$dateFilter}}" class=" text-white">

                                        Interested for 1st meeting <span data-filter="s_interested">({{$s_interested}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-danger p-2">

                                    <a href="{{env('APP_URL')}}/startups?s_notinterested=true{{$dateFilter}}" class=" text-white">

                                        Not Interested for 1st meeting <span data-filter="s_notinterested">({{$s_notinterested}})</span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 mb-3">

                        <!-- | Result after 1st Meeting | -->

                        <div class="p-3 border shadow-sm">

                            <div class="mb-2">

                                <h5 class="mb-0">Stage 2: <span class="text-secondary">1st Meeting Result</span></h5>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-primary p-2">

                                    <a href="{{env('APP_URL')}}/startups?m1_pending=true{{$dateFilter}}" class="text-white">

                                        Pending evaluation <span data-filter="m1_pending">({{$m1_pending}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-success p-2">

                                    <a href="{{env('APP_URL')}}/startups?m1_interested=true{{$dateFilter}}" class="text-white">

                                        Interested for 2nd meeting <span data-filter="m1_interested">({{$m1_interested}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-danger p-2">

                                    <a href="{{env('APP_URL')}}/startups?m1_notinterested=true{{$dateFilter}}" class="text-white">

                                        Not Interested for 2nd meeting <span data-filter="m1_notinterested">({{$m1_notinterested}})</span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6 mb-3">

                        <!-- | Result after 2nd Meeting | -->

                        <div class="p-3 border shadow-sm">

                            <div class="mb-2">

                                <h5 class="mb-0">Stage 3: <span class="text-secondary">2nd Meeting Result</span></h5>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-primary p-2">

                                    <a href="{{env('APP_URL')}}/startups?m2_pending=true{{$dateFilter}}" class="text-white">

                                        Pending evaluation <span data-filter="m2_pending">({{$m2_pending}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-success p-2">

                                    <a href="{{env('APP_URL')}}/startups?m2_interested=true{{$dateFilter}}" class="text-white">

                                        Interested for further discussion <span data-filter="m2_interested">({{$m2_interested}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-danger p-2">

                                    <a href="{{env('APP_URL')}}/startups?m2_notinterested=true{{$dateFilter}}" class="text-white">

                                        Not Interested for further discussion <span data-filter="m2_notinterested">({{$m2_notinterested}})</span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6">

                        <!-- | Final Result | -->

                        <div class="p-3 border shadow-sm">

                            <div class="col-12 mb-2">

                                <h5 class="mb-0">Stage 4: <span class="text-secondary">Final Result</span></h5>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-primary p-2">

                                    <a href="{{env('APP_URL')}}/startups?final_pending=true{{$dateFilter}}" class="text-white">

                                        Pending evaluation <span data-filter="final_pending">({{$final_pending}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-success p-2">

                                    <a href="{{env('APP_URL')}}/startups?final_interested=true{{$dateFilter}}" class="text-white">

                                        Interested <span data-filter="final_interested">({{$final_interested}})</span>

                                    </a>

                                </div>

                            </div>

                            <div class="mb-1">

                                <div class="fs-6 card bg-danger p-2">

                                    <a href="{{env('APP_URL')}}/startups?final_notinterested=true{{$dateFilter}}" class="text-white">

                                        Not Interested <span data-filter="final_notinterested">({{$final_notinterested}})</span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-3 mb-4 mb-lg-0">

                <form name="startup">

                    <div class="sidebar">

                        <a id="filter" class="text-dark d-lg-none" href="javascript:void(0);">Filter <i class="fas fa-bars ms-2"></i> <i class="fas fa-times ms-2"></i></a>

                        <div class="sidebar-inner mt-3 mt-lg-0">

                            <div class="sidebar-item">

                                <h4 class="sidebar-title has-dropdown mb-0"><a href="javascript:void()"><span>Zone</span> <i class="bi bi-chevron-down"></i></a></h4>

                                <div class="sidebar-item-content">

                                    <div class="form-group">

                                        <div class="form-check mb-2">

                                            <input type="checkbox" class="form-check-input" name="zone[]" value="North" onclick="searchStartup()">

                                            <label class="form-check-label" for="check1">North</label>

                                        </div>

                                        <div class="form-check mb-2">

                                            <input type="checkbox" class="form-check-input" name="zone[]" value="South" onclick="searchStartup()">

                                            <label class="form-check-label" for="check2">South</label>

                                        </div>

                                        <div class="form-check mb-2">

                                            <input type="checkbox" class="form-check-input" name="zone[]" value="East" onclick="searchStartup()">

                                            <label class="form-check-label" for="check3">East</label>

                                        </div>

                                        <div class="form-check mb-2">

                                            <input type="checkbox" class="form-check-input" name="zone[]" value="West" onclick="searchStartup()">

                                            <label class="form-check-label" for="check4">West</label>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="sidebar-item">

                                <h4 class="sidebar-title has-dropdown mb-0"><a href="javascript:void()"><span>Country</span> <i class="bi bi-chevron-down"></i></a></h4>

                                <div class="sidebar-item-content">

                                    <input class="form-control search mb-2" type="search" placeholder="Find..." data-search="country">

                                    <div class="has-scroll">

                                        <div class="form-group" data-append="country">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="sidebar-item">

                                <h4 class="sidebar-title has-dropdown mb-0"><a href="javascript:void()"><span>State</span> <i class="bi bi-chevron-down"></i></a></h4>

                                <div class="sidebar-item-content">

                                    <input class="form-control search mb-2" type="search" placeholder="Find..." data-search="state">

                                    <div class="has-scroll">

                                        <div class="form-group" data-append="state">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="sidebar-item">

                                <h4 class="sidebar-title has-dropdown mb-0"><a href="javascript:void()"><span>City</span> <i class="bi bi-chevron-down"></i></a></h4>

                                <div class="sidebar-item-content">

                                    <input class="form-control search mb-2" type="search" placeholder="Find..." data-search="city">

                                    <div class="has-scroll">

                                        <!-- <center class="py-3 text-secondary" id="acmaNormalFilterTemp">Select State</center> -->

                                        <div class="form-group" data-append="city">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="col-lg-9">

                <div class="row">

                    <div class="col-12 text-end mb-1">

                        <form action="admin/startup/download?_token={{ csrf_token() }}" method="POST" name="downloadexcel">

                            <input type="hidden" name="startup" value="">

                            <button type="submit" class="btn btn-sm btn-success" data-download="excel">Download Excel</button>

                        </form>

                    </div>

                    <div class="col-12" data-append="startup-card">

                        <small class="py-4 text-center">Loading Data....Pls wait</small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection

@section('script')

<script>

    const reSetToken = (n) => {

        const myHeaders = new Headers();

        myHeaders.append("api-token", "kP6UVhJHppu8hjoPirrViYUkS7HsYdAWgDXTpnxYcQChRbP5kWT7hmHMUkU_MlrzNjg");

        myHeaders.append("Accept", "application/json")

        myHeaders.append('user-email', 'gejahom937@sejkt.com')

        commonAjax({

            page: '/api/getaccesstoken',

            header: myHeaders,

            addonUrl: 'https://www.universal-tutorial.com',

            type: 'GET'

        })

        .then(response => {

            localStorage.setItem("access-token", response.auth_token);

            getCollection(n)

        })

        .catch(err => localStorage.removeItem("access-token"))

    }



    const getCollection = (n, t) => {

        if(!localStorage.getItem("access-token")){

            reSetToken(n);

            return;

        } else

        {

            if(n === 'state' && t.checked === false) {

                const countryState = document.querySelectorAll(`div[data-country="${t.value}"]`);

                for(let i = 0; i < countryState.length; i++) countryState[i].remove();

                return;

            }

            if(n === 'city' && t.checked === false) {

                const stateCity = document.querySelectorAll(`div[data-state="${t.value}"]`);

                for(let i = 0; i < stateCity.length; i++) stateCity[i].remove();

                return;

            }

            let url =  '';

            if(n === 'country') url = 'countries/'

            else if(n === 'state') url = `states/${t.value}`

            else if(n === 'city') url = `cities/${t.value}`



            if(url === '') return;



            const myHeaders = new Headers();

            myHeaders.append("Authorization", `Bearer ${localStorage.getItem("access-token")}`);

            myHeaders.append("Accept", "application/json")

            commonAjax({

                page: url,

                header: myHeaders,

                addonUrl: 'https://www.universal-tutorial.com/api/',

                type: 'GET'

            })

            .then(response => {

                if(response?.error) {

                    reSetToken();

                    return false;

                }

                let collection = "";

                if(n === 'country')

                {

                    collection = "";

                    for(let i = 0; i < response.length; i++) collection += `<div><input type="checkbox" onclick="getCollection('state', this); searchStartup()" name="country[]" value="${response[i].country_name}"> ${response[i].country_name}</div>`;

                    document.querySelector(`div[data-append="country"]`).innerHTML = collection;

                }

                else if(n === 'state')

                {

                    collection = "";

                    for(let i = 0; i < response.length; i++) collection += `<div data-country="${t.value}"><input type="checkbox" onclick="getCollection('city', this); searchStartup()" name="state[]" value="${response[i].state_name}"> ${response[i].state_name}</div>`;

                    $(`div[data-append="state"]`).append(collection);

                }

                else if(n === 'city')

                {

                    collection = "";

                    for(let i = 0; i < response.length; i++) collection += `<div data-state="${t.value}"><input type="checkbox" name="city[]" onclick="searchStartup()" value="${response[i].city_name}"> ${response[i].city_name}</div>`;

                    $(`div[data-append="city"]`).append(collection);

                }



            })

            .catch(err => reSetToken(n))

        }

    }



    window.onload = () => {

        getCollection('country');

        searchStartup();

    }



    const giveVote = event => {

        // console.log("Give Vote => =>", event)

        // return false;

        if(!confirm(`Are you sure you want to continue?`)) return;

        const id = event.currentTarget.getAttribute('data-startup-id')

        let stage = event.currentTarget.getAttribute('data-startup-type')

        let name = event.currentTarget.getAttribute('data-startup-name');

        stage = (stage === 'screening' ? "Screening" : (stage === 'meeting1' ? "Meeting 1" : (stage === 'meeting2' ? "Meeting 2" : (stage === "finalcall" ? "Final Call" : false))));

        commonAjax({

            page: `startups/approved/${id}?_token={{ csrf_token() }}&approved=${event.currentTarget.getAttribute('data-startup-vote')}&stage=${event.currentTarget.getAttribute('data-startup-type')}`,

            type: 'GET'

        })

        .then(response => {

            snackbar(response?.message || "Something went wrong!")

            if(response.success)

            {

                let element = document.createElement('div');

                if(response.approved === 1) element.innerHTML = `<div class="text-end"><small class='text-success'>${name}: Interested</small></div>`

                else if(response.approved === 2) element.innerHTML = `<div class="text-end"><small class='text-danger'>${name}: Not Interested</small></div>`



                document.querySelector(`div[data-target-company="${id}"]`).appendChild(element);

                event.target.parentElement.parentElement.remove()

                searchStartup();

            }

        })

        .catch(err => console.log(err))

    }



    const searchStartup = event => {

        // event.preventDefault();

        document.querySelector(`div[ data-append="startup-card"]`).innerHTML = `<div class="py-3 text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

        <span class="visually-hidden">Loading...</span></div>`;

        const fd = new FormData(document.forms.startup);

        commonAjax({

            page: 'startups/search/view?_token={{ csrf_token() }}{{$dateFilter}}{{$aditionalFilter}}',

            params: fd

        })

        .then(response => {

            let element = '';

            document.forms.downloadexcel.startup.value = response.excelId.join(',')

            const data = response?.data || []

            for(let d of data) {

                element += `<div class="card ${(d.request === 1 ? 'border-success': (d.request === 2 ? 'border-danger' : d.request))}">

                    <div class="card-body">

                        <div class="row align-items-end">

                            <div class="col-lg-8">

                                <div class="card-body-left">

                                    <div><img src="{{ asset('storage/uploads/startup/Startup${d.id}.jpg') }}" class="img-fluid"></div>

                                    <div>

                                        <h5 class="mb-0 d-flex align-items-center justify-content-between">

                                            <a href="{{ env('APP_URL').'/startups/${d.id}' }}">${d.company_name}</a>

                                        </h5>`

                                        

                                        /* | Voting Stage | */

                                        if(d.screening.length === 0) element += getAction(d.id, 'screening', 'Stage 1')

                                        else if(d.meeting1.length === 0 && d.screening.length === 1 && d.screening[0].approved === 1) element += getAction(d.id, 'meeting1', 'Stage 2')//d.screening_count > 3 

                                        else if(d.meeting2.length === 0 && d.meeting1.length === 1 && d.meeting1[0].approved === 1) element += getAction(d.id, 'meeting2', 'Stage 3')//d.meeting1_count > 3

                                        else if(d.finalcall.length === 0 && d.meeting2.length === 1 && d.meeting2[0].approved === 1) element += getAction(d.id, 'finalcall', 'Stage 4')//d.meeting2_count > 3

                                        

                                        element += `<ul class="list-none mt-2">

                                            <li><span>Location:</span> ${d.address}</li>

                                        </ul>

                                        <ul class="list-none"><li><span>Industry:</span> ${d?.industry || '-'}</li></ul>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-4 mt-3 mt-lg-0">`



                            /* | Voting Status | */

                            element += `<div data-target-company="${d.id}">`

                                if(d.screening.length === 1) element += getStatus(d.screening[0], 'Stage 1')

                                if(d.meeting1.length === 1) element += getStatus(d.meeting1[0], 'Stage 2',)

                                if(d.meeting2.length === 1) element += getStatus(d.meeting2[0], 'Stage 3')

                                if(d.finalcall.length === 1) element += getStatus(d.finalcall[0], 'Stage 4')

                            element += `</div>`

                            

                            element += `<div class="card-body-right text-lg-end">

                                    <ul class="social-icons justify-content-lg-end">`

                                    if(d.website != '' && d.website != null) element += `<li><a href="${d.website}" target="_blank"><i class="bi bi-globe"></i></a></li>`;

                                    if(d.facebook != '' && d.facebook != null) element += `<li><a href="${d.facebook}" target="_blank"><i class="bi bi-facebook"></i></a></li>`;

                                    if(d.twitter != '' && d.twitter != null) element += `<li><a href="${d.twitter}" target="_blank"><i class="bi bi-twitter"></i></a></li>`

                                    if(d.instagram != '' && d.instagram != null) element += `<li><a href="${d.instagram}" target="_blank"><i class="bi bi-instagram"></i></a></li>`

                                    if(d.youtube != '' && d.youtube != null) element += `<li><a href="${d.youtube}" target="_blank"><i class="bi bi-youtube"></i></a></li>`       

                        element +=  `</ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </div> `;

            }

            if(element == '') {

                element = '<h3 class="text-secondary py-3 text-center">No Data Found</h3>'

            }

            document.querySelector(`div[ data-append="startup-card"]`).innerHTML = element

            manageListener()

            

            for (let [key, value] of Object.entries(response.filter)) {

                try{

                if(key !== 'data_recent') document.querySelector(`span[data-filter="${key}"]`).innerHTML = value

                } catch(err) {console.log(err)}

            }

        })

        .catch(err => console.log(err))

        

        function getAction(id, type, name) {

            return `<div>${name}:</div>`

        }

        function getStatus(s, t) {

            if(s.approved === 1) return `<div class="text-end"><small class="text-success">${t}: Interested</small></div>`;

            else if(s.approved === 2) return `<div class="text-end"><small class="text-danger">${t}:Not Interested</small></div>`;

        }

        function manageListener() {

            const vote = document.getElementsByClassName('_vote');

            for(let v of vote)

            {

                v.removeEventListener("click", giveVote);

                v.addEventListener("click", giveVote);

            }

        }

    }

    // document.forms.startup.addEventListener("submit", event => event.preventDefault())

    document.querySelector("input[data-search='country']").addEventListener("keyup", function () {

        if(this.value !== "") {

            $("input[name='country[]']").parent().hide();

            const countryList = document.querySelectorAll("input[name='country[]']");

            for(let i = 0; i < countryList.length; i++) {

                if(countryList[i].value.toLowerCase().includes(this.value)) {

                    countryList[i].parentElement.style.display = "block";

                }

            }

        } else {$("input[name='country[]']").parent().show();}

    });



    document.querySelector("input[data-search='state']").addEventListener("keyup", function () {

        if(this.value !== "") {

            $("input[name='state[]']").parent().hide();

            const stateList = document.querySelectorAll("input[name='state[]']");

            for(let i = 0; i < stateList.length; i++) {

                if(stateList[i].value.toLowerCase().includes(this.value)) {

                    stateList[i].parentElement.style.display = "block";

                }

            }

        } else {$("input[name='state[]']").parent().show();}

    });



    document.querySelector("input[data-search='city']").addEventListener("keyup", function () {

        if(this.value !== "") {

            $("input[name='city[]']").parent().hide();

            const stateList = document.querySelectorAll("input[name='city[]']");

            for(let i = 0; i < stateList.length; i++) {

                if(stateList[i].value.toLowerCase().includes(this.value)) {

                    stateList[i].parentElement.style.display = "block";

                }

            }

        } else {$("input[name='city[]']").parent().show();}

    });

</script>

@endsection