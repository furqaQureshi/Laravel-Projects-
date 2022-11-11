@extends('layouts.app')

@section('content')
	<div class="content-wrapper">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Edit Customer</h1>
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
								<h3 class="card-title">Edit Customer</h3>
							</div>
							<form action="/customers/{{md5($customer->id)}}" method="post">
								@csrf
								<div class="card-body">
									<div class="form-group">
										<label for="email">Name</label>
										<input type="text" name="name" class="form-control" id="name" placeholder="Enter name" autocomplete="off" value="{{$customer->name}}">
									</div>
									<div class="form-group">
										<label for="email">Email address</label>
										<input type="email" name="email" class="form-control" id="email" placeholder="Enter email" autocomplete="off" value="{{$customer->email}}">
									</div>
									<div class="form-group">
										<label for="phone">Phone</label>
										<input type="number" name="phone" class="form-control" id="phone" placeholder="Phone" autocomplete="off" value="{{$customer->phone}}">
									</div>
									<div class="form-group">
										<label for="street">Street</label>
										<textarea class="form-control" id="street" name="street" placeholder="Street" autocomplete="off">{{$customer->street}}</textarea>
									</div>
									<div class="form-group">
										<label for="city">City</label>
										<input class="form-control" id="city" name="city" placeholder="City" autocomplete="off" value="{{$customer->city}}">
									</div>
									<div class="form-group">
										<label for="zip">Zip Code</label>
										<input class="form-control" id="zip" name="zip" placeholder="Zip" autocomplete="off" value="{{$customer->zip}}">
									</div>
									<div class="form-group">
										<label for="state">State</label>
										<input type="text" class="form-control" name="state" id="state" placeholder="State" autocomplete="off" value="{{$customer->state}}">
									</div>
									<div class="form-group">
										<label for="country">Country</label>
										<input type="text" class="form-control" name="country" id="country" placeholder="Country" autocomplete="off" value="{{$customer->country}}">
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
							<form action="/customers/{{md5($customer->id)}}/update-password" method="post">
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
