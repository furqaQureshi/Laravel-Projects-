@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Course Q&A</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="/Q_A/create" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New Q&A</a>
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
                        <table id="QATable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Course</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($q_a as $record)
                                <tr>
                                    <td>{{$record->id}}</td>
                                    <td>{{$record->course->title}}</td>
                                    <td>{{$record->question}}</td>
                                    <td>{{$record->answer}}</td>
                                    <td class="text-center">
                                        <a href="/Q_A/{{$record->id}}/edit" class="btn btn-success btn-xs">Edit</a>
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
                $("#QATable").DataTable({})
            });
        </script>
    @endpush
@endsection
