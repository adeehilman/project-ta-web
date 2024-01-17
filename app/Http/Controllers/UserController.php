<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $query_list_employee = 'SELECT fullname, badge_id FROM tbl_karyawan';
        $list_employee = DB::select($query_list_employee);

        $query_position_list = "SELECT * FROM tbl_vlookup WHERE category = 'USL'";
        $list_position = DB::select($query_position_list);

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,

            'list_position' => $list_position,
            'list_employee' => $list_employee,
        ];

        return view('user.index', $data);
    }

    // untuk menampilkan datatable
    public function getListUser(Request $request)
    {
        // $sessionLogin = session('loggedInUser');
        // $divisiId     = $sessionLogin['session_div_id'];

        $positionId = $request->idPosition;
        $txSearch = '%' . trim($request->txSearch) . '%';
        $filterTx = '';
        // dd($sectionId);

        if ($positionId != '') {
            $filterTx = "AND tu.user_level  = '$positionId'";
        }
        $q = "SELECT
            tu.id,
            tu.badge_id,
            tu.user_level,
            tu.is_active,
            k.fullname,
            v.name_vlookup
        FROM tbl_useradmin tu
        INNER JOIN
        tbl_karyawan k ON k.badge_id = tu.badge_id
        INNER JOIN
        tbl_vlookup v ON v.id_vlookup = tu.user_level
        WHERE
            (UPPER(tu.badge_id) LIKE UPPER('$txSearch') OR UPPER (k.fullname) LIKE UPPER('$txSearch') OR UPPER (v.name_vlookup)  LIKE UPPER ('$txSearch')) $filterTx
        ORDER BY tu.id DESC";

        $data = DB::select($q);
        // dd($data);

        $output = '';
        $output .= '
            <table id="tableUser" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                        <th class="p-3" scope="col">No</th>
                        <th class="p-3" scope="col">Employee No</th>
                        <th class="p-3" scope="col">Name</th>
                        <th class="p-3" scope="col">Role</th>
                        <th class="p-3" scope="col">Status</th>
                        <th class="p-3" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
        ';
        $no = 1;
        foreach ($data as $key => $item) {
            $status = $item->is_active == 1 ? '<span class="text-success fw-bold">ACTIVE</span>' : '<span class="text-danger fw-bold">NON-ACTIVE</span>';
            $statusClass = $item->is_active == 1 ? 'text-active' : 'text-non-active';

            $output .=
                '
                <tr>
                    <td class="p-3">' .
                $no++ .
                '</td>
                    <td class="p-3">' .
                $item->badge_id .
                '</td>
                    <td class="p-3">' .
                $item->fullname .
                '</td>
                    <td class="p-3">' .
                $item->name_vlookup .
                '</td>
                    <td class="p-3">' .
                $status .
                '</td>
                    <td>
                        <a id="btnEdit" class="btn btnEdit" data-id=' .
                $item->id .
                '><img src="' .
                asset('icons/edit.svg') .
                '"></a>
                    </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    // function menampilkan list position ketika filter

    public function getFilterUser(Request $request)
    {
        // $sessionLogin = session('loggedInUser');
        // $divisiId     = $sessionLogin['session_div_id'];

        $txSearch = '%' . trim($request->txSearch) . '%';
        $positionId = $request->idPosition;

        $filterTx = '';
        // dd($sectionId);

        if ($positionId != '') {
            $filterTx = "AND tu.user_level  = '$positionId'";
        }
        // dd($filterTx);

        $q = "SELECT
            tu.id,
            tu.badge_id,
            tu.user_level,
            tu.is_active,
            k.fullname,
            v.name_vlookup
        FROM tbl_useradmin tu
        INNER JOIN
        tbl_karyawan k ON k.badge_id = tu.badge_id
        INNER JOIN
        tbl_vlookup v ON v.id_vlookup = tu.user_level
        WHERE
            (UPPER(tu.badge_id) LIKE UPPER('$txSearch') OR UPPER (k.fullname) LIKE UPPER('$txSearch') OR UPPER (v.name_vlookup)  LIKE UPPER ('$txSearch'))
            $filterTx
        ORDER BY tu.id DESC";

        // dd($q);

        $data = DB::select($q);

        $output = '';
        $output .= '
            <table id="tableUser" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                        <th class="p-3" scope="col">No</th>
                        <th class="p-3" scope="col">Employee No</th>
                        <th class="p-3" scope="col">Name</th>
                        <th class="p-3" scope="col">Role</th>
                        <th class="p-3" scope="col">Status</th>
                        <th class="p-3" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
        ';
        $no = 1;
        foreach ($data as $key => $item) {
            $status = $item->is_active == 1 ? '<span class="text-success fw-bold">ACTIVE</span>' : '<span class="text-danger fw-bold">NON-ACTIVE</span>';
            $statusClass = $item->is_active == 1 ? 'text-active' : 'text-non-active';

            $output .=
                '
                <tr>
                    <td class="p-3">' .
                $no++ .
                '</td>
                    <td class="p-3">' .
                $item->badge_id .
                '</td>
                    <td class="p-3">' .
                $item->fullname .
                '</td>
                    <td class="p-3">' .
                $item->name_vlookup .
                '</td>
                    <td class="p-3">' .
                $status .
                '</td>
                    <td>
                        <a id="btnEdit" class="btn btnEdit" data-id=' .
                $item->id .
                '><img src="' .
                asset('icons/edit.svg') .
                '"></a>
                    </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    public function listEmployee(Request $request)
    {
        $txSearch = '%' . trim($request->input('q')) . '%';

        // dd($txSearch);
        $query = "SELECT fullname, badge_id, position_name FROM tbl_karyawan k INNER JOIN tbl_position p ON p.position_code = k.position_code WHERE (fullname LIKE '$txSearch' OR badge_id LIKE '$txSearch') LIMIT 100";
        $list_w_participant = DB::select($query);

        $listParticipantPosition = [];
        foreach ($list_w_participant as $key => $item) {
            array_push($listParticipantPosition, $item->position_name);
        }

        $listParticipantEd = [];
        foreach ($list_w_participant as $key => $item) {
            array_push($listParticipantEd, $item->badge_id);
        }

        $listFullname = [];
        foreach ($list_w_participant as $key => $item) {
            array_push($listFullname, $item->fullname);
        }

        // dd($list_w_participant);
        return response()->json([
            'list_participant_p' => $listParticipantPosition,
            'list_participant_w' => $listParticipantEd,
            'list_participant_f' => $listFullname,
        ]);
    }

    // untuk insert
    public function insert(Request $request)
    {
        try {
            // dd($request);

            DB::beginTransaction();

            $badge_id = strtoupper($request->input('badge_id'));
            $fullname = strtoupper($request->input('fullname'));
            $user_level = $request->input('user_level');
            $is_active = $request->input('is_active');

            // validasi employee_no
            $countBadge = DB::table('tbl_useradmin')
                ->where('badge_id', $badge_id)
                ->count();
            if ($countBadge > 0) {
                return response()->json([
                    'MSGTYPE' => 'E',
                    'MSG' => 'Employee Number already exists',
                ]);
            }

            DB::table('tbl_useradmin')->insert([
                'badge_id' => $badge_id,
                'password_msa' => Hash::make('Passw0rd'),
                'user_level' => $user_level,
            ]);

            DB::commit();

            return response()->json([
                'MSGTYPE' => 'S',
                'MSG' => 'OK.',
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return response()->json('FAILED.', 400);
        }
    }

    // untuk edit
    public function edit(Request $request)
    {
        // dd($request);

        $id = $request->input('UserId');

        $data = DB::table('tbl_useradmin')
            ->select('id', 'badge_id', 'user_level', 'is_active')
            ->where('id', $id)
            ->first();

        return response()->json([
            'dataUserId' => $data,
        ]);
    }

    // untuk update data
    public function update(Request $request)
    {
        $badge_id = $request->get('badge_id');
        // dd($request);

        DB::beginTransaction();
        try {
            $badge_id = strtoupper($request->post('badge_id'));
            $fullname = strtoupper($request->post('fullname'));
            $user_level = $request->post('user_level');
            $is_active = $request->post('status_account');

            // check validasi duplikat

            // validasi employee_no
            // $countBadge = DB::table('tbl_useradmin')
            //     ->where('badge_id', $badge_id)
            //     ->count();
            // if ($countBadge > 0) {
            // return response()->json([
            //     'MSGTYPE' => 'E',
            //     'MSG' => 'Employee Number already exists',
            //     ]);
            // }

            // validasi nama
            // $countNama = DB::table('tbl_user')->where('name', $name)->count();
            // if($countNama > 0){
            //     return response()->json([
            //         "MSGTYPE" => "E",
            //         "MSG"     => "Employee Name employee already exists"
            //     ]);
            // }

            //    dd($is_active);

            DB::table('tbl_useradmin')
                ->where('badge_id', $badge_id)
                ->update([
                    // 'badge_id' => $badge_id,
                    // 'password_msa' => Hash::make('Passw0rd'),
                    'user_level' => $user_level,
                    'is_active' => $is_active,
                ]);

            DB::commit();

            return response()->json([
                'MSGTYPE' => 'S',
                'MSG' => 'OK.',
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return response()->json('FAILED.', 400);
        }
    }
}
