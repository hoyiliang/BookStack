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
    <div refs="page-comments@comment-count-bar" class="grid half left-focus v-center no-row-gap">
        <h5 refs="page-comments@comments-title">{{ trans_choice('entities.comment_count', $commentTree->count(), ['count' => $commentTree->count()]) }}</h5>
    </div>


    <div refs="page-comments@commentContainer" class="comment-container">
        <!-- @php $counter = 0 @endphp -->
        <!-- @foreach($commentTree->get() as $branch)
            @include('comments.comment-branch', ['branch' => $branch, 'readOnly' => false])
            @php $counter++ @endphp
            @if($counter == 5)
                <div refs="page-comments@hiddenComments" style="display: none;">
            @endif
        @endforeach -->
      

        @foreach(array_slice($commentTree->get(), 0, 5) as $branch)
            @include('comments.comment-branch', ['branch' => $branch, 'readOnly' => false])
        @endforeach
        <div class="text-right">
            <button refs="page-comments@show-more-button" type="button" id="show-more-btn" class="button outline">{{ trans('entities.show_more') }}</button>
        </div>
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

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var showMoreBtn = document.getElementById('show-more-btn');
        var commentContainer = document.querySelector('[refs="page-comments@commentContainer"]');

        if (showMoreBtn && commentContainer) {
            showMoreBtn.addEventListener('click', function () {
                // Toggle the visibility of all comments
                commentContainer.classList.toggle('show-all-comments');
                // Toggle the button text
                showMoreBtn.innerText = commentContainer.classList.contains('show-all-comments') ?
                    '{{ trans('entities.show_less') }}' :
                    '{{ trans('entities.show_more') }}';
            });
        }
    });
</script> -->

<!-- <script>
    function showMore(){
        console.log("In show more function")
        allComment = document.getElementById('all_container')
        fiveComment = document.getElementById('five_container')

        allComment.style.display = "block";
        fiveComment.style.display = "none";
    }
</script> -->

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("In show more function")
        var showMoreBtn = document.getElementById('show-more-btn');
        var allComment = document.getElementById('all_container');
        var fiveComment = document.getElementById('five_container');

        if (showMoreBtn && allComment && fiveComment) {
            showMoreBtn.addEventListener('click', function () {
                // Toggle the visibility of all comments
                allComment.style.display = 'block';
                fiveComment.style.display = 'none';

                // Optionally, you can add logic to toggle the button text
                // showMoreBtn.innerText = allComment.style.display === 'block' ?
                //     '{{ trans('entities.show_less') }}' : '{{ trans('entities.show_more') }}';
            });
        }
    });
</script> -->