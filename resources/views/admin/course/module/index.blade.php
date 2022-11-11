@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Course Module</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
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
                        <div class="row">
                            <div class="col-md-6">
                                <form action="/courses/{{ $course_id }}/module/{{ $module->id }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $module->type }}">
                                    <div class="form-group">
                                        <label>Module Title</label>
                                        <input type="text" required class="form-control" placeholder="Module Title"
                                            value="{{ $module->title }}" name="module_title">
                                    </div>
                                    <div class="form-group">
                                        <label>Module Description</label>
                                        <textarea required name="module_details" class="form-control" placeholder="Module Description" rows="5">{{ $module->detail }}</textarea>
                                    </div>
                                    <input required type="file" name="url" accept="{{ $accept }}" >
                                    <div class="text-right">
                                        <a href="{{ url('courses/' . $course_id) }}" class="btn btn-link">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Module</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="embed-responsive embed-responsive-16by9">
                                    {{-- check the condition with input field --}}
                                    @if ($course->course_types == 'Video'){
                                    <video src="{{ $module->url }}" class="" controls></video>
                                    }
                                    @elseif($course->course_types == 'PDF'){

                                        <object width="400px" height="400px" data="{{$module->url }}"></object>
                                    }
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- @push('style')
		
	@endpush

	@push('scripts')
		<<script>
			$(function () {
				
			});
		</script>
	@endpush --}}
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
