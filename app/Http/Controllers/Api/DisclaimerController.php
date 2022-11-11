<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Disclaimer;

class DisclaimerController extends Controller
{
    public function index()
    {
        return Disclaimer::where('status', 'Active')->first();
    }
}
