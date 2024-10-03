<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\BackgroundAudio;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackgroundAudioController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BackgroundAudio::all();
            return \Yajra\DataTables\Facades\DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    $checked = ($data->status == '1') ? 'checked' : '';
                    $status = '<div class="form-switch mt-2">
                        <input class="form-check-input changeStatus" type="checkbox"
                            data-id="' . $data->id . '" id="customSwitch-' . $data->id . '"
                            ' . $checked . '>
                        <label class="custom-control-label" for="customSwitch-' . $data->id . '"></label>
                    </div>';
                    return $status;
                })
                ->addColumn('action', function ($data) {
                    $actionData =  '<div class="flex justify-center items-center">
                    <a href="' . route("background-audio.createOrEdit", $data->id) . '" class="text-success flex items-center mr-3" href="javascript:;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> Edit </a>
                    <form method="POST" action="' . route("background-audio.delete", [$data->id]) . '">
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button type="button" class="flex items-center text-danger deleteButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Delete </button></form>';
                    return $actionData;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.background-audio.index');
    }
    /**
     * Create or edit view page
     * @param mixed $id
     * @return \Illuminate\Contracts\View\View
     */
    public function createOrEdit($id = null)
    {
        $backgroundAudio = BackgroundAudio::find($id);
        $spaceLimit = Setting::get('ba_space_limit') ? Setting::get('ba_space_limit') : AppHelper::BA_SPACE_LIMIT;
        $timeLimit = Setting::get('ba_time_limit') ? Setting::get('ba_time_limit') : AppHelper::BA_SPACE_LIMIT;
        return view('admin.background-audio.createOrEdit', compact('backgroundAudio','spaceLimit','timeLimit'));
    }
    /**
     * Store/update resource
     * @param mixed $id
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id = null)
    {
        if ($id == null || ($id && $request->audio_path)) {
            $this->validate($request, [
                'name' => 'required',
                'audio_path' => 'required|mimes:audio/mpeg,mp3,wav,aac'
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required',
            ]);
        }

        if ($request->hasFile('audio_path')) {
            if ($request->old_audio && File::exists(public_path('storage/background-audio/audio/' .  $request->old_audio))) {
                File::delete(public_path('storage/background-audio/audio/' .  $request->old_audio));
            }
            $uniqueId = uniqid();
            $audioFile = $request->file('audio_path');
            $extension = $audioFile->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueId . '.' . $extension;
            $audioFile->storeAs('background-audio/audio/', $filename, 'public');
        } else {
            if ($request->old_audio) {
                $filename = $request->old_audio;
            }
        }
        $request['status'] = $request->status ?  '1' : '0';
        $bbStore = BackgroundAudio::updateOrCreate(
            ['id' => $id ? $id : null],
            ['name' => $request->name, 'audio_path' => $filename, 'status' => $request->status]
        );
        if (isset($bbStore)) {
            $successMsg =  $id ? 'updated.' : 'added.';
            return redirect()->route('background-audio.index')->with('success', 'Background Audio successfully ' . $successMsg);
        } else {
            $errorMsg =  $id ? 'updating.' : 'adding.';
            return redirect()->route('background-audio.index')->with('error', 'Error while ' . $errorMsg . ' background audio.');
        }
    }
    /**
     * Delete resource
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $delete = BackgroundAudio::where('id', $id)->delete();
        if ($delete > 0) {
            return redirect()->route('background-audio.index')->with('success', 'Background Audio successfully deleted.');
        } else {
            return redirect()->route('background-audio.index')->with('error', 'Error while deleting background audio.');
        }
    }
    /**
     * Change the specified resource from storage.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $dataRow = BackgroundAudio::find($id);
        if (empty($dataRow)) {
            return response()->json(['error' => 'Record not found!']);
        }
        $dataRow->status = ($status == 1) ? '1' : '0';
        if ($dataRow->save()) {
            return response()->json(['success' => 'Background Audio status successfully updated.']);
        }
        return response()->json(['error' => 'Please try again!!']);
    }
}
