@extends('layouts.app');
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col">
                        <h1 class="m-0">Module Courses</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card card-primary">
                           <div class="card-header">
                                <h3 class="card-title">Module Courses</h3>
                            </div>
                            <form action="{{ url('/courses/' . $course_id . '/module/add') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="type" value="{{ $course->course_types }}">
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Error</strong> Your Application Not SuccessFully<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="title">Title <span>*</span> </label>
                                        <input type="text" name="title" class="form-control" id="title"
                                            placeholder="Enter Title" autocomplete="off" value="{{ old('title') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description <span>*</span> </label>
                                        <textarea name="detail" class="form-control" placeholder="Course Description" rows="5">{{ old('detail') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Default file input example</label>
                                        <input class="form-control" type="file" name="url" id="formFile"
                                            accept="{{ $accept }}">
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">add Course Module</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection