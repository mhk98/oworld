<div class="modal fade content-modal" id="postModal{{ $post->post_id }}" tabindex="-1">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="h-100 m-0">
          <div class="row h-100 p-0 m-0">

            <div class="col-md-8 p-0">


            {{--- 
              <!-- Start Image Sliders -->
              @if(!empty($post->images) && count($post->images) > 0)
              <div class="image-slider">
                <div id="postImageCarousel{{ $post->post_id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

                <div class="carousel-indicators">
    <button type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="{{ $post->post_id }}"></button>
    <button type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide-to="1" aria-label="{{ $post->post_id }}"></button>
    <button type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide-to="2" aria-label="{{ $post->post_id }}"></button>
  </div>

                  <div class="carousel-inner">
                    @foreach($post->images as $image)
                    <div class="carousel-item @if($loop->first) active @endif">
                      <div class="d-flex justify-content-center text-center">
                        <img src="{{ asset('media/'.$image) }}" alt="Content Images">
                      </div>
                    </div>
                    @endforeach
                  </div>
                  @if(count($post->images) > 1)
                  <button class="carousel-control-prev" type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide="prev"><i class="fas fa-chevron-left carousel-control-prev-icon"></i></button>
                  <button class="carousel-control-next" type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide="next"><i class="fas fa-chevron-right carousel-control-next-icon"></i></button>
                  @endif
                </div>
              </div>
              @endif
              <!-- End Image Sliders -->
              ---}}

              <!-- Start Image Sliders -->
@if(!empty($post->images) && count($post->images) > 0)
<div class="image-slider">
  <div id="postImageCarousel{{ $post->post_id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

    <!-- Carousel Indicators -->
    @if(count($post->images) > 1)
    <div class="carousel-indicators">
      @foreach($post->images as $key => $image)
        <button type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide-to="{{ $key }}" @if($loop->first) class="active" @endif aria-label="{{ $key }}"></button>
      @endforeach
    </div>
    @endif

    <!-- Carousel Inner -->
    <div class="carousel-inner">
      @foreach($post->images as $key => $image)
      <div class="carousel-item @if($loop->first) active @endif">
        <div class="d-flex justify-content-center text-center">
          <img src="{{ asset('media/'.$image) }}" alt="Content Images">
        </div>
      </div>
      @endforeach
    </div>

    <!-- Carousel Controls -->
    @if(count($post->images) > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide="prev"><i class="fas fa-chevron-left carousel-control-prev-icon"></i></button>
    <button class="carousel-control-next" type="button" data-bs-target="#postImageCarousel{{ $post->post_id }}" data-bs-slide="next"><i class="fas fa-chevron-right carousel-control-next-icon"></i></button>
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
                    @if($post->store->profile_picture)
                    <img src="{{ asset('media/'.$post->store->profile_picture) }}" alt="{{ $post->store->business_name }}">
                    @endif
                    <a href="{{ route('store', $post->store->slug) }}" class="store-title">{{ $post->store->business_name }}</a>
                  </div>
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                  </button>
                </div>

                @if($post->description)
                <div class="content-description" id="content-description-{{ $post->id }}">
                  <p>{{ $post->description }}</p>
                  @if($isContentOwner)
                  <a href="javascript:void(0);" class="edit-description-btn" data-content-id="{{ $post->id }}"><i class="fas fa-edit"></i></a>
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

                    <a href="javascript:void(0);" id="likeContent" data-id="{{ $post->id }}" data-type="post">
                      <i class="{{ $post->isLike() ? 'fas' : 'far' }} fa-heart"></i>
                      <span>{{ $post->likes()->count() }}</span>
                    </a>

                    <a href="javascript:void(0);" id="shareContent" data-url="{{ $shareUrl }}">
                      <i class="fas fa-share"></i>
                    </a>

                    @if($isContentOwner)
                    <a href="javascript:void(0);" id="deleteContent" data-type="post" data-id="{{ $post->id }}">
                      <i class="fas fa-trash"></i>
                    </a>
                    @endif


                  </div>
                </div>

                <!-- Start Comments -->
                <div class="comments w-100">
                  <h6 class="py-3">Comments</h6>
                  <form action="javascript:void(0);" class="comment-form w-100" data-content="{{ $post->id }}" data-type="post">
                    <textarea class="form-control" name="comment" placeholder="Enter your comment..." data-emojiable="true" data-emoji-input="unicode" required></textarea>
                    <div class="text-end mt-2">
                      <button type="submit" class="btn btn-default submit-comment">Post</button>
                    </div>
                  </form>

                  <div class="comment-items" id="comments-list-{{ $post->id }}">
                    @if(!empty($post->comments) && $post->comments->count() > 0)
                    @foreach($post->comments as $comment)
                    <div class="comment-item mt-2" id="comment-{{ $comment->id }}">
                      <div class="d-flex flex-row align-items-center py-2">
                        <div class="w-100">
                          <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $comment->user->first_name }}</span>
                            <div>
                              <small>{{ $comment->created_at->diffForHumans() }}</small>

                              @if($comment->isOwner())
                              <button class="btn btn-sm btn-default edit-comment" data-comment-id="{{ $comment->id }}">
                                <i class="fas fa-edit"></i>
                              </button>
                              <button class="btn btn-sm btn-default delete-comment" data-comment-id="{{ $comment->id }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                              <button class="btn btn-sm btn-default save-comment" data-comment-id="{{ $comment->id }}" style="display: none;">
                                <i class="fas fa-save"></i>
                              </button>
                              @endif

                            </div>
                          </div>
                          <p class="text-justify comment-text mb-0">{{ $comment->comment }}</p>
                          <textarea class="form-control comment-edit-box" style="display: none;"></textarea>
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