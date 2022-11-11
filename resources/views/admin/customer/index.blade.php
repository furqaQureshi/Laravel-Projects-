@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customers</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="/customers/create" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New Customer</a>
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
                                <h3>{{$stats['totalCustomers']}}</h3>

                                <p>Total Customers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/customers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                            <a href="/customers?status=Active" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                            <a href="/customers?status=Inactive" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                                <th>Zip</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($customers) > 0)
                                @foreach($customers as $i => $customer)
                                    <tr>
                                        <td>{{($i+1)}}</td>
                                        <td>{{$customer->name}}</td>
                                        <td>{{$customer->email}}</td>
                                        <td>{{$customer->phone}}</td>
                                        <td>{{$customer->zip}}</td>
                                        <td>{{$customer->street.", ".$customer->city.", ".$customer->state.", ".$customer->country}}</td>
                                        <td>{{$customer->status}}</td>
                                        <td>
                                            <select class="form-control update-customers-status" data-user-id="{{$customer->id}}">
                                                <option value="ACTIVE" {{$customer->status == "ACTIVE" ? 'selected': ''}}>Active</option>
                                                <option value="INACTIVE" {{$customer->status == "INACTIVE" ? 'selected' : ''}}>In Active</option>
                                            </select>
                                        </td>
										<td>
											<a href="{{url('customers/' . md5($customer->id))}}" class="btn btn-primary">Edit</a>
										</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">
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
