@extends('layouts.app')

@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Course Module Quiz</h1>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
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
				<div class="card">
					<div class="card-body">
						<div class="text-right mb-3">
							<button type="button" class="btn btn-primary" onclick="initAddQuiz()">Add New Quiz</button>
						</div>

						<table class="table table-striped">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Question</th>
									<th>Options</th>
									<th>Correct Answer</th>
									<th>Type of Answer</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($module->moduleQuiz as $i => $quiz)
								<tr>
									<td>{{($i+1)}}</td>
									<td>{{$quiz->question}}</td>
									<td>
										<ul>
										@foreach ($quiz->options as $option)
										<li>{{$option->option}}</li>
										@endforeach
										</ul>
									</td>
									<td>{{$quiz->correctOption->option	}}</td>
									<td>{{str_replace('_', ' ', $quiz->type)}}</td>
									<td>
										<a href="{{url('/courses/'.$course_id.'/module/'.$module->id.'/quiz/'.$quiz->id.'/delete')}}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove</a>
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

	
	<!-- Modal -->
	<div class="modal fade" id="addQuizModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Quiz</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
					<form action="/courses/{{$course_id}}/module/{{$module->id}}/quiz" method="post" id="addQuizForm">
						@csrf
						<div class="form-group">
							<label>Question</label>
							<input type="text" class="form-control" name="question" placeholder="Question">
						</div>
						<div class="form-group">
							<label>Type</label>
							<select name="type" class="form-control">
								<option value="SINGLE_SELECT">Single Select</option>
								<option value="MULTI_SELECT">Multi Select</option>
							</select>
						</div>

						<div class="row">
							<div class="col-sm-6"><label>Options</label></div>
							<div class="col-sm-6 text-right">
								<button type="button" class="btn btn-primary btn-sm mb-2" onclick="addOption()">Add Option</button>
							</div>
						</div>
						
						<table class="table table-striped table-bordered table-sm">
							<thead>
								<tr>
									<th>Correct</th>
									<th>Option</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="quizOptions">
								
							</tbody>
						</table>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" form="addQuizForm">Add Quiz</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /.content-wrapper -->
	@push('style')
		
	@endpush

	@push('scripts')
		<script>
			function initAddQuiz() {
				$('#quizOptions').html('');
				$('#addQuizModel').modal('show');

				addOption();
				addOption();
			}

			function addOption() {
				let i = $('#quizOptions > tr').length;

				if (i > 5) return; // max 6 options allowed

				let h = `
				<tr data-id="${i}">
					<td class="text-center"><input type="radio" name="is_correct" class="mt-2" value="${i}" required></td>
					<td><input type="text" class="form-control" placeholder="Options" name="options[]" required></td>
					<td><button type="button" class="btn btn-danger btn-block" onclick="removeOption(${i})">x</button></td>
				</tr>
				`;

				$('#quizOptions').append(h)
			}

			function removeOption(id) {
				$('#quizOptions > tr[data-id="'+id+'"]').remove();
			}
		</script>
	@endpush
@endsection
