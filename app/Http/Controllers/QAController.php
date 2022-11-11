<?php


namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\CourseQA;
use Illuminate\Http\Request;

class QAController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index()
    {
        $q_a = CourseQA::with('course')->orderBy('created_at', 'desc')->get();

        return view('admin.q_a.index', compact('q_a'));
    }

    public function create()
    {
        $courses = Course::all();

        return view('admin.q_a.create', compact('courses'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'course' => 'required',
            'question' => 'required',
            'answer' => 'required'
        ]);

        $record = new CourseQA();
        $record->course_id = $validatedData['course'];
        $record->question = $validatedData['question'];
        $record->answer = $validatedData['answer'];
        $record->save();

        return redirect()->back()->with('success', 'Record has been added');

    }

    public function edit($id)
    {
        $q_a = CourseQA::where('id', $id)->first();

        return view('admin.q_a.update', compact('q_a'));
    }

    public function update($id, Request $request)
    {
        if(CourseQA::where('id', $id)->count()){
            $validatedData = $request->validate([
                'question' => 'required',
                'answer' => 'required'
            ]);

            $disclaimer = CourseQA::where('id', $id)->first();
            $disclaimer->question = $validatedData['question'];
            $disclaimer->answer = $validatedData['answer'];
            $disclaimer->save();

            return redirect('/Q_A')->with('success', 'Record has been updated');

        }else{
            return redirect()->back()->with('error', 'Something went Wrong, try again later');
        }
    }
}
