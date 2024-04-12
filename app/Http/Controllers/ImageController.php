<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\View\View;

class ImageController extends Controller
{
    public function createForm()
    {
        return view('upload_form');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'max:5', // Limit to 5 images
        ]);

        // Create directory if it doesn't exist
        $directory = public_path('images');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        foreach ($request->file('images') as $image) {
            //rename the file
            $imageName = Str::lower(Str::ascii(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)));
            $extension = $image->getClientOriginalExtension();
            
            // Check if the file with the same name already exists
            $uniqueName = $this->getUniqueFilename($directory, $imageName, $extension);


            
            $image->move($directory, $uniqueName);

            // Create a new instance of Image model
            $newImage = new Image();
            $newImage->name = $uniqueName;
            $newImage->path = '/images/' . $uniqueName;
            $newImage->upload_at = Carbon::now(); // Set upload_at column
            $newImage->save(); // Save the new instance to the database
            
        }

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    private function getUniqueFilename($directory, $originalName, $extension)
    {
        // Replace spaces with underscores
        $originalName = str_replace(' ', '_', $originalName);

        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $count = 0;
        $uniqueName = $filename . '.' . $extension;

        // Check if the file already exists in the directory
        while (File::exists($directory . '/' . $uniqueName)) {
            $count++;
            $uniqueName = $filename . '_' . $count . '.' . $extension;
        }

        return $uniqueName;
    }
}
