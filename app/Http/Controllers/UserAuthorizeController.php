<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserAuthorizeController extends Controller
{

    public function index()
    {
        $q = 'SELECT * FROM tbl_deptcode ORDER BY dept_name';
        $list_dept = DB::select($q);

        $query_list_participant = 'SELECT fullname, badge_id, p.position_name FROM tbl_karyawan k LEFT JOIN tbl_position p ON p.position_code = k.position_code';
        $list_participant = DB::select($query_list_participant);

        $query_role_meeting = 'SELECT id, name FROM tbl_rolemeeting';
        $list_role = DB::select($query_role_meeting);

        $sessionBadge = session('loggedInUser')['session_badge'];
        $queryPosition = "SELECT (SELECT p.position_name from tbl_position p WHERE k.position_code = p.position_code) AS position_name FROM tbl_karyawan k WHERE badge_id = '$sessionBadge'";
        $positionName = DB::select($queryPosition)[0]->position_name;

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => $positionName,
                'list_dept' => $list_dept,
                'list_participant' => $list_participant,
                'list_role' => $list_role,
        ];

        return view('userauthorize.index', $data);
    }

    public function getList(Request $request){
        // dd($request->all());
        $txSearch = '%' . trim($request->txSearch) . '%';

        // dd($txSearch);

        $queryList = "SELECT k.badge_id as badgeId, k.fullname, r.name as rolemenu FROM tbl_karyawan k
        INNER JOIN tbl_useradmin a ON a.badge_id = k.badge_id
        INNER JOIN tbl_rolemeeting r ON r.id = a.user_level
        WHERE (k.fullname LIKE '$txSearch' OR k.badge_id LIKE '$txSearch')
        AND a.is_active = 1
       ";

        $data = DB::select($queryList);

        $output = '';
        $output .= '
            <table id="tableUserRole" class="table table-responsive table-hover" style="font-size: 16px">
            <thead>
                <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                        <th class="p-3" scope="col">Employee No</th>
                        <th class="p-3" scope="col">Fullname</th>
                        <th class="p-3" scope="col">Role</th>
                        <th class="p-3" scope="col">Action</th>
                    </tr>
            </thead>
            <tbody>
        ';

        $no = 1;
        foreach ($data as $key => $item) {
            $output .=
            '
                <tr>
                    <td class="p-3">' . $item->badgeId . '</td>
                    <td class="p-3">' . $item->fullname . ' </td>
                    <td class="p-3">' . $item->rolemenu . '</td>
                    <td> <a id="btnEdit" class="btn btnEdit" data-id=' .$item->badgeId .'><img src="' . asset('icons/Edit.svg') .'"></a>
                    </td>
                </tr>
            ';
        }
        $output .= '</tbody></table>';
        // dd($output);
        return $output;


    }

    public function getDept(Request $request)
    {
        // dd($request->all());
        $badge_id = $request->selectedValue;

        // Gunakan placeholder ? pada query
        $queryDefault = "SELECT LEFT(line_code, 4) AS linecode FROM tbl_karyawan WHERE badge_id = ?";

        // Jalankan query dengan parameter yang aman
        $DeptL = DB::select($queryDefault, [$badge_id]);

        // Ambil hasil query
        $deptDefault = isset($DeptL[0]) ? $DeptL[0]->linecode : null;

        return response()->json([
            'DefaultDept' => $deptDefault,
        ]);
    }

    public function insert(Request $request)
    {
        $sessionLogin = session('loggedInUser');
        $sessionBadge = $sessionLogin['session_badge'];
        // dd($request->all());
        try {
            $badge_id = $request->selectEmployeeAdd;
            $OtherDeptYesNo = $request->OtherDept;
            $allListParticipant = $request->allListParticipant ? $request->allListParticipant : null;
            $selectRoleAdd = intval($request->selectRoleAdd);
            $dept = $request->dept ? $request->dept : null ;

            $defaultPassword = 'Passw0rd';
            $hashPass = Hash::make($defaultPassword);
            DB::beginTransaction();

            /**
             * Fungsi untuk menambah user di SSO
             */if($badge_id)
                {
                    $name =  DB::table('tbl_karyawan')->select('fullname')->where('badge_id',$badge_id)->first();

                }

            DB::table('tbl_useradmin')->insert([
                'badge_id' => $badge_id,
                'password_msa' => $hashPass,
                'user_level' => $selectRoleAdd
            ]);


             DB::commit();


        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();

            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to update data.',
                ],
                400,
            );
        }
    }

    public function getVal(Request $request)
    {
        $badge_id = $request->UserId;


        try {
            /**
             * role input
             */
                $queryrole = "SELECT user_level as rolemeeting FROM tbl_useradmin WHERE badge_id = '$badge_id'";
                $valRole = DB::select($queryrole);
                $valRole = $valRole ? $valRole[0] : 1;
            return response()->json([
                'roleInput' => $valRole ? $valRole : null,
            ]);

        } catch (\Throwable $th) {
            // DB::rollBack();
            dd($th);

            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to update data.',
                ],
                400,
            );
        }

    }

    public function update(Request $request)
    {
        // dd($request->all());
        $sessionLogin = session('loggedInUser');
        $sessionBadge = $sessionLogin['session_badge'];


        // dd($request->all());
        try {
            $badge_id = $request->selectEmployeeEdit;
            $isactive = $request->isactive == 'on' ? 0 : 1 ;
            $selectRoleEdit = intval($request->selectRoleEdit);

            DB::beginTransaction();

            DB::table('tbl_useradmin')->where('badge_id', $badge_id)->update([
                'user_level' => $selectRoleEdit,
                'is_active'  => $isactive
            ]);

             DB::commit();


        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);

            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to update data.',
                ],
                400,
            );
        }
    }

}
