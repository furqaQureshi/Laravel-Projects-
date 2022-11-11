<?php


namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){

		$stats = [
			"activeCustomer" => Customer::where('status', 'Active')->count(),
			"activeUser" => User::where('status', 'Active')->count(),
			"courses" => Course::where('status', 'Active')->count(),
			"courseModules" => CourseModule::where('status', 'Active')->count(),
		];

        return view('admin.dashboard', compact('stats'));
    }
}
