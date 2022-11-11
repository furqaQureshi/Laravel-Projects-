@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add New Customer</h1>
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
                                <h3 class="card-title">Add New Customer</h3>
                            </div>
                            <form action="/customers" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" name="phone" class="form-control" id="phone" placeholder="Phone" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="street">Street</label>
                                        <textarea class="form-control" id="street" name="street" placeholder="Street" autocomplete="off"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input class="form-control" id="city" name="city" placeholder="City" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="zip">Zip Code</label>
                                        <input class="form-control" id="zip" name="zip" placeholder="Zip" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" name="state" id="state" placeholder="State" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" name="country" id="country" placeholder="Country" autocomplete="off">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
