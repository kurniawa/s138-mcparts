<?php

namespace App\Http\Controllers;

use App\SiteSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $site_settings;

    public function __construct()
    {
        // Fetch the Site Settings object
        $this->site_settings = SiteSetting::all();
        // View::share('site_settings', $this->site_settings);
    }
}
