@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">    
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col">
                        <h1 class="m-0">Edit Courses</h1>
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
                                <h3 class="card-title">Edit Courses</h3>

                            </div>
                            <form action="{{ url('courses/' .$course->id) }}" method="POST">
                                @csrf
                                @method('PUT')
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
                                            placeholder="Enter Title" autocomplete="off" value="{{ old('title', $course->title) }}">
                                           
                                        </div>
                                    <div class="form-group">
                                        <label for="description">Description <span>*</span> </label>
                                        <textarea name="description" class="form-control" placeholder="Course Description" rows="5">{{ old('Reason',$course->Reason) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="courseTypes">Course Types <span>*</span> </label>
                                        <select class="form-control" name="course_types" id="courseTypes">
                                            <option value="">Select course type</option>
                                            <option value="video" {{($course->course_types == "Video") ? 'selected' : ''}}>

                                                Video</option>
                                            <option value="pdf" {{($course->course_types == "PDF") ? 'selected' : ''}}>
                                                PDF
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update Course</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
