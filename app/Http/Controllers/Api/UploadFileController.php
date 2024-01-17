<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class UploadFileController extends Controller
{
    public function uploadFile(Request $request)
    {
        // dd($request->all());

        
        // Pastikan request memiliki file dengan nama 'file'
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $badge = $request->badge_id;

            if($badge){
                $badgeDirectory = public_path('employee_uploads/') . $badge;

                // Cek apakah direktori dengan nama badge sudah ada
                if (!file_exists($badgeDirectory)) {
                    // Jika tidak ada, buat direktori baru
                    mkdir($badgeDirectory, 0755, true);
                }
            
                // Simpan file di dalam direktori public/RoomMeeting/$badge
                $file->move($badgeDirectory, $file->getClientOriginalName());
                 // Simpan file di dalam direktori public/RoomMeeting
                return response()->json(['message' => 'File berhasil diupload']);
            }
            
            return response()->json(['message' => 'Badge tidak terisi'], 400);
           
        }

        return response()->json(['message' => 'File tidak ditemukan'], 400);
    }
}
