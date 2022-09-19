@extends('layout.index')

@section('title') Startups @endsection

@section('body')
<!-- Hero Section -->
<section class="hero-banner sec-space" style="background-image: url({{env('APP_URL')}}/assets/images/startup_image_banner.jpg);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-8 mx-auto text-center text-white wow zoomIn">
               <h2 class="title text-white">{{$data->startup_login->fullname}}</h2>
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
            <li class="breadcrumb-item"><a href="{{ env('APP_URL').'/startups' }}">Startup</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
        </nav>
    </div>
</section>
<!-- Content Section -->
<div class="content-sec sec-space" data-cd="download">
    <div class="container">
        <div class="row">
            <div class="col-12 text-end">
                <a href="{{env('APP_URL')}}/admin/startup/downloadexcel/{{$data->id}}?_token={{ csrf_token() }}" class="btn btn-sm btn-outline-success mx-2" data-download="excel">Download Excel</a>
                <button type="button" class="btn btn-sm btn-outline-success" data-download="pdf">Download PDF</button>
            </div>
        </div>
        <div class="row" data-target="download-pdf">
            <div class="col-md-7 mb-3">
                <img src="{{ asset('storage/uploads/startup/Startup'.$data->id.'.jpg') }}" class="img-fluid" style="max-height: 300px">
                <h3 class="my-4 title">{{$data->company_name}}</h3>
                <h4 class="text-green">Overview</h4>
                <p>{!! $data->description !!}</p>
            </div>
            <div class="col-md-6 mb-4">
                <h4 class="text-green">Company Info</h4>
                <ul class="style1 list-none mt-4">
                    @if($data->website && $data->address != '' && $data->address != null)
                        <li><b>Website</b> <span><a href="{{$data->website ?? '-'}}" target="_blank">{{$data->website ?? '-'}}</a></span></li>
                    @endif
                    @if($data->industry && $data->industry != '' && $data->industry != null)
                        <li><b>Industry</b> <span>{{$data->industry ?? '-'}}</span></li>
                    @endif
                    @if($data->company_size && $data->company_size != '' && $data->company_size != null)
                        <li><b>Company size</b> <span>{{$data->company_size ?? '-'}}</span></li>
                    @endif
                    
                        <li><b>Location</b> <span>{{$data->address ?? '-'}}</span></li>
                        
                    @if($data->company_type && $data->company_type != '' && $data->company_type != null)
                        <li><b>Type</b> <span>{{$data->company_type ?? '-'}}</span></li>
                    @endif
                    @if($data->specialities && $data->specialities != '' && $data->specialities != null)
                        <li><b>Specialties</b> <span>{{$data->specialities ?? '-'}}</span></li>
                    @endif
                    
                    <li><b>Founded On</b> <span>{{$data->founded_on ?? '-'}}</span></li>
                    
                </ul>
            </div>
            <div class="col-md-6">
                
            </div>
            <!-- <div class="col-12 mt-3">
                <hr>
                <button class="btn btn-primary" data-cd="download-button">DOWNLOAD</button>
            </div> -->
        </div>
        <div class="row">
            <div class="col-12 my-3">
            @php
                $collateral = explode(",", $data->collateral);
            @endphp
            @if(count($collateral) > 0)
                <div class="row">
                    <div class="col-12">
                        <h4 class="my-3"><b>Marketing Collaterals</b></h4>
                    </div>
                </div>
                <div class="row">
                    @foreach($collateral as $c)
                    @if($c != '')
                        <div class="col-md-3">
                            <div class="shadow-sm">
                                <a href="{{ asset('storage/uploads/startup/'.$c) }}" target="_blank">
                                    <div class="d-flex align-items-center justify-content-center" style="height: 100px">
                                        <span style="opacity: 0.5">FILE</span>
                                    </div>
                                    <hr class="mb-0">
                                    <div class="text-center"><i class="bi bi-file-o mr-2"></i><small>{{$c}}</small></div>
                                </a>
                            </div>
                        </div>
                    @endif
                    @endforeach
                </div>
            @endif
        </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script>
        document.querySelector(`button[data-download="pdf"]`).addEventListener("click", event => {
            const htmlDATA = this.document.querySelector(`div[data-target="download-pdf"]`);
            let opt = {
                margin: 1,
                filename: 'startup.pdf',
                image: { type: 'jpeg', quality: 2 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a3' }//, orientation: 'landscape'
            };
            try {
                html2pdf().from(htmlDATA).set(opt).save();
            } catch(err) {
                console.log(err)
            }
        })
    </script>
@endsection