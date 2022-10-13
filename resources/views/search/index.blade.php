@extends('frontend.layouts.app')

@section('css')
    <link rel="stylesheet" href="/assets/css/electric.css" />
    <style>
        .comment-img-box img {
            width: 100px;
            height: 100px;
            margin-right: 5px;
            border-radius: 50%;
        }

        .comment-img-box {

            margin-right: 5px;
            border-radius: 50%;
        }

        .text-truncate {
            display: -webkit-box;
            max-width: 100% !important;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            white-space: inherit !important;
        }
    </style>
@endsection

@section('content')
    <!-- find section start  -->
    <div class="find-section py-5">
        <div class="container">
            <x-search />
        </div>
    </div>
    <!-- find section end -->

    <!-- driection section start  -->
    <div class="container">
        <div class="driection-part">
            {{-- <p>{{ $category->name }} In BH16 6FA(114)</p> --}}
            <p>{{ $category->name }} In {{ $session->postal_code }}({{ $companies->count() }})</p>
            <ul>
                <li><a href="#">Home > </a></li>
                <li><a href="#">{{ $category->name }} > </a></li>
                @if ($session->s)
                    <li><a href="#"> {{ $subcats->find($session->s)->name }}</a></li>
                @endif
                {{-- <li><a href="#">BH16 6FA</a></li> --}}
            </ul>
        </div>
    </div>
    <!-- driection section end  -->

    <!-- content section start -->
    <div class="content-section mt-4 mb-5 pb-5">
        <div class="container">
            <div class="row">
                <!-- sidebar section start  -->
                <div class="col-lg-4">
                    <div class="job-granted">
                        <div class="job-text d-flex align-items-center justify-content-around py-2">
                            <h3>
                                Your job, <br />
                                guaranteed
                            </h3>
                            <img src="/assets/images/elc/job.gif" alt="" />
                        </div>
                        <p>
                            If something goes wrong with your job, we'll help make it right.
                        </p>
                        <button>Find out more</button>
                    </div>

                    <div class="event-list mt-4">
                        <p>More In {{ $category->name }}</p>
                        <ul>
                            @foreach ($subcats as $item)
                                <li>
                                    <a
                                        href="{{ route('search', ['c' => $category->slug, 's' => $item->id]) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
                <!-- sidebar section end  -->
                <div class="col-lg-8">
                    <!-- describe section start  -->
                    <div class="describe-section">


                        <form action="{{ route('post-job') }}" method="POST">
                            @csrf
                            <h5>Describe your job:</h5>
                            <p>
                                Give us the details of your job and we'll send it to selected
                                specialist trades for you.
                            </p>

                            <textarea rows="4" cols="50" class="dtextarea" name="description"
                                placeholder="Please describe your job in detail and let the trade know when's the best time to contact you"></textarea>
                            <div class="min-char">
                                <p>Min characters: 10</p>
                                <p>0/500</p>
                            </div>
                            <div class="row mt-2 detailsBox">

                                <input type="hidden" name="subcategory_id" value="{{ $session->s }}">
                                <input type="hidden" name="subcategory_id" value="{{ $session->s }}">
                                <div class="">

                                    <div class="fs-5" style="margin-bottom: 12px;">Category:
                                        {{ $subcats->find($session->s)->name }}</div>
                                    <div class="fs-4" style="margin-bottom: 12px;">When would you like the job
                                        to start?</div>
                                    <div class="checkbox">
                                        <label class="sc-2f3239db-0 fXAJqH">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="start_time"
                                                    id="id1" value=" I'm flexible on the start date" checked>
                                                <label class="form-check-label" for="id1">
                                                    I'm flexible on the start date
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="start_time"
                                                    id="id2" value="It's urgent (within 48 hours)" checked>
                                                <label class="form-check-label" for="id2">
                                                    It's urgent (within 48 hours)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="start_time"
                                                    id="id3" value="Within the next week" checked>
                                                <label class="form-check-label" for="id3">
                                                    Within the next week
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="start_time"
                                                    id="id4" value="Within the next month" checked>
                                                <label class="form-check-label" for="id4">
                                                    Within the next month
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="start_time"
                                                    id="id5" value="I'm budgeting / researching" checked>
                                                <label class="form-check-label" for="id5">
                                                    I'm budgeting / researching
                                                </label>
                                            </div>




                                    </div>
                                    <div class="fs-4 mt-2" style="margin-bottom: 10px;">Tell us about you</div>


                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', auth()->user()->name) }}" placeholder="Name" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email"
                                            value="{{ old('email', auth()->user()->email) }}" name="email" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="tel" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="tel" name="phone"
                                            value="{{ old('phone', auth()->user()->phone) }}" placeholder="Phone Number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="postcode" class="form-label">Post Code</label>
                                        <input type="text" class="form-control" id="postcode" name="post_code"
                                            value="{{ old('post_code', auth()->user()->post_code) }}"
                                            placeholder="Post code">
                                    </div>


                                </div>
                                <div class="submit-btn text-center">
                                    <button type="submit" class="btn btn-primary">Request a quote</button>
                                </div>
                            </div>
                        </form>

                        <!-- describe section end -->
                        @foreach ($companies as $item)
                            <div class="single-comment">
                                <div class="guaranteed ">
                                    <img src="/assets/images/elc/Guaranteed icon.png" alt="">
                                    <p>Guaranteed</p>
                                </div>
                                <div class="comment-content-box">
                                    <div class="comment-img-box">
                                        <img src="/{{ $item->logo }}" alt="">
                                    </div>
                                    <div class="comment-content">
                                        <h5>{{ $item->business_name }}</h5>
                                        <h6>Operates in this area -
                                            {{ number_format((float) $item->distance, 2, '.', '') }}
                                            miles away</h6>
                                        {!! reviewCount($item) !!}

                                        <p class="text-truncate col-12 mb-2" style="max-width: 100vh;">
                                            {{ $item->business_description }}</p>
                                        <div class="comment-button">
                                            <a type="button" style="margin-left: 0px;"
                                                href="{{ route('post-job', ['c' => $category->id, 's' => request()->s, 'company' => $item->id]) }}">
                                                <img src="/assets/images/elc/icon2.gif" alt="">Request a
                                                quote
                                            </a>
                                            <a type="button" class="bg-black">
                                                <img src="/assets/images/elc/icon3.gif"
                                                    alt="">{{ $item->business_phone }}
                                            </a>


                                        </div>
                                    </div>
                                </div>
                                <div class="heart-icon">
                                    <img src="/assets/images/elc/heart icon.png" alt="">
                                </div>
                            </div>
                        @endforeach
                        <!-- single comment section start  -->

                        <!-- single comment section end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content section end -->
@endsection
@section('js')
    <script>
        $('.detailsBox').hide();
        $(document).ready(function() {
            $(".dtextarea").on('keyup', function() {
                var text = $(this).val();
                var textLength = text.length;
                var textLength = textLength + "/500";
                $(".min-char p:last-child").text(textLength);
                if (text.length !== 0) {
                    $('.detailsBox').show();
                } else {
                    $('.detailsBox').hide();
                }


            });



        });
    </script>
@endsection
