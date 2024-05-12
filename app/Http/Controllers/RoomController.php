<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    public function index()
    {
        $q = 'SELECT * FROM tbl_deptcode ORDER BY dept_name';
        $list_dept = DB::select($q);

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_rolemeeting')
                ->select('name')
                ->where('id', session()->get('loggedInUser')['session_roles'])
                ->first()->name,
                'list_dept' => $list_dept,
        ];

        return view('room.index', $data);
    }

    // menampilkan tabel List Room
    public function getListRoom(Request $request)
    {
        $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';
        $sessionLogin = session('loggedInUser');
        $divisiId = $sessionLogin['session_badge'];

        $q = "SELECT id, room_name, floor, capacity
        FROM tbl_roommeeting
        WHERE (UPPER(room_name) LIKE '$txSearch' OR UPPER(floor) LIKE '$txSearch' OR UPPER(capacity) LIKE '$txSearch')
        ORDER BY
        CAST(SUBSTRING_INDEX(room_name, ' ', -1) AS UNSIGNED), room_name";

        $data = DB::select($q);

        $output = '';
        $output .= '
            <table id="tbl_roommeeting" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                        <th class="p-3" scope="col">Room</th>
                        <th class="p-3" scope="col">Floor</th>
                        <th class="p-3" scope="col">Capacity</th>
                        <th class="p-3" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
        ';

        foreach ($data as $key => $item) {
            $output .=
                '
                <tr>
                    <td class="p-3">' .
                $item->room_name .
                '</td>
                    <td class="p-3">' .
                $item->floor .
                '</td>
                    <td class="p-3">' .
                $item->capacity .
                '</td>
                    <td>
                        <a  class="btn btnDetail" data-id=' .
                $item->id .
                '><img src="' .
                asset('icons/detail.svg') .
                '"></a>
                        <a  class="btn btnEdit" data-id=' .
                $item->id .
                '><img src="' .
                asset('icons/edit.svg') .
                '"></a>
                        <a class="btn btnDelete"  data-id="' .
                $item->id .
                '" data-room_name="' .
                $item->room_name .
                '"><img src="' .
                asset('icons/delete.svg') .
                '"></a>
                    </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    // Insert Function
    public function insert(Request $request)
    {
        // dd($request);
        try {
            $room_name = $request->room_name;

            $floor = $request->floor;
            $capacity = $request->capacity;
            $type = $request->type;
            $dept = $request->selectDept ?? null;

            $count = DB::table('tbl_roommeeting')
                ->where('room_name', $room_name)
                ->count();
            if ($count > 0) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Meeting Room cannot duplicate',
                ]);
            }

            $file1 = $request->file('roomimage_1');
            $file2 = $request->file('roomimage_2');
            $file3 = $request->file('roomimage_3');

            // Periksa apakah file ada sebelum mengambil ekstensi dan ukuran
            $ekstensi1 = $file1->getClientOriginalExtension();
            $ekstensi2 = $file2->getClientOriginalExtension();
            $ekstensi3 = $file3->getClientOriginalExtension();

            $sizeFile1 = $file1->getSize();
            $sizeFile2 = $file2->getSize();
            $sizeFile3 = $file3->getSize();

            $ukuranKB1 = round($sizeFile1 / 1024, 2);
            $ukuranKB2 = round($sizeFile2 / 1024, 2);
            $ukuranKB3 = round($sizeFile3 / 1024, 2);

            $allowEkstensi = ['png', 'jpeg', 'jpg'];

            // Validasi floor
            if ($floor > 20) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Floor value cannot be more than 20',
                ]);
            }

            // Validasi ekstensi gambar
            if ((!empty($ekstensi1) && !in_array(strtolower($ekstensi1), $allowEkstensi)) || (!empty($ekstensi2) && !in_array(strtolower($ekstensi2), $allowEkstensi)) || (!empty($ekstensi3) && !in_array(strtolower($ekstensi3), $allowEkstensi))) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Insert image available in JPG, PNG, and JPEG formats.',
                ]);
            }

            // Validasi ukuran gambar
            $maxFileSize = 10240; // 10 MB dalam KB
            if ($ukuranKB1 > $maxFileSize || $ukuranKB2 > $maxFileSize || $ukuranKB3 > $maxFileSize) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Image size cannot be more than 10 MB',
                ]);
            }

            // Validasi data ganda
            $countCheck = DB::table('tbl_roommeeting')
                ->where('room_name', $room_name)
                ->where('floor', $floor)
                ->where('capacity', $capacity)
                ->count();

            if ($countCheck > 0) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Data Cannot Duplicate',
                ]);
            }

            // Generate nama unik untuk gambar
            $room_name_f = str_replace(' ', '_', $room_name);
            $imgName1 = $room_name_f . '_1_' . time() . '.' . $ekstensi1;
            $imgName2 = $room_name_f . '_2_' . time() . '.' . $ekstensi2;
            $imgName3 = $room_name_f . '_3_' . time() . '.' . $ekstensi3;

            // Pindahkan file gambar ke direktori tujuan
            if ($file1) {
                $file1->move(public_path('RoomMeetingFoto'), $imgName1);
            }
            if ($file2) {
                $file2->move(public_path('RoomMeetingFoto'), $imgName2);
            }
            if ($file3) {
                $file3->move(public_path('RoomMeetingFoto'), $imgName3);
            }


                // Buat koneksi ke API menggunakan Guzzle
                $client = new Client();

                // Kirim file menggunakan Guzzle
                foreach ([$imgName1, $imgName2, $imgName3] as $imgName) {
                    $filePath = public_path('RoomMeetingFoto') . '/' . $imgName;

                    $response = $client->request('POST', 'https://webapi.satnusa.com/api/platform/upload-file', [
                        'multipart' => [
                            [
                                'name'     => 'file_upload',
                                'contents' => fopen($filePath, 'r'),
                                'filename' => $imgName,
                            ],
                        ],
                    ]);

                    $statusCode = $response->getStatusCode();

                    if ($statusCode != 200) {
                        // Gagal mengunggah file ke platform
                        return response()->json([
                            'MSGTYPE' => 'W',
                            'MSG' => 'Gagal mengunggah file ke platform',
                        ]);
                    }
                }



            // Masukkan data ke database
            $data = [
                'room_name' => $room_name,
                'floor' => $floor,
                'capacity' => $capacity,
                'roomimage_1' => $imgName1,
                'roomimage_2' => $imgName2,
                'roomimage_3' => $imgName3,
                // 'dept'        => $dept,
            ];

            $newId = DB::table('tbl_roommeeting')->insertGetId($data);

            return response()->json([
                'MSGTYPE' => 'S',
                'MSG' => 'SUCCESS',
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json([
                'MSGTYPE' => 'W',
                'MSG' => 'Something Went Wrong',
            ]);
        }
    }

    // edit function
    public function edit(Request $request)
    {
        // dd($request);

        $id = $request->input('RoomId');

        $data = DB::table('tbl_roommeeting')
            ->select('id', 'room_name', 'floor', 'capacity', 'roomimage_1', 'roomimage_2', 'roomimage_3', 'dept')
            ->where('id', $id)
            ->first();

        return response()->json([
            'dataRoomId' => $data,
        ]);
    }

    // Update Function
    public function update(Request $request)
    {
        // dd($request);
        try {
            $id = $request->editId;
            $room_name = $request->room_name;
            $floor = $request->floor;
            $capacity = $request->capacity;
            $type = $request->type;
            $deptEdit = $request->selectDeptEdit ?? null;

            $count = DB::table('tbl_roommeeting')
                ->where('room_name', $room_name)
                ->where('id', '<>', $id)
                ->count();
            if ($count > 0) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Meeting Room cannot duplicate',
                ]);
            }

            $file1 = $request->file('roomimageedit_1');
            $file2 = $request->file('roomimageedit_2');
            $file3 = $request->file('roomimageedit_3');

            $imgName1 = '';
            $imgName2 = '';
            $imgName3 = '';
            $allowEkstensi = ['png', 'jpeg', 'jpg'];
            $maxFileSize = 10240; // 10 MB dalam KB

            // data
            $data = [
                'room_name' => $room_name,
                'floor' => $floor,
                'capacity' => $capacity,
                'dept'     => $deptEdit,
            ];

            // Validasi floor
            if ($floor > 20) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Floor value cannot be more than 20',
                ]);
            }

            if ($file1) {
                $ekstensi1 = $file1->getClientOriginalExtension();
                $sizeFile1 = $file1->getSize();
                $ukuranKB1 = round($sizeFile1 / 1024, 2);

                if (!empty($ekstensi1) && !in_array(strtolower($ekstensi1), $allowEkstensi)) {
                    return response()->json([
                        'MSGTYPE' => 'W',
                        'MSG' => 'Insert image available in JPG, PNG, and JPEG formats.',
                    ]);
                }

                if ($ukuranKB1 > $maxFileSize) {
                    return response()->json([
                        'MSGTYPE' => 'W',
                        'MSG' => 'Image size cannot be more than 10 MB',
                    ]);
                }

                $room_name_1 = str_replace(' ', '_', $room_name);
                $imgName1 = $room_name_1 . '_1_' . time() . '.' . $ekstensi1;
                $file1->move(public_path('RoomMeetingFoto'), $imgName1);

                // send guzzle
                $client = new Client();
                $filePath = public_path('RoomMeetingFoto') . '/' . $imgName1;
                    $response = $client->request('POST', 'https://webapi.satnusa.com/api/platform/upload-file', [
                        'multipart' => [
                            [
                                'name'     => 'file_upload',
                                'contents' => fopen($filePath, 'r'),
                                'filename' => $imgName1,
                            ],
                        ],
                    ]);
                    $statusCode = $response->getStatusCode();
                    if ($statusCode != 200) {
                        // Gagal mengunggah file ke platform
                        return response()->json([
                            'MSGTYPE' => 'W',
                            'MSG' => 'Gagal mengunggah file ke platform',
                        ]);
                    }


                $data['roomimage_1'] = $imgName1;
            }

            if ($file2) {
                $ekstensi2 = $file2->getClientOriginalExtension();
                $sizeFile2 = $file2->getSize();
                $ukuranKB2 = round($sizeFile2 / 1024, 2);

                if (!empty($ekstensi2) && !in_array(strtolower($ekstensi2), $allowEkstensi)) {
                    return response()->json([
                        'MSGTYPE' => 'W',
                        'MSG' => 'Insert image available in JPG, PNG, and JPEG formats.',
                    ]);
                }

                if ($ukuranKB2 > $maxFileSize) {
                    return response()->json([
                        'MSGTYPE' => 'W',
                        'MSG' => 'Image size cannot be more than 10 MB',
                    ]);
                }


                $room_name_2 = str_replace(' ', '_', $room_name);
                $imgName2 = $room_name_2 . '_2_' . time() . '.' . $ekstensi2;
                $file2->move(public_path('RoomMeetingFoto'), $imgName2);

                $client = new Client();
                $filePath = public_path('RoomMeetingFoto') . '/' . $imgName2;
                    $response = $client->request('POST', 'https://webapi.satnusa.com/api/platform/upload-file', [
                        'multipart' => [
                            [
                                'name'     => 'file_upload',
                                'contents' => fopen($filePath, 'r'),
                                'filename' => $imgName2,
                            ],
                        ],
                    ]);
                    $statusCode = $response->getStatusCode();
                    if ($statusCode != 200) {
                        // Gagal mengunggah file ke platform
                        return response()->json([
                            'MSGTYPE' => 'W',
                            'MSG' => 'Gagal mengunggah file ke platform',
                        ]);
                    }


                $data['roomimage_2'] = $imgName2;
            }

            if ($file3) {
                $ekstensi3 = $file3->getClientOriginalExtension();
                $sizeFile3 = $file3->getSize();
                $ukuranKB3 = round($sizeFile3 / 1024, 2);

                if (!empty($ekstensi3) && !in_array(strtolower($ekstensi3), $allowEkstensi)) {
                    return response()->json([
                        'MSGTYPE' => 'W',
                        'MSG' => 'Insert image available in JPG, PNG, and JPEG formats.',
                    ]);
                }

                if ($ukuranKB3 > $maxFileSize) {
                    return response()->json([
                        'MSGTYPE' => 'W',
                        'MSG' => 'Image size cannot be more than 10 MB',
                    ]);
                }

                $room_name_3 = str_replace(' ', '_', $room_name);
                $imgName3 = $room_name_3 . '_3_' . time() . '.' . $ekstensi3;
                $file3->move(public_path('RoomMeetingFoto'), $imgName3);

                $client = new Client();
                $filePath = public_path('RoomMeetingFoto') . '/' . $imgName3;
                    $response = $client->request('POST', 'https://webapi.satnusa.com/api/platform/upload-file', [
                        'multipart' => [
                            [
                                'name'     => 'file_upload',
                                'contents' => fopen($filePath, 'r'),
                                'filename' => $imgName3,
                            ],
                        ],
                    ]);
                    $statusCode = $response->getStatusCode();
                    if ($statusCode != 200) {
                        // Gagal mengunggah file ke platform
                        return response()->json([
                            'MSGTYPE' => 'W',
                            'MSG' => 'Gagal mengunggah file ke platform',
                        ]);
                    }

                $data['roomimage_3'] = $imgName3;
            }
             // Kirim file menggunakan Guzzle


            DB::table('tbl_roommeeting')
                ->where('id', $id)
                ->update($data);

            return response()->json([
                'MSGTYPE' => 'S',
                'MSG' => 'SUCCESS',
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json([
                'MSGTYPE' => 'W',
                'MSG' => 'Something Went Wrong',
            ]);
        }
    }

    // detail function
    public function detail(Request $request)
    {
        //  dd($request);

        $id = $request->input('RoomId');

        $data = DB::table('tbl_roommeeting')
            ->select('id', 'room_name', 'floor', 'capacity', 'roomimage_1', 'roomimage_2', 'roomimage_3','dept')
            ->where('id', $id)
            ->first();

        return response()->json([
            'dataRoomId' => $data,
        ]);
    }

    // delete function
    public function delete(Request $request)
    {
        $id = $request->input('id');

        try {
            // Ambil nama gambar dari database
            $data = DB::table('tbl_roommeeting')
                ->where('id', $id)
                ->first();

            if ($data) {
                $image1 = $data->roomimage_1;
                $image2 = $data->roomimage_2;
                $image3 = $data->roomimage_3;
            }
            $path1 = public_path('RoomMeetingFoto/') . $image1;
            $path2 = public_path('RoomMeetingFoto/') . $image2;
            $path3 = public_path('RoomMeetingFoto/') . $image3;

            if (File::exists($path1)) {
                File::delete($path1);
            }

            if (File::exists($path2)) {
                File::delete($path2);
            }

            if (File::exists($path3)) {
                File::delete($path3);
            }

            // Hapus data dari database
            DB::table('tbl_roommeeting')
                ->where('id', $id)
                ->delete();

            return response()->json([
                'MSGTYPE' => 'S',
                'MSG' => 'OK.',
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json('FAILED.', 400);
        }
    }
}
