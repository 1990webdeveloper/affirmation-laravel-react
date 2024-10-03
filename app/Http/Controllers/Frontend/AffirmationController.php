<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Affirmation;
use App\Models\BackgroundAudio;
use App\Models\BinauralBeats;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class AffirmationController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        $affirmations = $user->affirmations()->orderByDesc('id')->get();
        return Inertia::render('Affirmations/MyAffirmations', ['affirmations' => $affirmations]);
    }

    public function createOrEdit($id = null)
    {
        $categories = Category::where('status', '1')->orderByDesc('id')->get();
        $user = User::findOrFail(auth()->user()->id);
        $affirmation = $id ? $user->affirmations()->findOrFail($id) : '';
        $affirmations = $user->affirmations()->orderByDesc('id')->get();
        $binauralBeats = BinauralBeats::orderByDesc('id')->get();
        $backgroundAudio = BackgroundAudio::orderByDesc('id')->get();

        return Inertia::render('Affirmations/Affirmation', [
            'categories' => $categories,
            'affirmation' => $affirmation,
            'affirmations' => $affirmations,
            'binauralBeats' => $binauralBeats,
            'backgroundAudio' => $backgroundAudio
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $affirmation = '';
        switch ($request->step) {
            case (1):
                $affirmation = $this->recordAffirmation($request);
                break;
            case (2):
                $affirmation = $this->soundMixing($request);
                break;
            case (3):
                $affirmation = $this->uploadImage($request);
                break;
                // case (4):
                //     break;
        }
        if ($affirmation) {
            return to_route('affirmation.create', $affirmation->id);
        } else {
            session()->flash('error', 'Somthing went wrong, Please try agin after some time!');
        }
    }

    public function recordAffirmation($request)
    {
        $this->validate(
            $request,
            [
                "category_id" => "required",
                "name" => "required",
                "recorded_audio" => "required",
                "recorded_transcription" => "required",
            ],
            [
                'recorded_audio' => 'Please record something',
            ]
        );

        $uniqueId = uniqid();

        if ($request->hasFile('audio_file')) {
            $affirmation = Affirmation::find($request->affirmation_id ?? '');
            if ($affirmation && File::exists(public_path("storage/mix_audio_file/" . $affirmation->mix_audio))) {
                File::delete(public_path("storage/mix_audio_file/" . $affirmation->mix_audio));
            }
            $audioFile = $request->file('audio_file');
            $extension = $audioFile->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueId . '.' . $extension;
            $audioFile->storeAs('audio_file/', $filename, 'public');
            $request['recorded_audio'] = $filename;
        } else {
            unset($request['recorded_audio']);
        }
        $request['user_id'] = auth()->user()->id;

        if ($request->affirmation_id) {
            unset($request['step']);
        }

        $affirmation = Affirmation::updateOrcreate(['id' => $request->affirmation_id], $request->all());
        session()->flash('success', "Affirmation saved successfully!");
        return $affirmation;
    }

    public function soundMixing($request)
    {
        $this->validate(
            $request,
            [
                "affirmation_id" => "required",
                "mix_audio" => "required",
                "mix_audio_file" => "required",
            ],
            [
                "affirmation_id.required" => "Please select affirmation",
            ]
        );

        $affirmation = Affirmation::findOrFail($request->affirmation_id);
        if ($request->hasFile('mix_audio_file')) {
            if (File::exists(public_path("storage/mix_audio_file/" . $affirmation->mix_audio))) {
                File::delete(public_path("storage/mix_audio_file/" . $affirmation->mix_audio));
            }
            $uniqueId = uniqid();
            $audioFile = $request->file('mix_audio_file');
            $extension = $audioFile->getClientOriginalExtension();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueId . '.' . $extension;
            $audioFile->storeAs('mix_audio_file/', $filename, 'public');
            $request['mix_audio'] = $filename;
        }

        $request['user_id'] = auth()->user()->id;
        $affirmation->update($request->all());
        session()->flash('success', "Affirmation saved successfully!");
        return $affirmation;
    }

    public function uploadImage($request)
    {
        // dd($request->all());
        $this->validate(
            $request,
            [
                "images" => "required",
                "effect_type" => "required",
            ]
        );
        $images = [];
        $affirmation = Affirmation::findOrFail($request->affirmation_id);
        foreach ($request->images as $image) {
            $fName = $image->getClientOriginalName();
            $filename = null;
            if (!File::exists('storage/affirmation/' . $affirmation->id . '/' . $fName)) {
                $uniqueId = uniqid();
                $extension = $image->getClientOriginalExtension();
                $filename = Carbon::now()->format('Ymd') . '_' . $uniqueId . '.' . $extension;
                $image->storeAs('affirmation/' . $affirmation->id . '/', $filename, 'public');
            }
            $images[] = $filename ?? $fName;
        }
        if ($request->remove_images) {
            foreach ($request->remove_images as $rImage) {
                $imageFile = str_replace($request->getSchemeAndHttpHost(), '', $rImage);
                if (File::exists(public_path($imageFile))) {
                    File::delete(public_path($imageFile));
                }
            }
        }
        $data = $request->all();
        $data['images'] = implode(",", $images);
        $data['user_id'] = auth()->user()->id;
        $affirmation->update($data);
        return $affirmation;
    }
}
