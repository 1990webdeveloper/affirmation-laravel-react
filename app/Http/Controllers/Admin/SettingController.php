<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [];
        foreach (Setting::all() as $val) {
            $settings[$val->key] = $val->value;
        }
        return view('admin.setting.index', compact('settings'));
    }

    public function storeSetting(Request $request)
    {
        unset($request['_token']);
        // dd($request->all());
        if ($request['form_name'] == 'bbForm') {
            $this->validate(
                $request,
                [
                    'bb_space_limit' => 'required',
                    'bb_time_limit' => 'required'
                ],
                [
                    'bb_space_limit.required' => 'The binaural beat space limit field is required.',
                    'bb_time_limit.required' => 'The binaural beat time limit field is required.',
                ]
            );
        }
        if ($request['form_name'] == 'baForm') {
            $this->validate(
                $request,
                [
                    'ba_space_limit' => 'required',
                    'ba_time_limit' => 'required'
                ],
                [
                    'ba_space_limit.required' => 'The background audio space limit field is required.',
                    'ba_time_limit.required' => 'The background audio time limit field is required.',
                ]
            );
        }
        if ($request['form_name'] == 'arForm') {
            $this->validate(
                $request,
                [
                    'ar_space_limit' => 'required',
                    'ar_time_limit' => 'required'
                ],
                [
                    'ar_space_limit.required' => 'The audio record space limit field is required.',
                    'ar_time_limit.required' => 'The audio record time limit field is required.',
                ]
            );
        }
        if ($request['form_name'] == 'bannerForm') {
            $this->validate(
                $request,
                [
                    'banner_size' => 'required',
                ],
                [
                    'banner_size.required' => 'The banner size field is required.',
                ]
            );
        }
        unset($request['form_name']);
        foreach ($request->all() as $key => $value) {
            if (isset($value)) {
                Setting::setSettings($key, $value);
            }
        }
        return redirect()->route('setting.index')->with('success', 'Updated successfully');
    }
}
