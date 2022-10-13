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
    {{-- <div class="single-comment">
        <div class="guaranteed ">
            <img src="assets/images/elc/Guaranteed icon.png" alt="">
            <p>Guaranteed</p>
        </div>
        <div class="comment-content-box">
            <div class="comment-img-box">
                <img src="assets/images/elc/comment1.gif" alt="">
            </div>
            <div class="comment-content">
                <h5>LEE Electrical Contracting</h5>
                <h6>Operates in this area - 4 miles away</h6>
                <p class="reviews">9.97 <span>(19 reviews)</span></p>
                <p>You're first choice Electrician! Fully registered NICEIC Approved Contractor- 15 years
                    experience within the industry. Offering high quality workmanship with competitive
                    prices and a reliable service</p>
                <div class="comment-button mt-2">
                    <button><img src="assets/images/elc/icon3.gif" alt="">00000 000 000</button>
                </div>
            </div>
        </div>
        <div class="heart-icon">
            <img src="assets/images/elc/heart icon.png" alt="">
        </div>
    </div> --}}

@endsection
