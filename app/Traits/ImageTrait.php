<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait ImageTrait{
    public function uploadImage(Request $request,$file,$directory): bool|string|null
    {
        if ($request->hasFile($file)) {
            $file = $request->file($file);
            $name = time().$file->getClientOriginalName();
            return $file->storeAs($directory, $name, 'public');
        }
        return null;
    }
    public function deleteImage($filePath): void
    {
            unlink("storage/".$filePath);
    }

}
