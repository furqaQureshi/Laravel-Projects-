@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Courses</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">


            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $stats['courses'] }}</h3>
                                <p>Courses</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ url('/courses') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $stats['courseModules'] }}</h3>
                                <p>Course Modules</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ url('/courses') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                            <table id="coursesTable" class="table table-bordered table-striped">
                                <thead>
                                    <a href="{{ url('/courses/create') }}" class="btn btn-success float-right my-2">Add
                                        Courses</a>

                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $key => $course)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ strip_tags($course->description) }}</td>
                                            <td>{{ $course->status }}</td>
                                            <td>
                                                <a href="/courses/{{ $course->id }}"
                                                    class="btn btn-success btn-xs">View</a>
                                            </td>
                                            <td>
                                                <a href="/course/edit/{{ $course->id }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </section>
    </div>
    @push('style')
        <link rel="stylesheet" href="{{ asset('assets/theme/plugins/datatables/jquery.dataTables-1.12.1.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/theme/plugins/datatables/jquery.dataTables-1.12.1.min.js') }}"></script>
        <script>
            $(function() {
                $("#coursesTable").DataTable({})
            });
        </script>
    @endpush
@endsection
