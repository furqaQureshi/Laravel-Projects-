@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit User</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @if (\Session::has('success'))
					<div class="alert alert-success">{!! \Session::get('success') !!}</div>
				@endif
				@if (\Session::has('error'))
					<div class="alert alert-danger">{!! \Session::get('error') !!}</div>
				@endif
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit User</h3>
                            </div>
                            <form action="/users/{{md5($user->id)}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" autocomplete="off" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" autocomplete="off" value="{{$user->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" name="phone" class="form-control" id="phone" placeholder="Phone" autocomplete="off" value="{{$user->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role" required>
                                            @foreach($roles as $role)
												
                                                <option value="{{$role->id}}"
													@if ($user_role->id == $role->id)
													selected="selected"
													@endif
													>{{ str_replace("_", " ", strtolower($role->name)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
					<div class="col-md-6">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Edit Password</h3>
							</div>
							<form action="/users/{{md5($user->id)}}/update-password" method="post">
								@csrf
								<div class="card-body">
									<div class="form-group">
										<label for="password">New Password</label>
										<input type="password" name="password" class="form-control" id="password" placeholder="Enter New Password" autocomplete="off">
									</div>
									<div class="form-group">
										<label for="cpassword">Confirm Password</label>
										<input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Enter Confirm Password" autocomplete="off">
									</div>
								</div>
								<div class="card-footer text-right">
									<button type="submit" class="btn btn-primary">Update Password</button>
								</div>
							</form>
						</div>
					</div>
                </div>
            </div>
        </section>
    </div>
@endsection
