<!-- <style>
    /* Add the following CSS styles */

    .comment-container.show-all-comments .comment-branch {
        display: block;
    }

    .comment-container:not(.show-all-comments) .comment-branch:nth-child(n+6) {
        display: none;
    }
</style> -->

<section component="page-comments"
         option:page-comments:page-id="{{ $page->id }}"
         option:page-comments:created-text="{{ trans('entities.comment_created_success') }}"
         option:page-comments:count-text="{{ trans('entities.comment_count') }}"
         class="comments-list"
         aria-label="{{ trans('entities.comments') }}">
    <!-- <div refs="page-comments@comment-count-bar" class="grid half left-focus v-center no-row-gap">
        <h5 refs="page-comments@comments-title">{{ trans_choice('entities.comment_count', $commentTree->count(), ['count' => $commentTree->count()]) }}</h5>
    </div> -->


    <div refs="page-comments@commentContainer" class="comment-container">
        <!-- @php $counter = 0 @endphp -->
        <!-- @foreach($commentTree->get() as $branch)
            @include('comments.comment-branch', ['branch' => $branch, 'readOnly' => false])
            @php $counter++ @endphp
            @if($counter == 5)
                <div refs="page-comments@hiddenComments" style="display: none;">
            @endif
        @endforeach -->
      

        <!-- @if($commentTree->count() > 0)
            @foreach(array_slice($commentTree->get(), 0, 5) as $branch)
                @include('comments.comment-branch', ['branch' => $branch, 'readOnly' => false])
            @endforeach
            <div class="text-right">
                <button refs="page-comments@show-more-button" type="button" id="show-more-btn" class="button outline">{{ trans('entities.show_more') }}</button>
            </div>
        @endif -->
        @foreach(array_slice($commentTree->get(), 0, 5) as $branch)
            @include('comments.comment-branch', ['branch' => $branch, 'readOnly' => false])
        @endforeach

        @if($commentTree->count() > 5)
            <div class="text-right">
                <button refs="page-comments@show-more-button" type="button" id="show-more-btn" class="button outline">{{ trans('entities.show_more') }}</button>
            </div>
        @endif
    </div>


    <div refs="page-comments@all-comment-container" class="comment-container" hidden>
        @foreach($commentTree->get() as $branch)
            @include('comments.comment-branch', ['branch' => $branch, 'readOnly' => false])
        @endforeach
    </div>


    <!-- <div class="text-right">
        <button refs="page-comments@show-more-button" type="button" id="show-more-btn" class="button outline">{{ trans('entities.show_more') }}</button>
    </div> -->

    @if(userCan('comment-create-all'))
        @include('comments.create')
    @endif
    
    

</section>