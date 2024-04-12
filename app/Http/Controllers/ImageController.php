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


    public function showUploadedImages(Request $request)
    {
        $perPage = 4; // Define the number of images per page
        $sortBy = $request->input('sort_by', 'upload_at'); // Default sorting by uploaded_at
        $sortOrder = $request->input('sort_order', 'desc'); // Default sort order is descending

        $images = Image::orderBy($sortBy, $sortOrder)->paginate($perPage);
    
        return view('list', compact('images', 'perPage', 'sortBy', 'sortOrder'));
    
    }

    public function downloadZip(Request $request)
    {
        $selectedImages = $request->input('selected_images', []);

        // display error message if no image selected
        if (empty($selectedImages)) {
            return redirect()->back()->with('error', 'Please select at least one image to download.');
        }

        // get the selected image paths
        $imagePaths = Image::whereIn('id', $selectedImages)->pluck('path')->toArray();

        // Create a zip archive containing the selected images
        $zipFileName = 'selected_images_' . Carbon::now()->format('YmdHis') . '.zip';
        $zip = new \ZipArchive();
        $zip->open(public_path($zipFileName), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($imagePaths as $imagePath) {
            $imageFullPath = public_path($imagePath);
            if (file_exists($imageFullPath)) {
                $zip->addFile($imageFullPath, basename($imagePath));
            }
        }

        $zip->close();
        
        // Send the zip archive to the user for download
        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }

    public function getImagesJson(Request $request)
    {
        $images = Image::all(['id', 'name']); // Retrieve only the ID and name columns

        return response()->json($images);
    }

    public function getImageDetails($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404); //if there's no file found with the id that the user entered
        }

        return response()->json($image);
    }

}
