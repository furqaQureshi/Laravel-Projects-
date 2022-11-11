<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseAnnouncment;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index()
    {
        $announcements = CourseAnnouncment::with('course')
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.announcements.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course' => 'required',
            'title' => 'required',
            'detail' => 'required'
        ]);

        $record = new CourseAnnouncment();
        $record->course_id = $validatedData['course'];
        $record->title = $validatedData['title'];
        $record->detail = $validatedData['detail'];
        $record->save();

        return redirect()->back()->with('success', 'Record has been Added');
    }
}
