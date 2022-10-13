@extends('frontend.layouts.app')
@section('css')
    <style>
        #appendlist input[type="radio"] {
            display: none;
        }

        .find-content {
            display: flex;
            align-items: center;
            border: 1px solid #07d3cb;
            border-radius: 5px;
        }

        .find-content .input-group input {

            border-radius: 0 5px 5px 0 !important;
        }

        .find-content .input-group input,
        .find-content .input-group span {
            border: none;
            padding: 10px 15px;
        }

        .find-content .input-group input:focus {
            box-shadow: none !important;
            outline: none !important;
            border: none !important;
        }

        .find-content .input-group input::placeholder {
            font-size: 14px;
            font-weight: 300;
        }

        .find-content button {
            padding: 6px 25px;
            border: 1px solid #fff;
            outline: none;
            background-color: #00d3cb;
            color: #fff;
            margin-left: 15px;
            border-radius: 5px;
        }

        .input-box span {
            font-size: 12px;

        }

        .input-box {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 5%;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
        }

        .pac-container {
            z-index: 9999;
        }

        .list-group-item {
            cursor: pointer !important;
        }

        .list-group-item label {
            cursor: pointer !important;
        }

        .list-group-item:hover {

            color: gray;
        }

        .icon-box img {
            width: 83px;
            height: 83px;

        }
    </style>
@endsection

@section('content')
    <!-- Banner Section Start  -->
    <div class="banner">
        <div class="item banner-img">
            <img src="{{ site()->banner_image }}" alt="" />
        </div>

        <div class="banner-content">
            <div class="container">
                <h1>Find Experts in <span>Trades</span></h1>
                <p>For moving and improving and everything in between</p>
                <div class="banner-search-wrap">
                    <select id="select_category">
                        <option value="all" default>All Categories</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->slug }}" data-slug="{{ $item->slug }}">{{ $item->name }}</option>
                        @endforeach


                    </select>
                    <div class="input-box">
                        <input type="text" placeholder="Search service here..." readonly onclick="inputClick()" />
                    </div>
                    <div class="serach-box">Search</div>
                </div>
                <p>or <a href="#">find and expert by name</a></p>
            </div>
        </div>
    </div>
    <!-- Banner Section End  -->

    <!-- Modal -->


    <!-- Experts Section Start  -->
    <div class="experts mt-5 pt-5 mb-5">
        <div class="container">
            <h2 class="common-section-heading">Get your <span>experts</span></h2>
            <div id="experts-carousel" class="owl-carousel owl-theme">
                @foreach ($categories as $item)
                    <a class="experts-item" onclick="showSearchModal('{{ $item->slug }}')">
                        <div class="icon-box">
                            <img src="{{ $item->icon }}" alt="" />
                        </div>
                        <h4>{{ $item->name }}</h4>
                    </a>
                @endforeach
                {{-- href="{{ route('search', ['c' => $item->slug]) }}" --}}

            </div>
        </div>
    </div>
    <!-- Experts Section End  -->

    <!-- featured section Start  -->
    <div class="featured-section mb-5">
        <div class="container">
            <h2 class="common-section-heading">Featured <span>Taskers</span></h2>
            <div class="row">
                @foreach ($companies as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ route('company.profile', $item->id) }}">
                            <div class="single-featured">
                                <div class="single-featured-img-box">
                                    <img src="{{ $item->logo }}" alt="" />
                                </div>
                                <div class="single-featured-content-box text-center mt-4">
                                    <h4>{{ $item->business_name }}</h4>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- featured section End  -->

    <!-- get started section start  -->
    <div class="get-started-section mb-5">
        <div class="container">
            <h2 class="common-section-heading text-center">
                Get Started <span>Now</span>
            </h2>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="single-get-started">
                        <div class="single-get-img-box employe"></div>
                        <div class="single-get-content-box text-center">
                            <p>
                                Join Now as an EMPLOYERS and hire world class professionals
                            </p>
                            <button onclick="inputClick()">Get a Quote</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="single-get-started">
                        <div class="single-get-img-box expertsimg"></div>
                        <div class="single-get-content-box text-center">
                            <p>Join as TRADE EXPERTS and start getting hired instantly</p>
                            <a href="{{ route('tasker.register.step1') }}" class="btn btn-primary text-white">Become a
                                Tasker</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="single-get-started">
                        <div class="single-get-img-box enpterprise"></div>
                        <div class="single-get-content-box text-center">
                            <p>Get registered as a COMPANY and server with us</p>
                            <a href="{{ route('tasker.register.step1') }}" class="btn btn-primary text-white">Register as
                                Company</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="searchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <span> What do you need this service to help with?</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('search') }}" id="searchForm" method="POST">
                        @csrf
                        <ul class="list-group list-group-flush" id="appendlist">

                        </ul>
                        <input type="hidden" name="c">

                        <div class="text-center catloading">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="find-content">
                            <div class="input-group input-box">
                                <span class="input-group-text">Find</span>
                                <input type="text" class="form-control" id="postalcode" required
                                    placeholder="Enter Postal Code" name="postal_code">
                                <input type="hidden" name="lat">
                                <input type="hidden" name="lng">
                                <div class="input-icon">
                                    <img src="/assets/images/elc/icon.gif" alt="" style="margin-bottom: 10px;">
                                </div>
                            </div>
                            <button type="submit">Search</button>
                        </div>

                    </form>



                </div>

            </div>
        </div>
    </div>
    <!-- get started section end -->
