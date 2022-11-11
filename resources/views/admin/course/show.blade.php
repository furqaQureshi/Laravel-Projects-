@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Course Modules</h1>
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
                        @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                        <table id="coursesTable" class="table table-bordered table-striped">
                            <thead>
                                <a href="{{url('/courses/'.$course_id.'/modules/create')}}" class="btn btn-primary float-lg-right my-2">Add Course Module</a>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courseDetail->modules as $module)
                                <tr>
                                    <td>{{$module->id}}</td>
                                    <td>{{$module->title}}</td>
                                    <td>{{$module->detail}}</td>
                                    <td>{{$module->status}}</td>
                                    <td>
                                        <a href="/courses/{{$course_id}}/module/{{$module->id}}" class="btn btn-success btn-xs">View Details</a>
                                        | <a href="/courses/{{$course_id}}/module/{{$module->id}}/quiz" class="btn btn-primary btn-xs">View Quiz</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
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

     {{-- @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
        <style>
            .table-bordered tr.dt-rowReorder-moving td,
            .table-bordered tr.dt-rowReorder-moving th{}
            .table-striped tbody tr.dt-rowReorder-moving:nth-of-type(odd){background-color:#00000030;}
        </style>
    @endpush --}}

    {{-- @push('scripts')
        <script src="{{asset('assets/theme/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
        <script src="{{asset('assets/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        
        <script>
            $(function () {
                /*$("#coursesTable").DataTable({
                });*/

                var table = $('#coursesTable').DataTable( {
                    rowReorder: {
                        selector: 'tr'
                    },
                    columnDefs: [
                        { targets: 0, visible: false }
                    ]
                });

                table.on('row-reorder', function(e,diff,edit){
                    console.log(e, diff, edit);
                    /*for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                        $(diff[i].node).addClass("reordered");
                    }*/
                });

            });
        </script>
    @endpush --}}
@endsection
