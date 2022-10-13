@extends('frontend.layouts.app')


@section('css')
    <link rel="stylesheet" href="/assets/css/electric.css" />
    <link rel="stylesheet" href="/assets/css/account.css" />

    <style>
        .job-images img {
            height: 60px;
            width: 60px;
        }
    </style>
@endsection

@section('content')
    <!-- find section start  -->
    <div class="find-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="find-content">
                        <div class="input-group input-box">
                            <span class="input-group-text">Find</span>
                            <input type="text" class="form-control" placeholder="Electric Showers in BH16 6FA" />
                            <div class="input-icon">
                                <img src="/assets/images/elc/icon.gif" alt="" />
                            </div>
                        </div>
                        <button>Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- find section end -->


    <!-- content section start -->
    <div class="content-section mt-4 mb-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="accounttab col-md-12">
                    <div class="tab-top">
                        <a href="/user/dashboard" class="nav-link active">
                            <div class="image-link ">
                                <i class="fas fa-suitcase fa-3x"></i>
                                <span>Jobs</span>
                            </div>
                        </a>
                        <a href="/user/reviews" class="nav-link">
                            <div class="image-link">
                                <i class="fas fa-star fa-3x"></i>
                                <span>Reviews</span>
                            </div>
                        </a>
                        <a href="/user/profile" class="nav-link ">
                            <div class="image-link">
                                <i class="fas fa-user-circle fa-3x"></i>
                                <span>Account</span>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4 mt-3 card ms-2">
                        <div class="nav-pills card-body" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            {{-- php artisan route:list --}}
                            @foreach ($jobs as $item)
                                <div type="button" role="tab" id="job-pill{{ $item->id }}" data-bs-toggle="pill"
                                    data-bs-target="#job-pill{{ $item->id }}" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true">
                                    <div class="single-job mt-3" onclick="fetchjob({{ $item->id }})">
                                        <div class="job-detials">
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="text-black text-small mb-3 "> <i class="fas fa-clock "></i>
                                                    Awaiting tradespeople {{ $item->applied->count() }}</span>
                                            @endif

                                            <h5 class="fs-6 text-black">{{ $item->subcategory->name }} </h5>
                                            <p class="fs-6 text-black">{{ $item->description }}</p>
                                            <div class="d-flex justify-content-between mt-3 jobtext mb-3">
                                                <span class="text-black fw-normal fs-6" style="fs-16">Job created </span>
                                                <span class=" text-black fw-normal fs-6   ">
                                                    {{ $item->created_at->format('l h:m A') }}</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach




                        </div>
                    </div>



                    <div class="col-md-7 ms-2" id="jobDetials">

                    </div>
                </div>

            </div>

        </div>


    </div>

    <!-- content section end -->
@endsection

@section('js')
    <script>
        // append loader





        function fetchjob(id) {
            $('#jobDetials').html(
                '<div class="text-center mt-5"> <div class="spinner-border mt-5" role="status" style="width: 5rem; height: 5rem;"><span class="visually-hidden">Loading...</span>  </div></div>'
            );
            $.ajax({
                url: "{{ route('user.fetchjob') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#jobDetials').html(null)
                    $('#jobDetials').html(response);
                }

            });
        }
    </script>
    <script>
        var lastJob = 0;
        @if ($jobs->first())
            lastJob = {{ $jobs->first()->id }};
        @endif

        if (lastJob !== 0) {
            fetchjob(lastJob);
            $("#job-pill" + lastJob).addClass("active");
        }
    </script>
@endsection
