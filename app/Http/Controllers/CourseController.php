<?php


namespace App\Http\Controllers;


use App\Models\Course;	
use App\Models\CourseModule;
use App\Models\CourseModuleQuiz;
use App\Models\CourseModuleQuizOpts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index(){
		$stats = [
			"courses" => Course::where('status', 'Active')->count(),
			"courseModules" => CourseModule::where('status', 'Active')->count(),
		];

        $courses = Course::all();
        return view('admin.course.index', compact('courses', 'stats'));
    }

    public function show($id){
		$course_id = $id;
        $courseDetail = Course::with('modules')->where('id', $id)->first();
        return view('admin.course.show', compact('courseDetail', 'course_id'));
    }

	// courses start
	public function create()
	{
		$course = Course::all();
		return view('admin.course.addCourse', compact('course'));
	}
	public function store(Request $request){
		$validated = $request->validate([
			'title' => 'required',
			'description' => 'required',
			'course_types' => 'required',
		]);
		$course = new Course;
		$course->title = $request['title'];
		$course->description = $request['description'];
		$course->course_types = $request['course_types'];
		$course->save();
		return redirect()->route('courses.index')->with('message','Course add successfully.');
	}

	public function edit($id){
		$course = Course::find($id);
		return view('admin.course.editCourse',compact('course'));

	}
	public function update(Request $request, $id){
		$validated = $request->validate([
			'title' => 'required',
			'description' => 'required',
			'course_types' => 'required',
		]);
			$course = Course::find($id);
			$course->title = $request['title'];
			$course->description = $request['description'];
			$course->course_types = $request['course_types'];
			$course->save();
			return redirect(url('courses'))->with('message', 'Course Update Successfully.');
		}
		// coursesModules start 
		public function createModule($course_id){			
			$course = Course::find($course_id);
			$accept = "application/pdf";
			if($course->course_types == "Video"){
				$accept = "video/*";
			}
			return view('admin.course.module.create', compact('course_id', 'accept', 'course'));
		}
		public function addModule(Request $request, $course_id){
			$validated = $request->validate([
				'title' => 'required',
				'detail' => 'required',
				'url' => 'required',
			]);

			if ($request->file('url')) {
				$file = $request->file('url');
				
				$filenameWithExt = $request->file('url')->getClientOriginalName();
				$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
				$extension = $request->file('url')->getClientOriginalExtension();

				$fileNameToStore = time() .'_'. $filename . '.' . $extension;

				if($request->type == "Video"){
					$filePath = public_path() . '/uploads/courses/module/video/';
					$fileUrlToStore = asset('uploads/courses/module/video') .'/'. $fileNameToStore;
				}
				elseif ($request->type == "PDF"){
					$filePath = public_path() . '/uploads/courses/module/pdf/';
					$fileUrlToStore = asset('uploads/courses/module/pdf') .'/'. $fileNameToStore;
				}
				else {
					$filePath = public_path() . '/uploads/courses/module/';
					$fileUrlToStore = asset('uploads/courses/module') .'/'. $fileNameToStore;
				}
				if (!File::exists($filePath)) {
					File::makeDirectory($filePath);
				}

				 $file->move($filePath, $fileNameToStore);
			}

			$courseModule = CourseModule::where('course_id', $course_id)->orderBy('id', 'desc')->first();
			$orderCount = 1;
			if($courseModule) {
				$orderCount = ($courseModule->order + 1);
			}

			$module = CourseModule::create([
				"title" =>  $request->title,
				"detail" => $request->detail,
				"url" => $fileUrlToStore,
                "order" => $orderCount,
				"type" => $request->type,	
				'course_id' => $course_id,
			]);
	 	return redirect(url('courses/' . $course_id))->with('message', 'Course Module add Successfully.');
		}


		// module edit start
	public function showModules($course_id, $module_id) {
		$course = Course::find($course_id);
		$module = CourseModule::where('id', $module_id)->first();
		// module edit check the video and pdf
		    $accept = "application/pdf";
			if($course->course_types == "Video"){
				$accept = "video/*";
			}
		return view('admin.course.module.index', compact('module', 'course_id','course', 'accept'));
	}

	public function updateModule($course_id, $module_id, Request $request) {
		$course = Course::find($course_id);

		$module = CourseModule::where('id', $module_id)->first();

		if (!$module) {
			return redirect()->back()->with('error', 'Module not found');
		}
		// TODO: update file
		$validatedData = $request->validate([
			'module_title' => ['required'],
			'module_details' => ['required'],
			'url' => ['required'],
		]);
		// return $request;
		// save the video and pdf with folder save and url save the database
			if ($request->file('url')) {
			if($request->type == 'Video'){
				$fileUrlUpdate = public_path() . '/uploads/courses/module/video/' . basename($module->url);
			}
			elseif($request->type == 'PDF'){
				$fileUrlUpdate = public_path() . '/uploads/courses/module/pdf/' . basename($module->url);
			}
			if(file_exists($request->type)) {
				unlink($fileUrlUpdate);
			}
		
			// $file->unlink($fileUrlUpdate);

			$file = $request->file('url');
			$filenameWithExt = $request->file('url')->getClientOriginalName();
			$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
			$extension = $request->file('url')->getClientOriginalExtension();
			$fileNameToStore = time() .'_'. $filename . '.' . $extension;
			if($request->type == "Video"){
				$filePath = public_path() . '/uploads/courses/module/video/';
				$fileUrlToStore = asset('uploads/courses/module/video') .'/'. $fileNameToStore;
			}
			elseif ($request->type == "PDF"){
				$filePath = public_path() . '/uploads/courses/module/pdf/';
				$fileUrlToStore = asset('uploads/courses/module/pdf') .'/'. $fileNameToStore;
			}
			else {
				$filePath = public_path() . '/uploads/courses/module/';
				$fileUrlToStore = asset('uploads/courses/module') .'/'. $fileNameToStore;
			}
			if (!File::exists($filePath)) {
				File::makeDirectory($filePath);
			}
			 $file->move($filePath, $fileNameToStore);
		    }
			
		$module->title = $validatedData['module_title'];
		$module->detail = $validatedData['module_details'];
		$module->url = $fileUrlToStore;
		$module->update();
		return redirect(url('courses/' . $course_id))->with(['success' => 'Module has been updated.', 'message' => 'Module Edit Successfully']);
	}

	public function showModuleQuiz($course_id, $module_id) {
		$module = CourseModule::where('id', $module_id)
		->with('moduleQuiz')
		->with('moduleQuiz.options')
		->with('moduleQuiz.correctOption')
		->first();

		return view('admin.course.module.quiz', compact('module', 'course_id'));
	}

	public function addModuleQuiz($course_id, $module_id, Request $request) {
		$module = CourseModule::where('id', $module_id)->first();
		if (!$module) {
			return redirect()->back()->with('error', 'Module not found');
		}

		$validatedData = $request->validate([
			'question' => ['required'],
			'type' => ['required'],
			'is_correct' => ['required'],
		]);

		$count = CourseModuleQuiz::where('course_id', $course_id)
			->where('module_id', $module_id)
			->count();
			$quiz = new CourseModuleQuiz();
			$quiz->course_id = $course_id;
			$quiz->module_id = $module_id;
			$quiz->question = $validatedData['question'];
			$quiz->type = $validatedData['type'];
			$quiz->question_index = $count;
			$quiz->save();

			foreach ($request->options as $key => $value) {
				$opt = new CourseModuleQuizOpts();
				$opt->quiz_id = $quiz->id;
				$opt->option = $value;
				$opt->is_correct = (($key == $validatedData['is_correct']) ? 1 : 0);
				$opt->save();
			}

			return redirect()->back()->with('success', 'Quiz has been added.');
		}

		public function deleteModuleQuiz($course_id, $module_id, $quiz_id) {
			$quiz = CourseModuleQuiz::where('id', $quiz_id)->first();

			$quiz->delete();
			
			return redirect(url('/courses/'.$course_id.'/module/' . $module_id . '/quiz'))->with('success', 'Quiz has been removed.');
		}
}
