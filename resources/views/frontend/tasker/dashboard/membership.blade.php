@extends('frontend.layouts.tasker')
@section('css')
    <link rel="stylesheet" href="/assets/css/electric.css" />
    <link rel="stylesheet" href="assets/css/step2.css" />
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
{{-- @section('page_title', 'My Membership') --}}

@section('content')
    <div class="card h-100 member-card mt-4">
        @php
            $title = preg_split('/[\n\r]+/', $package->description);
            $features = array_slice($title, 1);
        @endphp
        <div class="card-body">
            {{-- <a href="step3.html" class="card-btn">Current {{ $package->name }}</a> --}}

            <div class="card-title-part">
                <h3>{{ $package->package }}</h3>
                <p>+ £{{ $package->price }} FUEL CARD</p>
            </div>
            <div class="card-price my-3">
                <p>Price</p>
                <h4> £{{ $package->price }}<span>/month</span></h4>
                <span>+VAT</span>
            </div>
            <div class="card-details">
                @isset($title[0])
                    <p>{{ $title[0] }}</p>
                @endisset
            </div>
            <div class="card-item-list">
                <ul>
                    @foreach ($features as $fe)
                        <li> {{ $fe }} </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="member-btn-box ">
            <button>Cancel</button>
            <button>Renew</button>
        </div>
    </div>
@endsection
