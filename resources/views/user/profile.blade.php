@extends('frontend.layouts.app')


@section('css')
    <link rel="stylesheet" href="/assets/css/electric.css" />
    <link rel="stylesheet" href="/assets/css/account.css" />
    {{-- <link rel="stylesheet" href="/assets/css/step1.css" /> --}}
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

    <!-- dashboard title start  -->
    {{-- <div class="dashboard-title mb-5">
        <h1 class="text-center text-black">Dashboard</h1>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div> --}}
    <!-- dashboard title end -->

    <!-- content section start -->
    <div class="content-section mt-4 mb-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="accounttab col-md-12">
                    <div class="tab-top">
                        <a href="/user/dashboard" class="nav-link">
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
                        <a href="/user/profile" class="nav-link active">
                            <div class="image-link">
                                <i class="fas fa-user-circle fa-3x"></i>
                                <span>Account</span>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="card ms-2">
                        <div class="card-body">

                            <div class="d-flex justify-content-center">
                                <div class="card col-md-5" style=" border: none">
                                    <div class="card-body">
                                        <h3 class="card-title  mb-3 text-capitalize">{{ Auth::user()->name }}</h3>
                                        <p class="card-subtitle mb-2 text-muted fs-5 mb-3">{{ Auth::user()->email }}</p>
                                        <p class="card-subtitle mb-2 text-muted fs-5 mb-3">{{ Auth::user()->phone }}</p>
                                        <p class="card-subtitle mb-2 text-muted fs-5 mb-3">{{ Auth::user()->post_code }}
                                        </p>




                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                                role="button" data-bs-toggle="modal" data-bs-target="#accountModel">
                                                Personal information
                                                <i class="fas fa-arrow-right"></i>
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                                role="button" data-bs-toggle="modal" data-bs-target="#passwordModel">
                                                Change password
                                                <i class="fas fa-arrow-right"></i>
                                            </li>

                                            {{-- Logout --}}
                                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                                role="a">
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                                <i class="fas fa-arrow-right"></i>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>


                                    </div>
                                </div>






                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>


    </div>



    <div class="modal fade" id="accountModel" tabindex="-1" aria-labelledby="accountModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountModelLabel">Edit your details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="" class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required
                                value="{{ explode(' ', Auth::user()->name)[0] }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Last Name</label>
                            <input type="text" name="last_name" required class="form-control"
                                value="{{ explode(' ', Auth::user()->name)[1] }}">

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required
                                value="{{ Auth::user()->email }}" readonly>

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" required
                                value="{{ Auth::user()->phone }}">

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Postcode</label>
                            <input type="tel" name="post_code" class="form-control" required
                                value="{{ Auth::user()->post_code }}">

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updateProfile" value="true" class="btn tasker-btn">Save
                        changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passwordModel" tabindex="-1" aria-labelledby="passwordModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModelLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">

                        <div class="mb-3">
                            <label for="" class="form-label">Old Password</label>
                            <input type="password" name="first_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">New password</label>
                            <input type="password" name="last_name" required class="form-control">

                        </div>
                        <div class="mb-3">
                            <label for="" password="form-label">Confirm password</label>
                            <input type="text" name="email" class="form-control" required readonly>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn tasker-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- content section end -->
@endsection

@section('js')
@endsection
