<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\DailyInternExport;
use App\Exports\MonthlyInternExport;
use App\Imports\InternshipAttendanceImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class InternshipController extends Controller
{
    public function index(Request $req)
    {
        $filter = $req->get('filter');

        $now = $req->get('now');
        $q = 'SELECT * FROM tbl_deptcode ORDER BY dept_name';
        $list_dept = DB::select($q);
        // query filter
        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,

            'list_dept' => $list_dept,
        ];

        return view('internship.index', $data);
    }

    public function getList(Request $request)
    {
        $txSearch = '%' . trim($request->txSearch) . '%';

        $DateEvent = $request->dateRange;
        $deptCode = $request->selectDeptFilter;
        /**
         * Convert range date ke YYYY-MM-DD
         **/
        if ($DateEvent) {
            if (strpos($DateEvent, ' to ') !== false) {
                // Pisahkan tanggal menggunakan "to"
                [$start_date, $end_date] = explode(' to ', $DateEvent);

                // Format ulang tanggal dalam format YYYY-MM-DD
                $start_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
                $end_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));
                // dd($start_date_formatted, $end_date_formatted);
            } else {
                $start_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateEvent)));
                $end_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateEvent)));

                // dd($start_date_formatted, $end_date_formatted);
            }
        }

        // filter Departemen
        $dFilter = '';
        if ($deptCode > 0) {
            $dFilter .= " AND dept_code = '$deptCode'";
        } else {
            $dFilter .= '';
        }
        // filter range date
        $rFilter = '';
        if ($DateEvent > 0) {
            $rFilter .= " AND a.submit_date BETWEEN '$start_date_formatted' AND '$end_date_formatted'";
        } else {
            $rFilter .= '';
        }

        /**
         * Mengambil Request dari modal Filter berupa checkbox
         **/
        // Konversi nilai checkbox
        $attendanceMapping = [
            'Present' => 1,
            'Permission' => 2,
            'Absent' => 3,
            '-' => 4,
        ];
        $attendance = [];
        // Mengambil semua kunci yang sesuai dengan format 'attendance'
        $keys = array_keys($request->all());
        // Deklarasikan mapping antara attendance key dan nilai yang diinginkan
        $attendanceMapping = [
            'attendance_1' => 'Present',
            'attendance_2' => 'Permission',
            'attendance_3' => 'Absent',
            'attendance_4' => 'NSI&O',
            'attendance_5' => 'Sick',
        ];
        // Dapatkan kunci yang berhubungan dengan kehadiran
        $attendanceKeys = array_filter($keys, function ($key) {
            return preg_match('/^attendance_\d+$/', $key);
        });
        // Mengonversi kunci ke nilai menggunakan mapping
        $attendance = array_map(function ($key) use ($attendanceMapping, $request) {
            $isChecked = $request->input($key) === 'true';
            return [
                'status' => $attendanceMapping[$key],
                'isChecked' => $isChecked,
            ];
        }, $attendanceKeys);
        // Mengambil hanya nilai yang isChecked bernilai true
        $checkedAttendance = array_filter($attendance, function ($item) {
            return $item['isChecked'];
        });
        // Mengonversi array ke dalam string dengan tanda petik satu (') di awal dan akhir
        $checkedAttendanceString = "'" . implode("', '", array_column($checkedAttendance, 'status')) . "'";

        $sFilter = '';
        if ($checkedAttendance) {
            $sFilter = " AND a.status IN ($checkedAttendanceString)";
            // dd($sFilter);
        } else {
            // Handle jika $selectRoom adalah string kosong atau bukan array
            $sFilter = ''; // Atau sesuai dengan apa yang Anda butuhkan dalam kasus ini
        }

        $query = "SELECT k.badge_id, k.fullname ,
        (SELECT dept_name FROM tbl_deptcode dc
        WHERE dc.dept_code = k.dept_code)AS dept_name, a.submit_date, a.scanin, a.scanout, a.status, a.attachment
        FROM tbl_absensiinternship a JOIN tbl_karyawan k ON a.badge_id = k.badge_id
        WHERE (fullname LIKE '$txSearch' OR k.badge_id LIKE '$txSearch' OR a.status LIKE '$txSearch') $dFilter $rFilter $sFilter
        ORDER BY a.submit_date DESC, scanin desc LIMIT 200";
        $data = DB::select($query);

        $output = '';
        $output .= '
            <table id="tableInternship" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                            <th class="p-3" scope="col">Employee No</th>
                            <th class="p-3" scope="col">Employee Name</th>
                            <th class="p-3" scope="col">Department</th>
                            <th class="p-3" scope="col">Date</th>
                            <th class="p-3" scope="col">Time In</>
                            <th class="p-3" scope="col">Time Out</th>
                            <th class="p-3" scope="col">Status</th>
                            <th class="p-3" scope="col">Action</th>
                        </tr>
                </thead>
                <tbody>
        ';
        $no = 1;
        foreach ($data as $key => $item) {
            $attachment = $item->attachment
                ? '<a id="btnAttach" class="btn btnAttach" data-id=' .
                    $item->badge_id .
                    ' data-date=' .
                    $item->submit_date .
                    '><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M16 13H8M16 17H8M10 9H8M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8L14 2Z" stroke="#60625D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg></a>  '
                : '';

            $scanin = $item->scanin ? date('H:i', strtotime($item->scanin)) : '-';
            $scanout = $item->scanout ? date('H:i', strtotime($item->scanout)) : '-';
            $highlightClass = $item->status == 'OFF' ? 'style="background-color: #f8d7da;"' : '';
            $highlightStatus = $item->status == 'Absent' ? '<p class="badge bg-danger">' . $item->status . '</p>' : $item->status;

            $output .=
                '
                <tr>
                    <td class="p-3" ' .
                $highlightClass .
                ' >' .
                $item->badge_id .
                '</td>
                    <td class="p-3" ' .
                $highlightClass .
                '>' .
                $item->fullname .
                '</td>
                    <td class="p-3" ' .
                $highlightClass .
                '>' .
                $item->dept_name .
                '</td>
                    <td class="p-3" ' .
                $highlightClass .
                '>' .
                date('d F Y', strtotime($item->submit_date)) .
                '</td>
                <td class="p-3" ' .
                $highlightClass .
                '>' .
                $scanin .
                '</td>
                <td class="p-3" ' .
                $highlightClass .
                '>' .
                $scanout .
                '</td>
                <td class="p-3" ' .
                $highlightClass .
                '   >' .
                $highlightStatus .
                '</td>
                <td ' .
                $highlightClass .
                '>
                    <a href="' .
                    url('/internship/detailInternship?badge_id=' . $item->badge_id . '&date=' . $item->submit_date) .
                '" id="btnInfo" class="btn btnInfo">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.0136 11.7722C22.9817 11.6991 22.2017 9.96938 20.4599 8.2275C18.8436 6.61313 16.0667 4.6875 11.9999 4.6875C7.93299 4.6875 5.15611 6.61313 3.53986 8.2275C1.79799 9.96938 1.01799 11.6962 0.986113 11.7722C0.954062 11.8442 0.9375 11.9221 0.9375 12.0009C0.9375 12.0798 0.954062 12.1577 0.986113 12.2297C1.01799 12.3019 1.79799 14.0316 3.53986 15.7734C5.15611 17.3878 7.93299 19.3125 11.9999 19.3125C16.0667 19.3125 18.8436 17.3878 20.4599 15.7734C22.2017 14.0316 22.9817 12.3047 23.0136 12.2297C23.0457 12.1577 23.0622 12.0798 23.0622 12.0009C23.0622 11.9221 23.0457 11.8442 23.0136 11.7722ZM11.9999 18.1875C9.05799 18.1875 6.48924 17.1169 4.36393 15.0066C3.473 14.1211 2.71908 13.1078 2.12705 12C2.71891 10.8924 3.47285 9.87932 4.36393 8.99438C6.48924 6.88313 9.05799 5.8125 11.9999 5.8125C14.9417 5.8125 17.5105 6.88313 19.6358 8.99438C20.5269 9.87932 21.2808 10.8924 21.8727 12C21.2755 13.1447 18.2811 18.1875 11.9999 18.1875ZM11.9999 7.6875C11.1469 7.6875 10.3132 7.94042 9.60397 8.41429C8.89478 8.88815 8.34204 9.56167 8.01563 10.3497C7.68923 11.1377 7.60383 12.0048 7.77023 12.8413C7.93663 13.6779 8.34735 14.4463 8.95047 15.0494C9.55358 15.6525 10.322 16.0632 11.1585 16.2296C11.9951 16.396 12.8622 16.3106 13.6502 15.9842C14.4382 15.6578 15.1117 15.1051 15.5856 14.3959C16.0594 13.6867 16.3124 12.8529 16.3124 12C16.3109 10.8567 15.856 9.76067 15.0476 8.95225C14.2392 8.14382 13.1432 7.68899 11.9999 7.6875ZM11.9999 15.1875C11.3694 15.1875 10.7532 15.0006 10.229 14.6503C9.7048 14.3001 9.29625 13.8022 9.055 13.2198C8.81374 12.6374 8.75062 11.9965 8.87361 11.3781C8.9966 10.7598 9.30018 10.1919 9.74596 9.7461C10.1917 9.30032 10.7597 8.99674 11.378 8.87375C11.9963 8.75076 12.6372 8.81388 13.2197 9.05513C13.8021 9.29639 14.2999 9.70494 14.6502 10.2291C15.0004 10.7533 15.1874 11.3696 15.1874 12C15.1874 12.8454 14.8515 13.6561 14.2538 14.2539C13.656 14.8517 12.8452 15.1875 11.9999 15.1875Z" fill="#60625D"/>
                        </svg>
                    </a> <a id="btnEdit" class="btn btnEdit" data-id=' .
                $item->badge_id .
                ' data-date=' .
                $item->submit_date .
                '><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 22.525C3.45 22.525 2.979 22.3293 2.587 21.938C2.195 21.5467 1.99934 21.0757 2 20.525V6.525C2 5.975 2.196 5.504 2.588 5.112C2.98 4.72 3.45067 4.52433 4 4.525H12.925L10.925 6.525H4V20.525H18V13.575L20 11.575V20.525C20 21.075 19.804 21.546 19.412 21.938C19.02 22.33 18.5493 22.5257 18 22.525H4ZM15.175 5.1L16.6 6.5L10 13.1V14.525H11.4L18.025 7.9L19.45 9.3L12.825 15.925C12.6417 16.1083 12.429 16.2543 12.187 16.363C11.945 16.4717 11.691 16.5257 11.425 16.525H9C8.71667 16.525 8.479 16.429 8.287 16.237C8.095 16.045 7.99934 15.8077 8 15.525V13.1C8 12.8333 8.05 12.579 8.15 12.337C8.25 12.095 8.39167 11.8827 8.575 11.7L15.175 5.1ZM19.45 9.3L15.175 5.1L17.675 2.6C18.075 2.2 18.5543 2 19.113 2C19.6717 2 20.1423 2.2 20.525 2.6L21.925 4.025C22.3083 4.40833 22.5 4.875 22.5 5.425C22.5 5.975 22.3083 6.44167 21.925 6.825L19.45 9.3Z" fill="#60625D"/>
                        </svg></a>' .
                $attachment .
                '
                        </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    public function getAttach(Request $request)
    {
        $badgeId = $request->badgeId;
        $date = $request->date;

        $query = "SELECT attachment
        FROM tbl_absensiinternship
        WHERE badge_id = '$badgeId'
        AND submit_date = '$date'";
        $data = DB::select($query);

        return response()->json([
            'viewAttachment' => $data[0],
        ]);
    }

    public function getValue(Request $request)
    {
        $badge_id = $request->badgeId;
        $date = $request->date;

        $query = "SELECT k.badge_id, a.id,k.fullname ,
        (SELECT dept_name FROM tbl_deptcode dc
        WHERE dc.dept_code = k.dept_code)AS dept_name, a.submit_date, a.scanin, a.scanout, a.status, a.attachment
        FROM tbl_absensiinternship a JOIN tbl_karyawan k ON a.badge_id = k.badge_id
        WHERE a.badge_id = '$badge_id'
        AND a.submit_date = '$date'";
        $data = DB::select($query);

        $data[0]->scanin = $data[0]->scanin ? date('H:i', strtotime($data[0]->scanin)) : null;

        $data[0]->submit_date = $data[0]->submit_date ? date('d F Y', strtotime($data[0]->submit_date)) : null;

        $data[0]->scanout = $data[0]->scanout ? date('H:i', strtotime($data[0]->scanout)) : null;

        return response()->json([
            'viewValue' => $data[0],
        ]);
    }

    public function update(Request $request)
    {
        $sessionLogin = session('loggedInUser');
        $badgeId = $sessionLogin['session_badge'];

        $idAttendance = $request->idAttendance;
        $dateSubmit = $request->dateSubmit;
        $formattedDate = date('Y-m-d', strtotime($dateSubmit));
        
        
        $timeIn = $request->timeInEdit ? $request->timeInEdit . ':00' : '';
        $timeOut = $request->timeOutEdit ? $request->timeOutEdit . ':00' : '' ;
        
        $combinedDateTimeIn = $timeIn ? $formattedDate . ' ' . $timeIn : NULL;
        $combinedDateTimeOut = $timeOut ? $formattedDate . ' ' . $timeOut : NULL;
        
        // dd($combinedDateTimeIn, $combinedDateTimeOut);
        $attendOption = $request->attendOption;
        $fileAttach = $request->file('imageAttach') ? $request->file('imageAttach') : $request->file('imageAttachPermission');
        
        $base64String1 = '';
        if ($fileAttach) {
            $sizeFile1 = $fileAttach->getSize();
            $ukuranKB1 = round($sizeFile1 / 1024, 2);
            
            $maxFileSize = 10240; // 10 MB dalam KB
            if ($ukuranKB1 > $maxFileSize) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Image size cannot be more than 10 MB',
                ]);
            }   
            
            $fileContent = file_get_contents($fileAttach->getRealPath());
            $base64String1 = 'data:image/png;base64,' . base64_encode($fileContent);
        }
        
        if ($combinedDateTimeOut < $combinedDateTimeIn) {
                return response()->json([
                    'MSGTYPE' => 'E',
                    'MSG' => 'Time In and Time Out is not valid!',
                ]);
            }


        $query = "SELECT * FROM tbl_absensiinternship WHERE id = '$idAttendance'";
        $checkId = DB::select($query);
        // dd($combinedDateTimeIn, $combinedDateTimeOut, $attendOption, $base64String1, $badgeId, $idAttendance, $checkId[0]->submit_date);
        DB::table('tbl_absensiinternship')
            ->where('id', $idAttendance)
            ->update([
                'scanin' => $combinedDateTimeIn,
                'scanout' => $combinedDateTimeOut,
                'status' => $attendOption,
                'attachment' => $base64String1,
                'updateby' => $badgeId,
                'updatedate' => now(),
            ]);
    }

    public function dailyExport(Request $request){
        // dd($request->all()); 

        $DateEvent = $request->dateDaily;
        $deptCode = $request->deptDaily;

        
        if ($DateEvent) {
            if (strpos($DateEvent, ' to ') !== false) {
                // Pisahkan tanggal menggunakan "to"
                [$start_date, $end_date] = explode(' to ', $DateEvent);

                // Format ulang tanggal dalam format YYYY-MM-DD
                $start_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
                $end_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));
                // dd($start_date_formatted, $end_date_formatted);
            } else {
                $start_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateEvent)));
                $end_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateEvent)));

                // dd($start_date_formatted, $end_date_formatted);
            }
        }

        // filter Departemen
        $dFilter = '';
        if ($deptCode > 0) {
            $dFilter .= " WHERE dept_code = '$deptCode'";
        } else {
            $dFilter .= '';
        }
        // filter range date
        $rFilter = '';
        if ($DateEvent > 0) {
            $rFilter .= " AND a.submit_date BETWEEN '$start_date_formatted' AND '$end_date_formatted'";
        } else {
            $rFilter .= '';
        }


        // dd($rFilter);
        return Excel::download(new DailyInternExport($dFilter, $rFilter), 'Daily_Internship.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }


    public function monthlyExport(Request $request){
        // dd($request->all());    

        $deptMonthly = $request->deptMonthly;
        $monthExport = $request->monthExport;

        $timestamp = strtotime($monthExport);

        if ($timestamp !== false) {
            $monthNumber = date('n', $timestamp);
        } else {
            $monthNumber = '';
        }

        $yFilter = '';

        $mFilter = '';
        // filter bulan
        if ($monthNumber > 0) {
            $mFilter .= " AND MONTH(a.submit_date) = '$monthNumber'";
        } else {
            $mFilter .= '';
        }

        // filter Departemen
        $dFilter = '';
        if ($deptMonthly > 0) {
            $dFilter .= " WHERE dept_code = '$deptMonthly'";
        } else {
            $dFilter .= '';
        }
    
        return Excel::download(new MonthlyInternExport($dFilter, $mFilter, $monthNumber, $deptMonthly), 'Monthly_Internship.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    // import
    public function import(Request $request)
    {
        $sessionLogin = session('loggedInUser');
        $badgeId = $sessionLogin['session_badge'];

        $fileUpload = $request->file('file');
        $extension = $fileUpload->getClientOriginalExtension();

        // apabila ekstensi tidak xlsx
        if ($extension != 'xlsx') {
            return response()->json([
                "MSGTYPE" => "W",
                "MSG"     => "Sorry File must be xlsx format"
            ]);
        }

        try {
            Excel::import(new InternshipAttendanceImport($badgeId), $request->file);
            return response()->json([
                "MSGTYPE" => "S",
                "MSG"     => "OK."
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
            return response()->json('FAILED.', 400);
        } catch (\Throwable $th) {
            return response()->json([
                "MSGTYPE" => "W",
                "MSG"     => $th->getMessage()
            ]);
        }

    }
   
}
