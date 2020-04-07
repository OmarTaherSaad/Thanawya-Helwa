@extends('layouts.app')
@section('title','Posts | Add a New Post')
@section('content')
<div id="app" class="m-2 text-center">
    <div class="row mt-2">
        <div class="col-12 my-2" v-if="alerts !== null">
            <div class="alert fade show" v-bind:class='{ "alert-success": alerts, "alert-danger": !alerts }' role="alert">
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
            <h2>Add a New Post</h2>
        </div>
    </div>
    <form action="{{ route('posts.store') }}" method="POST" id="postForm" v-on:submit.prevent="savePost">
        <div class="row justify-content-center">
            @csrf
            <div class="col-12 col-md-6">
                {{-- Tags --}}
                <div class="form-group">
                    <label>Tags</label>
                    <multiselect v-model="tags" :options="tagsOptions" taggable multiple
                        :close-on-select="false" :show-no-results="false" tagPosition="bottom" hide-selected
                        tag-placeholder="You cannot add values here" label="label" track-by="value"
                        placeholder="Select Tags"></multiselect>
                </div>

                <div class="form-group">
                    <label for="content">Post Content</label>
                    <textarea class="form-control" rows="10" name="content" v-model="post_content"></textarea>
                </div>

                <div class="form-group">
                  <label>Is this a "draft" or "final submission" ?</label>
                  <select class="form-control" name="isDraft" v-model="is_draft">
                    <option value="1">Draft</option>
                    <option value="0">Final Submission</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="cowriter">Co-writer</label>
                  <select class="form-control" name="cowriter" id="cowriter" v-model="cowriter">
                    <option value="" selected>No one</option>
                    @foreach($members as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                  </select>
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
    window.vueApp.$data.submitURL = $("#postForm").attr('action');
</script>
@endsection
