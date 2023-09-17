<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;

class BlogController extends Controller
{
    public function index() {
        return view('index.index')->withPackages($packages);
    }
}
