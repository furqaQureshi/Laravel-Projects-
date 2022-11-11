@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Courses</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="panel panel-default">
                </div>
                <form action="{{ url('/course') }}" method="POST">
                    @csrf
                    <div class="row-12">
                        <div class="col">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add Courses</h3>
                                </div>
                                <form action="{{ url('/courses/create') }}" method="post">
                                    @csrf
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
                                            <label for="title">Title <span>*</span></label>
                                            <input type="text" name="title" class="form-control" id="title"
                                                placeholder="Enter Title" autocomplete="off" value="{{ old('title') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description <span>*</span></label>
                                            <textarea name="description" class="form-control" placeholder="Course Description" rows="5">{{old('description')}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="coures_type">Courses Types<span>*</span></label>
                                            <select class="form-control" name="course_types" id="exampleFormControlSelect1">
                                                <option value="">Select course type</option>
                                                <option value="video"
                                                    {{ old('course_types') == 'video' ? 'selected' : '' }}>Video
                                                </option>
                                                <option value="pdf" {{ old('course_types') == 'pdf' ? 'selected' : '' }}>
                                                PDF    
                                                </option>
                                            </select>

                                        </div>

                                    </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                </form>
            </div>
    </div>
    </div>
    </form>
    </div>
    </section>
    </div>
@endsection
