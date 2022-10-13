  <div class="row">
      <div class="card mt-3">
          <div class="card-body">
              <div class="card-body">
                  <div class="text-center text-black status-icon mb-2">
                      <i class="fas fa-clock fa-4x"></i>
                  </div>
                  @if ($job->applied->count())
                      <h6 class="text-center text-black mb-2">Tradespeople interested
                      </h6>
                      <p class="text-center fs-6" style="color: rgb(98, 104, 122);">
                          Check out the tradespeople ready to help while we keep searching for more.


                      </p>
                  @else
                      @if ($job->status == 'pending')
                          <h6 class="text-center text-black mb-2">Pending
                          </h6>
                          <p class="text-center fs-6" style="color: rgb(98, 104, 122);">
                              Your job is pending approval. We will notify you once it is approved.

                          </p>
                      @else
                          <h6 class="text-center text-black mb-2">Awaiting tradespeople</h6>
                          <p class="text-center fs-6" style="color: rgb(98, 104, 122);">
                              We are searching for the best local
                              matches for your job. You will receive an email every time suitable
                              tradespeople are interested in your job.
                          </p>
                      @endif
                  @endif




              </div>
              @if ($job->applied->count())
                  <div class="card">
                      <style>
                          .job-images {
                              width: 60px;
                              height: 60px;
                              object-fit: cover;
                              border-radius: 50%;
                          }

                          .job-images img {
                              border-radius: 50%;
                          }

                          .job-peoples {
                              /* border-bottom: 1px solid #e5e5e5; */
                              margin-bottom: 3px margin-top: 3px
                          }
                      </style>

                      <div class="card-body">
                          <h5>Interested tradespeople ({{ $job->applied->count() }})</h5>

                          @foreach ($job->applied as $applied)
                              <div class="job-peoples">
                                  <div class="d-flex" style="align-items: center;">
                                      <div class="job-images mt-2">
                                          <img src="/{{ $applied->company->logo }}" alt="">
                                      </div>
                                      <div class="d-flex">
                                          <div class="ms-3">
                                              <h6>{{ $applied->company->business_name }}</h6>
                                              <p>{{ $applied->company->reviews->count() }}
                                                  ({{ $applied->company->reviews->count() }} reviews)
                                              </p>
                                          </div>
                                      </div>


                                  </div>
                                  <div class="dflex justify-content-center mt-3  mb-3">
                                      <a href="{{ route('giveFeedbackCompany', $applied->company->id) }}"
                                          class="btn btn-info text-white">Leave a review</a>
                                      <a class="btn tasker-btn">
                                          <i class="fas fa-phone-alt"></i> {{ $applied->company->business_phone }}
                                      </a>
                                      @if (!$loop->last)
                                          <hr>
                                      @endif
                                  </div>

                              </div>
                          @endforeach

                      </div>


                  </div>
              @else
              @endif


              <hr>
              <div class="job-des">
                  <h6 class="text-black ">{{ $job->subcategory->name }}</h6>

                  <div class="d-flex justify-content-between mt-3 jobtext mb-3">
                      <span class="text-black fw-normal fs-6" style="fs-16">Job created </span>
                      <span class=" text-black fw-normal fs-6   ">{{ $job->created_at->diffForHumans() }}</span>
                  </div>

                  <p class="text-black jobtext mb-3"><strong>Start date :</strong> {{ $job->start_time }}
                  </p>
                  <p class="text-black jobtext mb-3"><strong>Postcode :</strong> {{ $job->post_code }}</p>
                  <p class="text-black jobtext mb-3"><strong>Request sent to :</strong>
                      @if ($job->company_id)
                          {{ $job->company->business_name }}
                      @else
                          multiple
                          tradespeople
                  </p>
                  @endif

              </div>

          </div>

      </div>
  </div>
