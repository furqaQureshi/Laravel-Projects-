@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Disclaimers</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="/disclaimers/create" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New Disclaimer</a>
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
                        <table id="disclaimerTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($disclaimers as $disclaimer)
                                <tr>
                                    <td>{{$disclaimer->id}}</td>
                                    <td>{{$disclaimer->detail}}</td>
                                    <td>{{$disclaimer->status}}</td>
                                    <td class="text-center">
                                        @if($disclaimer->status !== "Active")
                                            <a class="btn btn-success btn-xs" href="/disclaimers/{{$disclaimer->id}}/status/Active">Active</a>
                                        @else
                                            <a href="/disclaimers/{{$disclaimer->id}}/edit" class="btn btn-success btn-xs">Edit</a>
                                        @endif
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
                $("#disclaimerTable").DataTable({})
            });
        </script>
    @endpush
@endsection