@endsection


@section('js')
    <script>
        $('.catloading').hide();
        const myModal = new bootstrap.Modal('#searchModal', {
            keyboard: false
        })

        function showSearchModal(category) {
            $('#appendlist').html(null)
            $('.find-content').hide()
            $('input[name="c"]').val(category)
            $('.catloading').show();
            var link = "{{ route('search', ['c' => 'category', 's' => 'subcategory']) }}"
            $.post("{{ route('tasker.register.getSubCategory') }}", {
                _token: "{{ csrf_token() }}",
                id: category
            }, function(data) {

                $('.catloading').hide();
                if (category === 'all') {
                    data.forEach(element => {
                        const exdata = JSON.stringify(element)
                        $('#appendlist').append(
                            `<li class="list-group-item" onclick="showSearchModal('${element.slug}')">${element.text}</li>`
                        )
                    });
                } else {
                    data.forEach(element => {
                        $('#appendlist').append(
                            ` <li class="list-group-item">
                              <input type="radio" name="s" value="${element.id}" id="r${element.id}" onclick="selectSubCategory(${element.id})">
                             <label for="r${element.id}"> ${element.text} </label>
                          </li>`
                        )
                    });
                }

                $('#searchModal').modal('show');

            });

            myModal.show()
        }

        function selectSubCategory(id) {
            var subcategory = $('input[name="s"]:checked')
            subcategory.parent().addClass('active')
            subcategory.parent().siblings().removeClass('active')
            $('#appendlist').attr('style', 'display:none')
            $('.find-content').show()
        }

        $('#searchForm').submit(function(e) {
            e.preventDefault();
            var data = $(this).serializeArray()
            var lat = data.find(d => d.name == 'lat').value
            if (lat == '') {
                alert('Please enter valid postal code')
                return false
            }
            this.submit()
        })
    </script>

    <script>
        function initMap() {
            const input = document.getElementById("postalcode");
            const options = {
                componentRestrictions: {
                    country: "uk"
                },
                fields: ["address_components", "geometry", "icon", "name"],
                strictBounds: false,
                types: ["postal_code"],
            };
            const autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                var code = place.address_components.find(function(item) {
                    return item.types.includes('postal_code');
                });
                var town = place.address_components.find(function(item) {
                    return item.types.includes('postal_town');
                });
                input.value = code.long_name;
                $('input[name="lat"]').val(place.geometry.location.lng());
                $('input[name="lng"]').val(place.geometry.location.lat());

            });
        }
    </script>
    <script>
        const myModalEl = document.getElementById('searchModal')
        myModalEl.addEventListener('hidden.bs.modal', event => {
            $('#appendlist').attr('style', 'display:block')
            $('.find-content').hide()
            $('#appendlist').html(null)
        })


        function inputClick() {
            var catinput = $('#select_category')
            const category = catinput.find(':selected').data('slug')
            showSearchModal(catinput.val())


        }
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNLzN1W7LEWXFF8ssJPU7OZyh3e9-mUrM&libraries=places&callback=initMap">
    </script>
@endsection
