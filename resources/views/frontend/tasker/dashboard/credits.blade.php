@extends('frontend.layouts.tasker')
@section('css')
    <link rel="stylesheet" href="/assets/css/electric.css" />
    <link rel="stylesheet" href="/assets/css/credit.css" />
    <style>
        .loader-wrapper {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999999999;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .loader-wrapper .loader {
            margin-top: 40vh;
            color: #00d3cb;
            height: 75px;
            width: 75px;

        }
    </style>

@endsection
@section('page_title', 'My Skills')

@section('content')
    <div class="account-details">
        <div class="account-details-header">
            <h2>Top Up Credits</h2>
            <h2>Available Credit: {{ $company->credit }} Points</h2>
        </div>
        <div class="text-center loader-wrapper">
            <div class="spinner-border loader" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <form action="" method="POST" id="topUpForm">
            @csrf
            <input type="hidden" name="stripeToken">
            <input type="hidden" name="key">
            <div class="account-details-content-area mt-4">
                <div class="account-details-content">
                    <div class="choose-amount-area">
                        <h5 class="account-details-content-heding">
                            Choose Amount (£) | <strong>1£ = {{ site()->credit_conversion }} Points</strong>
                        </h5>

                        <div class="choose-amount-box">
                            <div class="form-group">
                                <input type="radio" name="amount" value="20" id="20">
                                <label for="20">20</label>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="amount" value="50" id="50">
                                <label for="50">50</label>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="amount" value="100" id="100">
                                <label for="100">100</label>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="amount" value="200" id="200">
                                <label for="200">200</label>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="amount" value="500" id="500">
                                <label for="500">500</label>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="enable-area mb-3">
                        <h5 class="account-details-content-heding">
                            enable auto top-up
                        </h5>
                        <div class="enable-area-content">
                            <p>
                                Switching on auto top-up allows you to <br> automatically top
                                up your credits through your <br> preferred payment method
                                when credits run low.
                            </p>
                            <div class="check-box">
                                <input type="checkbox" name="" id="">
                            </div>
                        </div>
                    </div> --}}

                    <div class="choose-payment-method-area mb-3">
                        <h5 class="account-details-content-heding">
                            choose a payment method
                        </h5>
                        <div class="choose-payment-box row">


                            <label for="card" class="col-md-6 card-option">
                                <input type="radio" name="payment_method" value="card" id="card" checked>
                                <div class="single-payment">
                                    <i class="fa-regular fa-credit-card"></i>

                                    <span>Card</span>

                                </div>
                            </label>
                            {{-- <label for="Cheque" class="col-md-6 card-option">
                                <input type="radio" name="payment_method" value="Cheque" id="Cheque">
                                <div class="single-payment">
                                    <i class="fa-solid fa-money-check-dollar"></i>

                                    <span>Cheque or <br>
                                        Telegraphic transfer</span>

                                </div>
                            </label> --}}
                        </div>
                    </div>

                    <div class="select-payment-method">
                        <h5 class="account-details-content-heding">
                            Select Existing payment method
                        </h5>
                        <div class="select-payment-box">
                            <div id="card-element"></div>
                        </div>
                    </div>

                    <div class="top-up-btn-area my-5">
                        <a href="#">Cancel</a>
                        <button>Top Up</button>
                    </div>
                </div>

                <div class="account-details-summary-area">
                    <div class="account-details-summary-content">
                        <h4>Payment Summary</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>£{{ $item->amount }}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection


@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.loader-wrapper').hide();
        var stripe = Stripe(
            "{{ env('STRIPE_KEY') }}"
        );
        var elements = stripe.elements();
        var cardElement = elements.create('card', {
            style: {
                base: {
                    // "fontFamily": "Montserrat",
                    "color": "#32325D",
                    "border": "1px solid #ccc",
                    "fontWeight": 400,
                    "fontSize": "18px",
                    "fontSmoothing": "antialiased",
                    "::placeholder": {
                        "color": "#222222"
                    },
                    ":-webkit-autofill": {
                        "color": "#e39f48"
                    }
                },
                invalid: {
                    iconColor: '#FFC7EE',
                    color: '#FFC7EE',
                },
            },
        });
        var card = elements.getElement('card');
        card.mount('#card-element');

        function setOutcome(result) {


            if (result.token) {
                $('.overlayLoader').show()

                $('input[name="stripeToken"]').attr('value', result.token.id);
                // console.log(result)
                $.post("{{ route('payment.stripePost') }}", {
                    _token: "{{ csrf_token() }}",
                    ...result,
                    amount: $('input[name="amount"]:checked').val()
                }).then(res => {
                    $('.loader-wrapper').hide();
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'success',
                            text: res.message,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Redirect Soon",
                            closeOnConfirm: false
                        })
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                        $('.overlayLoader').hide()
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.message,
                        })
                        $('.overlayLoader').hide()
                    }
                })

            } else if (result.error) {

            }
        }
    </script>

    <script>
        $('#topUpForm').on('submit', function(e) {
            $('.loader-wrapper').show();
            e.preventDefault();
            var amount = $('input[name="amount"]:checked').val();
            var payment_method = $('input[name="payment_method"]:checked').val();
            if (amount == undefined) {
                alert('Please select amount');
                return false;
            }
            if (payment_method == undefined) {
                alert('Please select payment method');
                return false;
            }
            var options = {
                name: "{{ Auth::user()->name }}",
                address_country: "UK",
                address_zip: "{{ Auth::user()->post_code }}",
                email: "{{ Auth::user()->email }}",



            };
            stripe.createToken(card, options).then(setOutcome);

        })
    </script>
















@endsection
