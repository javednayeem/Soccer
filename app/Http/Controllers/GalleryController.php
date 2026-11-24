<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class GalleryController extends Controller {

    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];


    public function __construct() {

        // Admin only (uses the existing 'admin' gate)
        $this->middleware(function ($request, $next) {
            Gate::authorize('admin');
            return $next($request);
        });

    }


    private function galleryPath() {
        return public_path('images/gallery');
    }


    public function index() {

        $path = $this->galleryPath();
        $images = [];

        if (is_dir($path)) {

            foreach (scandir($path) as $file) {

                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (is_file($path . DIRECTORY_SEPARATOR . $file) && in_array($ext, self::ALLOWED_EXTENSIONS)) {
                    $images[] = [
                        'name' => $file,
                        'url' => asset('images/gallery/' . rawurlencode($file)),
                        'modified' => filemtime($path . DIRECTORY_SEPARATOR . $file),
                    ];
                }

            }

            // newest first
            usort($images, function ($a, $b) {
                return $b['modified'] <=> $a['modified'];
            });

        }

        return view('admin.gallery.index', [
            'images' => $images,
        ]);

    }


    public function upload(Request $request) {

        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB each
        ]);

        $path = $this->galleryPath();

        if (!is_dir($path)) mkdir($path, 0755, true);

        $count = 0;

        foreach ($request->file('images') as $image) {

            // unique, safe file name
            $name = time() . '_' . Str::random(6) . '.' . strtolower($image->getClientOriginalExtension());
            $image->move($path, $name);
            $count++;

        }

        return redirect()->route('admin.gallery')->with('success', $count . ' image(s) uploaded successfully.');

    }


    public function delete(Request $request) {

        $request->validate(['image' => 'required|string']);

        // basename() prevents path traversal (e.g. ../../.env)
        $name = basename($request->input('image'));
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $file = $this->galleryPath() . DIRECTORY_SEPARATOR . $name;

        if (!in_array($ext, self::ALLOWED_EXTENSIONS) || !is_file($file)) {
            return redirect()->route('admin.gallery')->with('error', 'Image not found.');
        }

        unlink($file);

        return redirect()->route('admin.gallery')->with('success', 'Image deleted successfully.');

    }

}
