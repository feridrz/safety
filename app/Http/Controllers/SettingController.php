<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::where('user_id', auth()->id())->first();

        if(!$settings){
            return $this->errorResponse('Settings not found for this user', [], 404);
        }

        return $this->successResponse($settings, 'Settings fetched successfully', 200);
    }

    public function update(Request $request)
    {
        if ($request->has('user_id')) {
            return $this->errorResponse('You are not allowed to set the user_id field.', [], 400);
        }

        $settings = Setting::where('user_id', auth()->id())->first();

        if(!$settings){
            return $this->errorResponse('Settings not found for this user', [], 404);
        }

        $input = $request->all();

        $settings->update($input);

        return $this->successResponse($settings, 'Settings updated successfully', 200);
    }

}
