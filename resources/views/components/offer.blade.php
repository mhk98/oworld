<div class="modal fade content-modal" id="offerModal{{ $offer->offer_id }}" tabindex="-1">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="h-100 m-0">
          <div class="row h-100 p-0 m-0">

            <div class="col-md-8 p-0">

           {{----   <!-- Start Image Sliders -->
              @if(!empty($offer->images) && count($offer->images) > 0)
              <div class="image-slider">
                <div id="offerImageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                  <div class="carousel-inner">
                    @foreach($offer->images as $image)
                    <div class="carousel-item @if($loop->first) active @endif">
                      <div class="d-flex justify-content-center text-center">
                        <img src="{{ asset('media/'.$image) }}" alt="Content Images">
                      </div>
                    </div>
                    @endforeach
                  </div>
                  @if(count($offer->images) > 1)
                  <button class="carousel-control-prev" type="button" data-bs-target="#offerImageCarousel" data-bs-slide="prev"><i class="fas fa-chevron-left carousel-control-prev-icon"></i></button>
                  <button class="carousel-control-next" type="button" data-bs-target="#offerImageCarousel" data-bs-slide="next"><i class="fas fa-chevron-right carousel-control-next-icon"></i></button>
                  @endif
                </div>
              </div>
              @endif
              <!-- End Image Sliders -->
              ----}}


                <!-- Start Image Sliders -->
@if(!empty($offer->images) && count($offer->images) > 0)
<div class="image-slider">
  <div id="offerImageCarousel{{ $offer->offer_id  }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

    <!-- Carousel Indicators -->
    @if(count($offer->images) > 1)
    <div class="carousel-indicators">
      @foreach($offer->images as $key => $image)
        <button type="button" data-bs-target="#offerImageCarousel{{ $offer->offer_id  }}" data-bs-slide-to="{{ $key }}" @if($loop->first) class="active" @endif aria-label="{{ $key }}"></button>
      @endforeach
    </div>
@endif

    <!-- Carousel Inner -->
    <div class="carousel-inner">
      @foreach($offer->images as $key => $image)
      <div class="carousel-item @if($loop->first) active @endif">
        <div class="d-flex justify-content-center text-center">
          <img src="{{ asset('media/'.$image) }}" alt="Content Images">
        </div>
      </div>
      @endforeach
    </div>

    <!-- Carousel Controls -->
    @if(count($offer->images) > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#offerImageCarousel{{ $offer->offer_id }}" data-bs-slide="prev"><i class="fas fa-chevron-left carousel-control-prev-icon"></i></button>
    <button class="carousel-control-next" type="button" data-bs-target="#offerImageCarousel{{ $offer->offer_id }}" data-bs-slide="next"><i class="fas fa-chevron-right carousel-control-next-icon"></i></button>
    @endif
  </div>
</div>
@endif
<!-- End Image Sliders -->


            </div>


            <div class="col-md-4">
              <!-- Start Content Details -->
              <div class="content-details d-flex flex-column h-100">
                <div class="pb-4 d-flex justify-content-between w-100">
                  <div class="d-flex align-items-center">
                    @if($offer->store->profile_picture)
                    <img src="{{ asset('media/'.$offer->store->profile_picture) }}" alt="{{ $offer->store->business_name }}">
                    @endif
                    <a href="{{ route('store', $offer->store->slug) }}" class="store-title">{{ $offer->store->business_name }}</a>
                  </div>
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fa-solid fa-xmark"></i>
                  </button>
                </div>

                @if($offer->description)
                <div class="content-description" id="content-description-{{ $offer->id }}">
                  <p>{{ $offer->description }}</p>
                  @if($isContentOwner)
                  <a href="javascript:void(0);" class="edit-description-btn" data-content-id="{{ $offer->id }}"><i class="fas fa-edit"></i></a>
                  @endif
                </div>

                @if($isContentOwner)
                <form action="javascript:void(0);" id="edit-description-form-{{ $post->id }}" data-content-id="{{ $post->id }}" style="display: none;">
                  <textarea class="form-control" id="description-edit-box-{{ $post->id }}">{{ $post->description }}</textarea>
                  <button type="button" class="btn btn-sm btn-default btn-primary save-description mt-2" data-content-id="{{ $post->id }}" data-content-type="post">Save</button>
                </form>
                @endif
                @endif

                <div class="mt-2 w-100">
                  <div class="d-flex justify-content-around content-action">

                  <a href="javascript:void(0);" id="saveOffer" data-id="{{ $offer->id }}" data-type="offer">
                      <i class="{{ $offer->isSave() ? 'fas' : 'far' }} fa-bookmark"></i>
                    </a>

                    <a href="javascript:void(0);" id="likeContent" data-id="{{ $offer->id }}" data-type="offer">
                      <i class="{{ $offer->isLike() ? 'fas' : 'far' }} fa-heart"></i>
                      <span>{{ $offer->likes()->count() }}</span>
                    </a>

                    <a href="javascript:void(0);" id="shareContent" data-url="{{ $shareUrl }}">
                      <i class="fas fa-share"></i>
                    </a>

                    @if($isContentOwner)
                    <a href="javascript:void(0);" id="deleteContent" data-type="offer" data-id="{{ $offer->id }}">
                      <i class="fas fa-trash"></i>
                    </a>
                    @endif


                  </div>
                </div>

                <!-- Start Comments -->
                <div class="comments w-100">
                  <h6 class="py-3">Comments</h6>
                  <form action="javascript:void(0);" class="comment-form w-100" data-content="{{ $offer->id }}" data-type="offer">
                    <textarea class="form-control" name="comment" placeholder="Enter your comment..." required></textarea>
                    <div class="text-end mt-2">
                      <button type="submit" class="btn btn-default submit-comment">Post</button>
                    </div>
                  </form>

                  <div class="comment-items" id="comments-list-{{ $offer->id }}">
                    @if(!empty($offer->comments) && $offer->comments->count() > 0)
                    @foreach($offer->comments as $comment)
                    <div class="comment-item mt-2" id="comment-{{ $comment->id }}">
                      <div class="d-flex flex-row align-items-center py-2">
                        <div class="w-100">
                          <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $comment->user->first_name }}</span>
                            <div>
                              <small>{{ $comment->created_at->diffForHumans() }}</small>

                              @if($comment->isOwner())
                              <button class="btn btn-sm btn-danger delete-comment" data-comment-id="{{ $comment->id }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                              @endif

                            </div>
                          </div>
                          <p class="text-justify comment-text mb-0">{{ $comment->comment }}</p>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @endif
                  </div>

                </div>
                <!-- End Comments -->
              </div>
              <!-- End Content Details -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>