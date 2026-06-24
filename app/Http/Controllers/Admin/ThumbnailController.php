<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\Storage;

class ThumbnailController extends Controller
{
    public function destroy(Thumbnail $thumbnail)
    {
        // Hapus file fisik kalau ada
        if ($thumbnail->image && Storage::exists($thumbnail->image)) {
            Storage::delete($thumbnail->image);
        }

        $thumbnail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Thumbnail berhasil dihapus.'
        ]);
    }
}
