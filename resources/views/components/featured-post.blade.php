<div class="modal fade content-modal" id="featuredPostModal{{ $featuredPost->featured_content_id  }}" tabindex="-1">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="h-100 m-0">
          <div class="row h-100 p-0 m-0">

            <div class="col-md-8 p-0">

            {{----
              <!-- Start Image Sliders -->
              @if(!empty($featuredPost->images) && count($featuredPost->images) > 0)
              <div class="image-slider">
                <div id="postImageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                  <div class="carousel-inner">
                    @foreach($featuredPost->images as $image)
                    <div class="carousel-item @if($loop->first) active @endif">
                      <div class="d-flex justify-content-center text-center">
                        <img src="{{ asset('media/'.$image) }}" alt="Content Images">
                      </div>
                    </div>
                    @endforeach
                  </div>
                  @if(count($featuredPost->images) > 1)
                  <button class="carousel-control-prev" type="button" data-bs-target="#postImageCarousel" data-bs-slide="prev"><i class="fas fa-chevron-left carousel-control-prev-icon"></i></button>
                  <button class="carousel-control-next" type="button" data-bs-target="#postImageCarousel" data-bs-slide="next"><i class="fas fa-chevron-right carousel-control-next-icon"></i></button>
                  @endif
                </div>
              </div>
              @endif
              <!-- End Image Sliders -->
              -----}}


               <!-- Start Image Sliders -->
@if(!empty($featuredPost->images) && count($featuredPost->images) > 0)
<div class="image-slider">
  <div id="featuredPostImageCarousel{{ $featuredPost->featured_content_id  }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

    <!-- Carousel Indicators -->
    @if(count($featuredPost->images) > 1)
    <div class="carousel-indicators">
      @foreach($featuredPost->images as $key => $image)
        <button type="button" data-bs-target="#featuredPostImageCarousel{{ $featuredPost->featured_content_id  }}" data-bs-slide-to="{{ $key }}" @if($loop->first) class="active" @endif aria-label="{{ $key }}"></button>
      @endforeach
    </div>
    @endif

    <!-- Carousel Inner -->
    <div class="carousel-inner">
      @foreach($featuredPost->images as $key => $image)
      <div class="carousel-item @if($loop->first) active @endif">
        <div class="d-flex justify-content-center text-center">
          <img src="{{ asset('media/'.$image) }}" alt="Content Images">
        </div>
      </div>
      @endforeach
    </div>

    <!-- Carousel Controls -->
    @if(count($featuredPost->images) > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#featuredPostImageCarousel{{ $featuredPost->featured_content_id }}" data-bs-slide="prev"><i class="fas fa-chevron-left carousel-control-prev-icon"></i></button>
    <button class="carousel-control-next" type="button" data-bs-target="#featuredPostImageCarousel{{ $featuredPost->featured_content_id }}" data-bs-slide="next"><i class="fas fa-chevron-right carousel-control-next-icon"></i></button>
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
                    @if($featuredPost->store->profile_picture)
                    <img src="{{ asset('media/'.$featuredPost->store->profile_picture) }}" alt="{{ $featuredPost->store->business_name }}">
                    @endif
                    <a href="{{ route('store', $featuredPost->store->slug) }}" class="store-title">{{ $featuredPost->store->business_name }}</a>
                  </div>
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fa-solid fa-xmark"></i>
                  </button>
                </div>

                @if($featuredPost->description)
                <div class="content-description">
                  <p>{{ $featuredPost->description }}</p>
                </div>
                @endif

                <div class="mt-2 w-100">
                  <div class="d-flex justify-content-around content-action">

                    <a href="javascript:void(0);" id="likeContent" data-id="{{ $featuredPost->id }}" data-type="home_featured_post">
                      <i class="{{ $featuredPost->isPostLike() ? 'fas' : 'far' }} fa-heart"></i>
                      <span>{{ $featuredPost->postLikes()->count() }}</span>
                    </a>

                    <a href="javascript:void(0);" id="shareContent" data-url="{{ $shareUrl }}">
                      <i class="fas fa-share"></i>
                    </a>


                  </div>
                </div>

                <!-- Start Comments -->
                <div class="comments w-100">
                  <h6 class="py-3">Comments</h6>
                  <form action="javascript:void(0);" class="comment-form w-100" data-content="{{ $featuredPost->id }}" data-type="home_featured_post">
                    <textarea class="form-control" name="comment" placeholder="Enter your comment..." required></textarea>
                    <div class="text-end mt-2">
                      <button type="submit" class="btn btn-default submit-comment">Post</button>
                    </div>
                  </form>

                  <div class="comment-items" id="comments-list-{{ $featuredPost->id }}">
                    @if(!empty($featuredPost->postComments) && $featuredPost->postComments->count() > 0)
                    @foreach($featuredPost->postComments as $comment)
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