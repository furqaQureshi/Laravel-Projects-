@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Announcements</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="/announcements/create" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New Announcement</a>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <table id="announcementsTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Course</th>
                                <th>Title</th>
                                <th>Detail</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($announcements as $announcement)
                                <tr>
                                    <td>{{$announcement->id}}</td>
                                    <td>{{$announcement->course->title}}</td>
                                    <td>{{$announcement->title}}</td>
                                    <td>{{$announcement->detail}}</td>
                                    <td class="text-center">
                                        -
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
    @push('scripts')
        <script src="{{asset('assets/theme/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/jszip/jszip.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/pdfmake/vfs_fonts.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-buttons/js/buttons.html5.min.js')}}."></script>
        <script src="{{asset('assets/theme/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('assets/theme/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
        <script>
            $(function () {
                $("#announcementsTable").DataTable({})
            });
        </script>
    @endpush
@endsection
