@extends('layouts.app-members')
@section('title','Posts | Edit Post')
@section('content')
<div id="app" class="m-2 text-center">
    <div class="row mt-2">
        <div class="col-12 my-2" v-if="alerts !== null">
            <div class="alert fade show" v-bind:class='{ "alert-success": alerts, "alert-danger": !alerts }'
                role="alert">
                <ul>
                    <li v-if="Array.isArray(alertsList)" v-for="alert in alertsList">
                        <span v-for="miniAlert in alert">@{{ miniAlert }}<br></span>
                    </li>
                    <li v-if="!Array.isArray(alertsList)" v-for="alert in alertsList">@{{ alert }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 col-md-8">
            <h2>Edit Post</h2>
        </div>
    </div>
    <form action="{{ route('admins.approve-post',['post' => $post]) }}" method="POST" id="postForm"
        v-on:submit.prevent="approvePost" dir="rtl">
        @csrf
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                {{-- Tags --}}
                <div class="form-group">
                    <label>Tags</label>
                    <multiselect v-model="tags" :options="tagsOptions" taggable multiple :close-on-select="false"
                        :show-no-results="false" tagPosition="bottom" hide-selected
                        tag-placeholder="You cannot add values here" label="label" track-by="value"
                        placeholder="Select Tags"></multiselect>
                </div>
                <textarea class="form-control" rows="10" readonly class="m-2 p-2 bordered text-right">
                    {!! $post->get_content() !!}
                </textarea>
                <div class="form-group">
                    <label for="content">Post Content After Review</label>
                    <textarea class="form-control" rows="10" name="content" v-model="post_content"></textarea>
                </div>

                <div class="form-group">
                    <label>New State</label>
                    <select class="form-control" name="state" v-model="state">
                        @foreach (config('team.posts.status') as $key => $value)
                            <option value="{{ $value }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" v-if="this.state >= {{ config('team.posts.status.APPROVED') }}">
                    <label>Rating</label>
                    <input type="number" step="0.5" max="5" min="0" class="form-control" required name="rate" v-model="rate">
                </div>

                <div class="form-group" v-if="this.state == {{ config('team.posts.status.POSTED') }}">
                    <label>Facebook Link</label>
                    <input type="url" class="form-control" required name="fb_link" v-model="fb_link">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/post.js') }}"></script>
<script defer>
    window.vueApp.$data.tagsOptions = {!! $tags !!};
    window.vueApp.$data.tags = {!! $tagsSelected !!};
    window.vueApp.$data.post_content = `{!! $post->get_content() !!}`;
    window.vueApp.$data.state = {{ $post->state }};
    window.vueApp.$data.fb_link = 'https\:{{ $post->fb_link }}';
    window.vueApp.$data.rate = {{ $post->rate ?? 0 }};
    window.vueApp.$data.submitURL = $("#postForm").attr('action');
    window.vueApp.$data.redirectURL = "{{ route('admins.all-posts') }}";
</script>
@endsection
