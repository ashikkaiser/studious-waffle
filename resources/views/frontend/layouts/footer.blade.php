  <footer>
      <div class="container">
          <div class="top-footer">
              <div class="row">
                  <div class="col-sm-6 col-lg-3">
                      <div class="single-footer-item">
                          <h3 class="footer-heading">Address</h3>
                          <ul> {!! nl2br(site()->address) !!} </ul>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                      <div class="single-footer-item">
                          <h3 class="footer-heading">Main menu</h3>
                          <ul>
                              @foreach (json_decode(site()->footer_links)->main as $item)
                                  <li>
                                      <a href="{{ $item->link }}" class="text-white">{{ $item->label }}</a>
                                  </li>
                              @endforeach
                          </ul>
                      </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                      <div class="single-footer-item">
                          <h3 class="footer-heading">Help</h3>
                          <ul>
                              @foreach (json_decode(site()->footer_links)->quick as $item)
                                  <li>
                                      <a href="{{ $item->link }}" class="text-white">{{ $item->label }}</a>
                                  </li>
                              @endforeach

                          </ul>
                      </div>
                  </div>

                  <div class="col-sm-6 col-lg-3">
                      <div class="single-footer-item">
                          <h3 class="footer-heading">Services</h3>
                          <ul>
                              @foreach (allCats() as $item)
                                  <li>{{ $item->name }}</li>
                              @endforeach


                          </ul>
                      </div>
                  </div>
              </div>
          </div>
          <div class="footer-bottom pt-5">
              <div class="left-section">
                  <ul class="d-flex align-center">
                      <li>Contacts</li>
                      <li>Privacy</li>
                      <li>Cookies</li>
                      <li>Terms</li>
                  </ul>
              </div>
              <div class="right-section">
                  <p>{{ site()->copy_right_text }}</p>
              </div>
          </div>
      </div>
  </footer>
  <!-- Jquery Js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
      integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>


  <!-- Boostrap Jquery -->
  <script src="/assets/js/bootstrap.bundle.min.js"></script>

  <!-- Owl carousel Js  -->
  <script src="/assets/js/owl.carousel.min.js"></script>
  <script src="/assets/js/swl.js"></script>

  <!-- Main JS  -->
  <script src="/assets/js/swiper-bundle.min.js"></script>

  <script src="/assets/js/main.js"></script>
