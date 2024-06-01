@if($highlightCategories->isNotEmpty())
<div class="highlight-categories owl-carousel owl-theme">
  @foreach($highlightCategories as $highlightCategory)
    @if($highlightCategory->highlights->isNotEmpty())
    <div class="highlight-category">
    <div class="highlight-gradient {{ $highlightCategory->allViewed() ? 'not-active' : '' }}">
      <div class="first-highlight" data-bs-toggle="modal" data-bs-target="#highlightModal{{ $highlightCategory->id }}">
        <img src="{{ asset('media/'.$highlightCategory->highlights->first()->thumbnail) }}" alt="{{ $highlightCategory->title }}">
      </div>
    </div>
      <h5>{{ $highlightCategory->title == 'Events and Entertainment' ? 'Events' : $highlightCategory->title }}</h5>
    </div>
    @endif
  @endforeach
</div>
@endif