<?php


namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseModuleProgress;
use App\Models\CourseModuleQuiz;
use App\Models\CourseModuleQuizAnswers;
use App\Models\CourseModuleQuizOpts;
use App\Models\CourseModuleQuizResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Create a new CourseController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('api');
    }

	// not in use
    public function index()
    {
        return Course::with('modules')->get();
    }

    public function show($id)
    {

		// return Course::with('reviews.user')
		// ->with('announcments')
		// ->with('QA.user')
		// ->with(['modules.moduleProgress' => function($progress){
		// 	$progress->where('user_id', Auth::id());
		// }])
		// ->where('id', $id)
		// ->get();
		
		$PASS_PERCENTAGE = 40;

        $courses = Course::with('reviews.user')
            ->with('announcments')
            ->with('QA.user')
            ->where('id', $id)
            ->get();

		foreach($courses as $course) {
			$course->modules = CourseModule::with(['moduleProgress' => function($progress){
					$progress->where('user_id', Auth::id());
				}])->where('course_id', $course->id)->get();

			foreach ($course->modules as $key => $module) {
				if ($key == 0) {
					$module->active = true; // always enable first module
				}

				$has_quiz = CourseModuleQuiz::where('module_id', $module->id)
					->count();
					
				$has_required_quiz = CourseModuleQuiz::where('module_id', $module->id)
					->where('is_required', 1)
					->count();

				$is_quiz_attempted = CourseModuleQuizResult::where('module_id', $module->id)
					->where('user_id', Auth::id())
					->orderBy('id', 'DESC')
					->first();

				$module->quiz_result = $is_quiz_attempted;
				$module->has_quiz = ($has_quiz > 0);
				$module->has_required_quiz = ($has_required_quiz > 0);

				// if quiz is attempeded and resust is more then 40% then enable next quiz
				if ($is_quiz_attempted) {
					if ($is_quiz_attempted->result >= $PASS_PERCENTAGE || $has_required_quiz == 0) {
						// enable next quiz
						if (isset($course->modules[($key + 1)])) {
							$course->modules[($key + 1)]->active = true;
						}
					} else {
						if (isset($course->modules[($key + 1)])) {
							$course->modules[($key + 1)]->active = false;
						}
					}
				} else {
					if (isset($course->modules[($key + 1)])) {
						$course->modules[($key + 1)]->active = false;
					}
				}

				// if current module doesnot have quiz then enable all next quiz untill quiz module is not found
				if ($has_quiz == 0) {
					for ($i = $key+1; $i<(count($course->modules)); $i++) {
						if (isset($course->modules[($i)])) {
							$course->modules[($i)]->active = true;
						}
					}
				}

				// if previous module is locked then also locked current
				if (isset($course->modules[($key - 1)])) {
					if ($course->modules[($key - 1)]->active == false) {
						$module->active = false;
					}
				}

				// remove video url if module is locked
				if (!$module->active) {
					$module->url = '';
				}
			}
		}

		return $courses;
    }

	// not in use
    public function showModule($module_id)
    {
        $module = DB::table('course_modules')
            ->join('courses', 'courses.id', '=', 'course_modules.course_id')
            ->join('user_courses', 'user_courses.course_id', '=', 'course_modules.course_id')
            ->where('course_modules.id', $module_id)
            ->where('user_courses.user_id', Auth::id())
            ->count();

        if($module){
            $module = CourseModule::with('moduleReviews.user')
                ->where('id', $module_id)
                ->first();

            $module['moduleProgress'] = CourseModuleProgress::where('user_id', Auth::id())->where('module_id', $module_id)->first();
            return $module;
        }else{
            return [];
        }
    }


    public function updateModuleProgress($module_id, Request $request)
    {
        if(CourseModule::where('id', $module_id)->count() && $request->progress){
            $progress = CourseModuleProgress::where('user_id', Auth::id())->where('module_id', $module_id)->first();
            if(!empty($progress))
            {
                $progress->progress = $request->progress;
                $progress->save();
            }else{

                $module = CourseModule::where('id', $module_id)->first();

                $record = new CourseModuleProgress();
                $record->user_id = Auth::id();
                $record->course_id = $module->course_id;
                $record->module_id = $module_id;
                $record->progress = $request->progress;
                $record->save();
            }
            return ['status' => 'success', 'msg' => 'Record has been updated'];
        }else{
            return ['status' => 'failed', 'msg' => 'Something went wrong, try again later'];
        }
    }

    public function showModuleQuiz($module_id) {

        return CourseModuleQuiz::select('id', 'question', 'type', 'is_required')
            ->where('module_id', $module_id)
            ->orderBy('question_index','asc')
            ->with('options')
            ->get();
    }

	public function saveModuleQuiz($module_id, Request $request) {
		$module = CourseModule::where('id', $module_id)->first();
		
		if (!$module) {
			return ['status' => 'failed', 'msg' => 'Something went wrong, try again later'];
		}

		$totalQuestions = CourseModuleQuiz::where('module_id', $module_id)->count();
		$totalAttempted = 0;
		$totalCorrect = 0;

		$data = $request->data;

		$result = new CourseModuleQuizResult();
		$result->user_id = Auth::id();
		$result->module_id = $module_id;
		$result->total_attempted = 0;
		$result->total_correct = 0;
		$result->result = 0;
		$result->total_questions = $totalQuestions;
		$result->save();

		$result_id = $result->id;

		foreach($data as $d) {
			$correct_answer = CourseModuleQuizOpts::where('quiz_id', $d['id'])
			->where('is_correct', 1)
			->first();

			$ans = $d['answer'];
			$is_correct = (($d['answer'] == $correct_answer->id) ? 1 : 0);
			if (is_array($ans)) {
				$is_correct = (in_array($correct_answer->id, $ans)) ? 1 : 0;
				$ans = implode(',', $ans);
			}

			$answer = new CourseModuleQuizAnswers();
			$answer->quiz_id = $d['id'];
			$answer->user_id = Auth::id();
			$answer->result_id = $result_id;
			$answer->answers = $ans;
			$answer->is_correct = $is_correct;
			$answer->save();

			$totalAttempted++;
			$totalCorrect += $is_correct;
		}
		
		
		$final_results = ($totalAttempted > 0) ? intval(($totalCorrect * 100) / $totalAttempted) : 0;

		$result->total_attempted = $totalAttempted;
		$result->total_correct = $totalCorrect;
		$result->result = $final_results;
		$result->update();

		return [
			'status' => 'success', 
			'msg' => 'Record has been updated', 
			'totalAttempted' => $totalAttempted,
			'totalCorrect' => $totalCorrect,
			'finalResult' => $final_results,
		];
	}
}
