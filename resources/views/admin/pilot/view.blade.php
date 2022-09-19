@extends('admin.layout.index')



@section('title') Admin @endsection



@section('body')

<div class="content-body">

<div class="container-fluid">

        <!-- Breadcrumbs -->

        <div class="row page-titles mx-0">

            <div class="col-sm-6 p-md-0">

                <div class="welcome-text">

                    <h4>{{ $data->name }}</h4>

                </div>

            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{env('APP_URL')}}/admin">Home</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Pilot</a></li>

                    <li class="breadcrumb-item active"><a href="javascript:void(0);">View Pilot</a></li>

                </ol>

            </div>

        </div>

    <!-- Content Section -->

    <div class="content-sec sec-space" data-cd="download">

        <div class="container">

            <div class="row"  data-target="download-pdf">

                <div class="col-12 text-end">

                     <a href="{{env('APP_URL')}}/admin/startup/downloadexcel/{{$data->id}}?_token={{ csrf_token() }}" class="btn btn-sm btn-outline-success mx-2" data-download="excel">Download Company Info</a> 

                    <button type="button" class="btn btn-sm btn-outline-success" data-download="pdf">Download PDF</button>

                </div>

                <div class="col-md-7 mb-3">

                    

                    <h3 class="my-4 title">{{$data->name}}</h3>

                  

                </div>

                <div class="col-md-12 mb-4">

                    <h4 class="text-green">Members </h4>

                    <ul class="style1 list-none mt-4">
        
                        @foreach($data->members as $member)
                            <hr>
                            <li><b>Name</b> {{ $member->name }}</li>
                            <li><b>Post</b>{{ $member->designation }} </li>
                            <li><b>Email</b>{{ $member->email }}</li>
                        @endforeach
                        

                    </ul>

                </div>

                
                <div class="col-12">
                    <hr>
                </div>

                <div class="col-12 text-end">

                    <button onclick="exportData()" class="btn btn-outline-success">Download Voting Info</button>

                </div>

                <!-- |Committee Member Id| -->


                <div class="col-md-6 mb-4 mt-4">

                    <div style="overflow: auto;">

                        <table id="dataTable" class="table table-light table-striped table-hover">

                            <div class="text-center">

                                <h3 class="mb-0">Start-Up Company Votes</h3>

                                <small class="mb-3 d-block">{{$data->company_name}}</small>

                            </div>

                            <thead class="table-primary">

                                <tr>

                                    <th class="border-0">SNO</th>

                                    <th class="border-0">Start-Up NAME</th>

                                    <th class="border-0">Vote</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <th class="text-center text-primary" colspan="3">Screening</th>

                                </tr>

                                @foreach($screening as $key => $vote)

                                <tr>

                                    <th>{{$key+1}}</th>

                                    <th>
                                        @if($vote->companyName)
                                            {{$vote ->companyName->company_name}}
                                        @endif
                                    </th>

                                    <th>

                                        @if($vote -> approved === 1)

                                            <span class="text-success">+ 1</span>

                                        @endif

                                        @if($vote -> approved === 2)

                                            <span class="text-danger">- 1</span>

                                        @endif

                                    </th>

                                </tr>

                                @endforeach

                                <tr>

                                    <th class="text-center text-primary" colspan="3">Meeting 1</th>

                                </tr>

                                @foreach($meeting1 as $key => $vote)

                                <tr>

                                    <th>{{$key+1}}</th>

                                    <th>
                                    @if($vote->companyName)
                                        {{$vote ->companyName->company_name}}</th>
                                    @endif
                                    <th>

                                        @if($vote -> approved === 1)

                                            <span class="text-success">+ 1</span>

                                        @endif

                                        @if($vote -> approved === 2)

                                            <span class="text-danger">- 1</span>

                                        @endif

                                    </th>

                                </tr>

                                @endforeach
                               

                                <tr>

                                    <th class="text-center text-primary" colspan="3">Meeting 2</th>

                                </tr>

                                @foreach($meeting2 as $key => $vote)

                                <tr>

                                    <th>{{$key+1}}</th>

                                    <th>
                                    @if($vote->companyName)    
                                        {{$vote ->companyName->company_name}}</th>
                                    @endif
                                    <th>

                                        @if($vote -> approved === 1)

                                            <span class="text-success">+ 1</span>

                                        @endif

                                        @if($vote -> approved === 2)

                                            <span class="text-danger">- 1</span>

                                        @endif

                                    </th>

                                </tr>

                                @endforeach

                                
                                <tr>

                                    <th class="text-center text-primary" colspan="3">Final Call</th>

                                </tr>

                               

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- |Collateral| -->

            {{-- <div class="row">

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

                    @endif

                </div>

            </div> --}}

        </div>

    </div>

</div>

</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js" integrity="sha512-DaMQrMxgirR5T0Zu+d7EABoP1uD7e2Sv6OBjifMM8RADf1orW42COfJgwZ8xsLRV6NhgR/erzCfodeqJmA3NtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    function exportData(){

        let dataTable = document.getElementById('dataTable');

        let fptr = XLSX.utils.table_to_book(dataTable, {sheet: '{{$data->company_name}}'});

        XLSX.write(fptr, {

            bookType: 'xlsx',

            type: 'base64',

        }),

        XLSX.writeFile(fptr, `{{$data->company_name}} (voting info).xlsx`);

    }

    

</script>



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