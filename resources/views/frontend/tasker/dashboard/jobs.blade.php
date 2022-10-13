@extends('frontend.layouts.tasker')
@section('css')
    <link rel="stylesheet" href="/assets/css/electric.css" />
    <link rel="stylesheet" href="assets/css/skill.css" />
    <style>
        .member-card {
            width: 60% !important;
            margin: 0 auto;
        }

        .member-btn-box button {
            border: none;
            padding: 10px 15px;
            background-color: #00d3cb;
            color: #fff;
            font-size: 14px;
            border-radius: 5px;
        }

        @media only screen and (max-width: 490px) {
            .member-card {
                width: 95% !important;
                margin: 20px auto;
            }
        }
    </style>
@endsection
@section('page_title', 'My Skills')

@section('content')

    @foreach ($jobs as $item)
        <div class="single-comment">
            <div class="comment-content-box">

                <div class="comment-content">
                    <h5>{{ $item->subcategory->name }}</h5>
                    <h6>Name : {{ $item->name }}</h6>
                    <h6>Email : {{ $item->email }}</h6>
                    <p class="pb-3">{{ $item->post_code }}</p>
                    {{-- <p class="reviews pb-3">{{ $item->description }}</p> --}}
                    <div class="comment-button">

                        <button> <img src="/assets/images/elc/icon3.gif" alt="">{{ $item->phone }}</button>
                    </div>
                </div>
            </div>
            <div class="heart-icon">
                <img src="/assets/images/elc/heart icon.png" alt="">
            </div>

        </div>
    @endforeach




@endsection
