<?php

namespace App\Http\Controllers;

use FuzzyWuzzy\Fuzz;
use App\Models\Learning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use thiagoalessio\TesseractOCR\TesseractOCR;

class LearningController extends Controller
{
    public function index()
    {
        $learnings = Learning::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return view('learning', compact('learnings'));
    }

    public function showDoLearning($id)
    {
        $learning = Learning::find($id);

        return view('learning-show', compact('learning'));
    }

    public function doLearning()
    {
        $randomizedWord = $this->randomizedWord();

        return view('do-learning', compact('randomizedWord'));
    }

    public function store(Request $request)
    {
        $fuzz = new Fuzz();
        $structuredImageText = null;
        $accuracyPercentage = 0;
        $imageUrl = null;

        if (isset($request['image'])) {
            if (!File::exists(public_path('uploads'))) {
                File::makeDirectory(public_path('uploads'), 0777, true, true);
            }

            $requestImage = $request->file('image');
            $imageName = time() . '.' . $requestImage->extension();
            $image = Image::make($requestImage);
            $image->resize(450, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save(public_path('uploads') . '/' . $imageName);

            $imageUrl = 'uploads/' . $imageName;
        }

        DB::beginTransaction();

        try {
            $convertImageToText = (new TesseractOCR(public_path($imageUrl)))->run();
            $structuredImageText = str_replace("\n", ' ', $convertImageToText);

            if (!is_null($structuredImageText)) {
                $accuracyPercentage = $fuzz->ratio($request['randomized_string'], preg_replace("/[^a-zA-Z]/", "", strtolower($structuredImageText)));
            }

            Learning::create([
                'user_id' => auth()->user()->id,
                'image_url' => asset($imageUrl),
                'randomized_string' => $request['randomized_string'],
                'accuracy_percentage' => $accuracyPercentage,
            ]);

            DB::commit();

            return redirect()->route('learnings.index')->with('success', 'Successfully submitted your learning! Check below for more info.');
        } catch (\Exception $e) {
            Learning::create([
                'user_id' => auth()->user()->id,
                'image_url' => asset($imageUrl),
                'randomized_string' => $request['randomized_string'],
                'accuracy_percentage' => $accuracyPercentage,
            ]);

            DB::commit();

            return redirect()->route('learnings.index')->with('success', 'Successfully submitted your learning! Check below for more info.');
        }
    }

    public function update($id, Request $request)
    {
        $learning = Learning::find($id);

        $fuzz = new Fuzz();
        $structuredImageText = null;
        $accuracyPercentage = 0;
        $imageUrl = null;

        if (isset($request['image'])) {
            if (!File::exists(public_path('uploads'))) {
                File::makeDirectory(public_path('uploads'), 0777, true, true);
            }

            $requestImage = $request->file('image');
            $imageName = time() . '.' . $requestImage->extension();
            $image = Image::make($requestImage);
            $image->resize(450, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save(public_path('uploads') . '/' . $imageName);

            $imageUrl = 'uploads/' . $imageName;
        }

        DB::beginTransaction();

        try {
            $convertImageToText = (new TesseractOCR(public_path($imageUrl)))->run();

            $structuredImageText = str_replace("\n", ' ', $convertImageToText);

            if (!is_null($structuredImageText)) {
                $accuracyPercentage = $fuzz->ratio($learning->randomized_string, preg_replace("/[^a-zA-Z]/", "", strtolower($structuredImageText)));
            }

            $learning->update([
                'image_url' => asset($imageUrl),
                'accuracy_percentage' => $accuracyPercentage,
            ]);

            DB::commit();

            return redirect()->route('learnings.index')->with('success', 'Successfully submitted your learning! Check below for more info.');
        } catch (\Exception $e) {
            $learning->update([
                'image_url' => asset($imageUrl),
                'accuracy_percentage' => $accuracyPercentage,
            ]);

            DB::commit();

            return redirect()->route('learnings.index')->with('success', 'Successfully submitted your learning! Check below for more info.');
        }
    }

    public function delete($id)
    {
        $learning = Learning::find($id);

        $learning->delete();

        return redirect()->route('learnings.index')->with('success', 'Successfully deleted learning!');
    }

    public function randomizedWord()
    {
        $wordListURL = 'https://www.randomwordgenerator.com/json/words.json';

        $wordListJSON = file_get_contents($wordListURL);

        $wordList = json_decode($wordListJSON, true);

        $randomWord = $wordList['data'][rand(0, count($wordList['data']) - 1)]['word'];

        // $words = [
        //     "apple", "banana", "cat", "dog", "elephant", "fish", "giraffe", "happy", "ice",
        //     "jump", "kite", "lion", "monkey", "nest", "orange", "penguin", "queen", "rainbow",
        //     "sun", "turtle", "umbrella", "volcano", "watermelon", "blue", "yellow", "zebra",
        //     "robot", "star", "moon", "carrot", "duck", "frog", "guitar", "hat", "igloo", "jellyfish",
        //     "key", "lollipop", "mountain", "nose", "ocean", "pizza", "quack", "rain", "socks",
        //     "train", "unicorn", "violet", "whale", "phone", "yawn", "zipper"
        // ];

        return $randomWord;
    }
}
