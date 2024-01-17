<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class UpdateEmployeeDataNoticeController extends Controller
{
    //  
    public function index()
    {

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
        ];


        return view('updateEmpData.dataNotice.indexdatanotice', $data);
    }

    public function getlistnotice(Request $request)
    {
        $result = $request->input('result');
    
        $q = "SELECT * FROM (
            SELECT id,
            description,
            DATE_FORMAT(startdate, '%d %b %Y %h:%i %p') AS formatted_startdate,
            DATE_FORMAT(enddate, '%d %b %Y %h:%i %p') AS formatted_enddate,
               IF(NOW() > startdate AND NOW() < enddate, 'Berlangsung',

                  IF(NOW() > enddate, 'Selesai', 'Menunggu')) AS status

        FROM tbl_pengumumanpengkinian

    ) AS subquery

    WHERE UPPER(status) LIKE UPPER('%$result%')

    ORDER BY 

        CASE 

            WHEN status = 'Menunggu' THEN 1

            WHEN status = 'Berlangsung' THEN 2

            WHEN status = 'Selesai' THEN 3

            ELSE 4

        END;       
        ";  
         $data = DB::select($q); 

 
         $output = '';
         $output .= '
             <table id="tableupdatenotice" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                    <th class="p-3" scope="col">Waktu Pengumuman</th>
                    <th class="p-3" scope="col">Pengumuman Selesai pada</th>
                    <th class="p-3" scope="col">Status</th>
                    <th class="p-3" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            ';

            $btnDetailDisplay = '';  
            $btnEditDisplay = 'none';
            $btnDeleteDisplay = 'none';
                    
         foreach ($data as $key => $item) {

            $statusColor = '';
            switch ($item->status) {
                case 'Berlangsung':
                    $statusColor = 'background-color: #B2D7F0; color: #000000;';
                    $btnDetailDisplay = ''; 
                    $btnEditDisplay = '';
                    $btnDeleteDisplay = 'none';
                    break;
                case 'Menunggu':
                    $statusColor = 'background-color: #FFE7B0; color: #000000;';
                    $btnDetailDisplay = ''; 
                    $btnEditDisplay = '';
                    $btnDeleteDisplay = '';

                    break;
                case 'Selesai':
                    $statusColor = 'background-color: #B9E9C8; color: #000000;';
                    $btnDetailDisplay = '';
                    $btnEditDisplay = 'none';
                    $btnDeleteDisplay = 'none';
                    break;
                default:
                    $statusColor = '';
            }

             $output .=
                 '
                 <tr class = "align-middle">
                     <td class="p-3">' . ($item->formatted_startdate ) .'</td>
                     <td class="p-3">' . ($item->formatted_enddate ) .'</td>
                    <td class="p-3"><span style="' . $statusColor . ' border-radius: 5px; padding: 5px;">' . ($item->status) . '</span></td>
                     <td class="p-3">


                     <a class="btn btnDetailnotice"  data-id="' . $item->id . '"  data-description="' . $item->description . '" data-startdate="' . $item->formatted_startdate . '" data-enddate="' . $item->formatted_enddate . '" data-status="' . $item->status . '" style="display: ' . $btnDetailDisplay . ';">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M23.0136 11.7722C22.9817 11.6991 22.2017 9.96938 20.4599 8.2275C18.8436 6.61313 16.0667 4.6875 11.9999 4.6875C7.93299 4.6875 5.15611 6.61313 3.53986 8.2275C1.79799 9.96938 1.01799 11.6962 0.986113 11.7722C0.954062 11.8442 0.9375 11.9221 0.9375 12.0009C0.9375 12.0798 0.954062 12.1577 0.986113 12.2297C1.01799 12.3019 1.79799 14.0316 3.53986 15.7734C5.15611 17.3878 7.93299 19.3125 11.9999 19.3125C16.0667 19.3125 18.8436 17.3878 20.4599 15.7734C22.2017 14.0316 22.9817 12.3047 23.0136 12.2297C23.0457 12.1577 23.0622 12.0798 23.0622 12.0009C23.0622 11.9221 23.0457 11.8442 23.0136 11.7722ZM11.9999 18.1875C9.05799 18.1875 6.48924 17.1169 4.36393 15.0066C3.473 14.1211 2.71908 13.1078 2.12705 12C2.71891 10.8924 3.47285 9.87932 4.36393 8.99438C6.48924 6.88313 9.05799 5.8125 11.9999 5.8125C14.9417 5.8125 17.5105 6.88313 19.6358 8.99438C20.5269 9.87932 21.2808 10.8924 21.8727 12C21.2755 13.1447 18.2811 18.1875 11.9999 18.1875ZM11.9999 7.6875C11.1469 7.6875 10.3132 7.94042 9.60397 8.41429C8.89478 8.88815 8.34204 9.56167 8.01563 10.3497C7.68923 11.1377 7.60383 12.0048 7.77023 12.8413C7.93663 13.6779 8.34735 14.4463 8.95047 15.0494C9.55358 15.6525 10.322 16.0632 11.1585 16.2296C11.9951 16.396 12.8622 16.3106 13.6502 15.9842C14.4382 15.6578 15.1117 15.1051 15.5856 14.3959C16.0594 13.6867 16.3124 12.8529 16.3124 12C16.3109 10.8567 15.856 9.76067 15.0476 8.95225C14.2392 8.14382 13.1432 7.68899 11.9999 7.6875ZM11.9999 15.1875C11.3694 15.1875 10.7532 15.0006 10.229 14.6503C9.7048 14.3001 9.29625 13.8022 9.055 13.2198C8.81374 12.6374 8.75062 11.9965 8.87361 11.3781C8.9966 10.7598 9.30018 10.1919 9.74596 9.7461C10.1917 9.30032 10.7597 8.99674 11.378 8.87375C11.9963 8.75076 12.6372 8.81388 13.2197 9.05513C13.8021 9.29639 14.2999 9.70494 14.6502 10.2291C15.0004 10.7533 15.1874 11.3696 15.1874 12C15.1874 12.8454 14.8515 13.6561 14.2538 14.2539C13.656 14.8517 12.8452 15.1875 11.9999 15.1875Z" fill="#60625D"/>
                     </svg>
                        </a>
                  
                     <a class="btn btnEditDriver" id="btnedit" data-id="' . $item->id . '"  data-description="' . $item->description . '" data-startdate="' . $item->formatted_startdate . '" data-enddate="' . $item->formatted_enddate . '" data-status="' . $item->status . '" style="display: ' . $btnEditDisplay . ';">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M4 22.525C3.45 22.525 2.979 22.3293 2.587 21.938C2.195 21.5467 1.99934 21.0757 2 20.525V6.525C2 5.975 2.196 5.504 2.588 5.112C2.98 4.72 3.45067 4.52433 4 4.525H12.925L10.925 6.525H4V20.525H18V13.575L20 11.575V20.525C20 21.075 19.804 21.546 19.412 21.938C19.02 22.33 18.5493 22.5257 18 22.525H4ZM15.175 5.1L16.6 6.5L10 13.1V14.525H11.4L18.025 7.9L19.45 9.3L12.825 15.925C12.6417 16.1083 12.429 16.2543 12.187 16.363C11.945 16.4717 11.691 16.5257 11.425 16.525H9C8.71667 16.525 8.479 16.429 8.287 16.237C8.095 16.045 7.99934 15.8077 8 15.525V13.1C8 12.8333 8.05 12.579 8.15 12.337C8.25 12.095 8.39167 11.8827 8.575 11.7L15.175 5.1ZM19.45 9.3L15.175 5.1L17.675 2.6C18.075 2.2 18.5543 2 19.113 2C19.6717 2 20.1423 2.2 20.525 2.6L21.925 4.025C22.3083 4.40833 22.5 4.875 22.5 5.425C22.5 5.975 22.3083 6.44167 21.925 6.825L19.45 9.3Z" fill="#60625D"/>
                         </svg>                                                
                     </a>

                     <a class="btn btnDeletenotice" data-id="' . $item->id . '" id="btndelete" data-bs-toggle="modal"  style="display: ' . $btnDeleteDisplay . ';">
                         <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M8 4H12C12 3.46957 11.7893 2.96086 11.4142 2.58579C11.0391 2.21071 10.5304 2 10 2C9.46957 2 8.96086 2.21071 8.58579 2.58579C8.21071 2.96086 8 3.46957 8 4ZM6.5 4C6.5 3.54037 6.59053 3.08525 6.76642 2.66061C6.94231 2.23597 7.20012 1.85013 7.52513 1.52513C7.85013 1.20012 8.23597 0.942313 8.66061 0.766422C9.08525 0.59053 9.54037 0.5 10 0.5C10.4596 0.5 10.9148 0.59053 11.3394 0.766422C11.764 0.942313 12.1499 1.20012 12.4749 1.52513C12.7999 1.85013 13.0577 2.23597 13.2336 2.66061C13.4095 3.08525 13.5 3.54037 13.5 4H19.25C19.4489 4 19.6397 4.07902 19.7803 4.21967C19.921 4.36032 20 4.55109 20 4.75C20 4.94891 19.921 5.13968 19.7803 5.28033C19.6397 5.42098 19.4489 5.5 19.25 5.5H17.93L16.76 17.611C16.6702 18.539 16.238 19.4002 15.5477 20.0268C14.8573 20.6534 13.9583 21.0004 13.026 21H6.974C6.04186 21.0001 5.1431 20.653 4.45295 20.0265C3.7628 19.3999 3.33073 18.5388 3.241 17.611L2.07 5.5H0.75C0.551088 5.5 0.360322 5.42098 0.21967 5.28033C0.0790175 5.13968 0 4.94891 0 4.75C0 4.55109 0.0790175 4.36032 0.21967 4.21967C0.360322 4.07902 0.551088 4 0.75 4H6.5ZM8.5 8.75C8.5 8.55109 8.42098 8.36032 8.28033 8.21967C8.13968 8.07902 7.94891 8 7.75 8C7.55109 8 7.36032 8.07902 7.21967 8.21967C7.07902 8.36032 7 8.55109 7 8.75V16.25C7 16.4489 7.07902 16.6397 7.21967 16.7803C7.36032 16.921 7.55109 17 7.75 17C7.94891 17 8.13968 16.921 8.28033 16.7803C8.42098 16.6397 8.5 16.4489 8.5 16.25V8.75ZM12.25 8C12.4489 8 12.6397 8.07902 12.7803 8.21967C12.921 8.36032 13 8.55109 13 8.75V16.25C13 16.4489 12.921 16.6397 12.7803 16.7803C12.6397 16.921 12.4489 17 12.25 17C12.0511 17 11.8603 16.921 11.7197 16.7803C11.579 16.6397 11.5 16.4489 11.5 16.25V8.75C11.5 8.55109 11.579 8.36032 11.7197 8.21967C11.8603 8.07902 12.0511 8 12.25 8ZM4.734 17.467C4.78794 18.0236 5.04724 18.5403 5.46137 18.9161C5.87549 19.292 6.41475 19.5001 6.974 19.5H13.026C13.5853 19.5001 14.1245 19.292 14.5386 18.9161C14.9528 18.5403 15.2121 18.0236 15.266 17.467L16.424 5.5H3.576L4.734 17.467Z" fill="#60625D"/>
                         </svg>                                              
                     </a>


                     </td>
                 </tr>
             ';
         }
 
         $output .= '</tbody></table>';
         return $output;

    }

    public function tambahnotice(Request $request)
    {
        // Ambil input dari request
        $description = $request->input('description');
        $enddate = Carbon::parse($request->input('endDate'))->format('Y-m-d H:i:s');
        $checkbox = $request->input('checkbox');
        $startDate = ($checkbox == 1) ? now() : Carbon::parse($request->input('startDate'))->format('Y-m-d H:i:s');

    
        // Validasi tambahan: pastikan tidak ada data dengan rentang waktu yang sama
        $existingData = DB::table('tbl_pengumumanpengkinian')
            ->where(function ($query) use ($startDate, $enddate) {
                $query->where('startdate', '<', $enddate)
                    ->where('enddate', '>', $startDate);
            })
            ->exists();

    
        if ($existingData) {
            return response()->json(['error' => 'Pengumuman telah ada pada rentang waktu tersebut!'], 400);
        }
    
        // Data valid, masukkan ke database
        $data = [
            'description' => $description,
            'enddate' => $enddate,
            'startdate' => $startDate,
        ];
    
        DB::table('tbl_pengumumanpengkinian')->insert($data);
    
        return response()->json(['message' => 'Pengumuman Berhasil Ditambahkan']);
    }
    

    public function hapusnotice(Request $request)
    {
        $id = $request->input('id');
    
        // Hapus data berdasarkan ID
        DB::table('tbl_pengumumanpengkinian')->where('id', $id)->delete();
    
        return response()->json(['message' => 'Pengumuman berhasil dihapus']);
    }


    public function updatenotice(Request $request)
    {
        $id = $request->input('id');
        $desc = $request->input('desc');
        $startDate = Carbon::parse($request->input('startdate'))->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($request->input('enddate'))->format('Y-m-d H:i:s');

        $count = DB::table('tbl_pengumumanpengkinian')
        ->where('id', '<>', $id)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('startdate', [$startDate, $endDate])
                  ->orWhereBetween('enddate', [$startDate, $endDate])
                  ->orWhere(function ($query) use ($startDate, $endDate) {
                      $query->where('startdate', '<=', $startDate)
                            ->where('enddate', '>=', $endDate);
                  });
        })
        ->count();

        if ($count > 0) {
            return response()->json(['error' => 'Waktu Pengumuman Sudah Ada'], 400);
        } else {
            $updatedata = [
                'description' => $desc,
                'startdate'=> $startDate,
                'enddate'=> $endDate,
            ];

            DB::table('tbl_pengumumanpengkinian')->where('id', $id)->update($updatedata);

            return response()->json(['success' => true, 'message' => 'Pengumuman Berhasil di Update']);

        };

    }
    
}