@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="/users/create" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New User</a>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$stats['totalUsers']}}</h3>

                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$stats['active']}}</h3>

                                <p>Total Active</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="/users?status=Active" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$stats['nonActive']}}</h3>
                                <p>Non Active</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="/users?status=Inactive" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
						@if (\Session::has('success'))
							<div class="alert alert-success">{!! \Session::get('success') !!}</div>
						@endif
						@if (\Session::has('error'))
							<div class="alert alert-danger">{!! \Session::get('error') !!}</div>
						@endif
                        <table id="userTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($users) > 0)
                                @foreach($users as $i => $user)
                                    <tr>
                                        <td>{{($i+1)}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{str_replace("_", " ", strtolower($user->roles()->first()['name']))}}</td>
                                        <td>{{$user->status}}</td>
                                        <td>
                                            <select class="form-control update-user-status" data-user-id="{{$user->id}}">
                                                <option value="ACTIVE" {{$user->status == "ACTIVE" ? 'selected': ''}}>Active</option>
                                                <option value="INACTIVE" {{$user->status == "INACTIVE" ? 'selected' : ''}}>In Active</option>
                                            </select>
                                        </td>
										<td>
											<a href="{{url('users/' . md5($user->id))}}" class="btn btn-primary">Edit</a>
										</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No record Found!
                                    </td>
                                </tr>
                            @endif
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
                $("#userTable").DataTable({})
            });
        </script>
    @endpush
@endsection
