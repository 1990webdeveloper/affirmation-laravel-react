<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::all();
            return \Yajra\DataTables\Facades\DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $image = ' <div
                    class="h-28 w-[150px] relative image-fit cursor-pointer zoom-in">
                    <img class="rounded-md" alt="Preview image"
                        src="' . asset('storage/banner/' . $data->image) . '">
                </div>';
                    return $image;
                })
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
                    $actionData =   '<div class="flex justify-center items-center">
                    <a href="' . route("banner.createOrEdit", $data->id) . '" class="text-success flex items-center mr-3" href="javascript:;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-square" data-lucide="check-square" class="lucide lucide-check-square w-4 h-4 mr-1"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg> Edit </a>
                    <form method="POST" action="' . route("banner.delete", [$data->id]) . '">
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button type="button" class="flex items-center text-danger deleteButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Delete </button></form>';
                    return $actionData;
                })
                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }
        return view('admin.banner.index');
    }
    /**
     * Create or edit view page
     * @param mixed $id
     * @return \Illuminate\Contracts\View\View
     */
    public function createOrEdit($id = null)
    {
        $banner = Banner::find($id);
        $fileSize = Setting::get('banner_size') ? Setting::get('banner_size') : AppHelper::BANNER_LIMIT;
        return view('admin.banner.createOrEdit', compact('banner', 'fileSize'));
    }
    /**
     * Store/update resource
     * @param mixed $id
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id = null)
    {

        $request['status'] = $request->status ?  '1' : '0';
        if ($id == null || ($id && $request->banner)) {
            $request->validate([
                'name' => 'required|string|min:3|max:70',
                'description' => 'required|min:10|max:500',
                'banner' => 'required|mimes:png,jpg,jpeg'
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|min:3|max:70',
                'description' => 'required|min:10|max:500',
            ]);
        }
        if ($request->hasFile('banner')) {
            if ($request->old_img && File::exists(public_path('storage/banner/' .  $request->old_img))) {
                File::delete(public_path('storage/banner/' .  $request->old_img));
            }
            $uniqueId = uniqid();
            $imgFile = $request->file('banner');
            $extension = $imgFile->getClientOriginalExtension();
            $filename =  'original_' . $uniqueId . '.' . $extension;
            $imgFile->storeAs('banner/', $filename, 'public');
            $width = getimagesize($imgFile)[0]; // image width
            $height = getimagesize($imgFile)[1]; // image height
            if ($width != 480 || $height != 350) {
                $image = Image::make($request->banner)->resize(480, 350);
                $newFilename = $uniqueId . '.' . $extension;
                $image->save(public_path("/storage/banner/{$newFilename}")); //remaining to store new resize img
            } else {
                $newFilename = $filename;
            }
        } else {
            if ($request->old_img) {
                $newFilename = $request->old_img;
            }
        }
        $banner = Banner::updateOrCreate(
            ['id' => $id ? $id : null],
            ['name' => $request->name, 'description' => $request->description, 'image' => $newFilename]
        );
        if (isset($banner)) {
            $successMsg =  $id ? 'updated.' : 'added.';
            return redirect()->route('banner.index')->with('success', 'Banner successfully ' . $successMsg);
        } else {
            $errorMsg =  $id ? 'updating.' : 'adding.';
            return redirect()->route('banner.index')->with('error', 'Error while ' . $errorMsg . ' banner.');
        }
    }
    /**
     * Delete resource
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $delete = Banner::where('id', $id)->delete();
        if ($delete > 0) {
            return redirect()->route('banner.index')->with('success', 'Banner successfully deleted.');
        } else {
            return redirect()->route('banner.index')->with('error', 'Error while deleting banner.');
        }
    }
    /**
     * Change the status of banner
     *  @param \Illuminate\Http\Request
     *  @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $dataRow = Banner::find($id);
        if (empty($dataRow)) {
            return response()->json(['error' => 'Record not found!']);
        }
        $dataRow->status = ($status == 1) ? '1' : '0';
        if ($dataRow->save()) {
            return response()->json(['success' => 'Banner status successfully updated.']);
        }
        return response()->json(['error' => 'Please try again!!']);
    }
}
