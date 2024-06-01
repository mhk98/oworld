<!-- Modal -->
<div class="modal fade post-modal" id="postModal-{{ $post->id }}" tabindex="-1">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="post-item d-none d-lg-block">
          <div class="row">
            <div class="col-lg-8">

              <div class="post-slider">

                <div id="postImageCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                  <div class="carousel-inner">

                    @foreach($post->images as $image)
                    <div class="carousel-item @if($loop->first) active @endif">
                      <div class="d-flex justify-content-center text-center">
                        <img src="{{ asset('media/'.$image) }}" alt="Post Images">
                      </div>
                    </div>
                    @endforeach

                  </div>

                  @if(count($post->images) > 1)
                  <button class="carousel-control-prev" type="button" data-bs-target="#postImageCarousel{{ $post->id }}" data-bs-slide="prev">
                    <i class="fas fa-chevron-left carousel-control-prev-icon"></i>
                  </button>

                  <button class="carousel-control-next" type="button" data-bs-target="#postImageCarousel{{ $post->id }}" data-bs-slide="next">
                    <i class="fas fa-chevron-right carousel-control-next-icon"></i>
                  </button>
                  @endif

                </div>

              </div>

            </div>
            <div class="col-lg-4">
              <div class="post-dtls d-flex align-items-start flex-column bd-highlight ps-2 ps-lg-0 h-100">
                <div class="pb-4 d-flex justify-content-between w-100">
                  <div class="d-flex p-title">
                    <img src="{{ asset('media/'.$store->profile_picture) }}" alt="{{ $store->business_name }}">
                    <a href="{{ route('store', $store->slug) }}">{{ $store->business_name }}</a>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>

                {{---<p>{{ $post->description }}</p>---}}


                <div class="mt-2 w-100">
                  <div class="social d-flex justify-content-around">
                    <a href="javascript:void(0);" id="likePost{{ $post->id }}" data-id="{{ $post->id }}">
                      <i id="likeIcon{{ $post->id }}" class="{{ (auth()->check() && $post->isLike(auth()->id())) ? 'fas' : 'far' }} fa-heart"></i>
                      <span id="likeCount{{ $post->id }}">{{ $post->likes()->count() }}</span>
                    </a>

                    <a href="javascript:void(0);" id="shareContent" data-url="{{ route('store', $store->slug) }}">
                      <i class="fas fa-share"></i>
                    </a>
                  </div>
                </div>


                <div class="comments w-100">
                      <h6 class="py-3">Comments</h6>

                      <form action="javascript:void(0);" class="comment-form w-100" id="postComment">
    <textarea class="form-control" id="comment" name="comment" placeholder="Enter your comment..." required></textarea>
    <div class="text-end mt-2">
        <button type="submit" class="btn btn-info" id="commentNow">Post</button>
    </div>
</form>

<div id="comments-list">
@if($post->comments->count() > 0)
    @foreach($post->comments as $comment)
    <div class="comment-item mt-2">
        <div class="d-flex flex-row align-items-center py-2">
            {{--- <img src="{{ $comment->user->profile_picture }}" width="50" class="rounded-circle me-2" alt="{{ $comment->user->name }}"/> ---}}
            <div class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <span>{{ $comment->user->first_name }}</span>
                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                </div>
                <p class="text-justify comment-text mb-0">
                    {{ $comment->comment }}
                </p>
            </div>
        </div>
    </div>
    @endforeach
@endif
</div>


                  </div>

              </div>
            </div>
          </div>
        </div>

        <div class="post-item m-device d-lg-none">
          <div class="m-top d-flex justify-content-between">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            <h6>Post</h6>
            <p></p>
          </div>
          <div class="post-slider">

            <div id="postMobileImageCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

              <div class="carousel-inner">

                @foreach($post->images as $image)
                <div class="carousel-item @if($loop->first) active @endif">
                  <div class="d-flex justify-content-center text-center">
                    <img src="{{ asset('media/'.$image) }}" alt="Post Images">
                  </div>
                </div>
                @endforeach

              </div>

              @if(count($post->images) > 1)
              <button class="carousel-control-prev" type="button" data-bs-target="#postMobileImageCarousel{{ $post->id }}" data-bs-slide="prev">
                <i class="fas fa-chevron-left carousel-control-prev-icon"></i>
              </button>

              <button class="carousel-control-next" type="button" data-bs-target="#postMobileImageCarousel{{ $post->id }}" data-bs-slide="next">
                <i class="fas fa-chevron-right carousel-control-next-icon"></i>
              </button>
              @endif

            </div>

          </div>
          <div class="post-dtls">
            <div class="mt-auto w-100">
              <div class="social d-flex justify-content-around m-0 mb-2">
                
                <a href="javascript:void(0);" id="likePost{{ $post->id }}" data-id="{{ $post->id }}">
                  <i id="likeIcon{{ $post->id }}" class="{{ (auth()->check() && $post->isLike(auth()->id())) ? 'fas' : 'far' }} fa-heart"></i>
                  <span id="likeCount{{ $post->id }}">{{ $post->likes()->count() }}</span>
                </a>

                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#shareModal">
                  <i class="fas fa-share"></i>
                </a>

              </div>
            </div>
            <div class="d-flex">
              <div class="img">
                <img src="{{ asset('media/'.$store->profile_picture) }}" alt="{{ $store->business_name }}">
              </div>
              <p><a href="#">{{ $store->business_name }}</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('js')
<script>
  $(document).ready(function() {
    // Like / Unlike
    $(document).on('click', '[id^="likePost"]', function(event) {
      event.preventDefault();
      var postId = $(this).data('id');
      var token = '{{ csrf_token() }}';
      var url = '{{ route("user.likePost") }}';
      var likeIcon = $('#likeIcon' + postId);
      var likeCount = $('#likeCount' + postId);

      $.ajax({
        type: 'POST',
        url: url,
        data: {
          content_id: postId,
          _token: token
        },
        success: function(response) {
          // console.log(response);
          if (response.like) {
            likeCount.text(parseInt(likeCount.text()) + 1);
            likeIcon.removeClass('far').addClass('fas');
          } else if (response.unlike) {
            // Ensure like count doesn't go below 0
            var newLikeCount = parseInt(likeCount.text()) - 1;
            likeCount.text(newLikeCount >= 0 ? newLikeCount : 0);
            likeIcon.removeClass('fas').addClass('far');
          }
        },
        error: function(error) {
          console.error('Error:', error);
        }
      });
    });

    // Post Comment
    $('#postComment').submit(function(e) {
        e.preventDefault();
        
        var comment = $('#comment').val();
        var content_type = 'post';
        var content_id = '{{ $post->id }}';
        
        $.ajax({
            url: '{{ route("user.submitComment") }}',
            type: 'POST',
            data: {
                comment: comment,
                content_type: content_type,
                content_id: content_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                if(response.success) {
                    var newComment = `
                        <div class="comment-item mt-2">
                            <div class="d-flex flex-row align-items-center py-2">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>{{ Auth::check() ? Auth::user()->first_name : '' }}</span>
                                        <small>Just now</small>
                                    </div>
                                    <p class="text-justify comment-text mb-0">
                                        ${comment}
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#comments-list').append(newComment);
                    $('#comment').val('');
                } else {
                    $('#commentError').text(response.errors.comment[0]);
                    console.log('Comment submission failed');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
  });
</script>
@endpush