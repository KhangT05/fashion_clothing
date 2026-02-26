<?php

namespace App\View\Composer;

use App\Models\Setting;
use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view)
    {
        $setting = Setting::where('publish', 1)->first();
        $view->with('setting', $setting);
    }
}
