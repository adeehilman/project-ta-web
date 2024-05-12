<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function index()
    {
        // $password = Hash::make(1);

        // $data = [
        //     'data' => $password
        // ];

        // $badge = 111111;
        // $dataUser = DB::table('tbl_user')->where('badge', $badge)->first();

        // dd($dataUser);

        return view('auth/index');
    }

    public function login(Request $request)
    {
        // $badge = $request->post('badge');
        // $dataUser = DB::table('tbl_user')->where('badge', $badge)->first();

        // return response()->json([
        //     'status' => 200,
        //     'data' => $dataUser
        // ]);

        $validator = Validator::make(
            $request->all(),
            [
                'employee_no' => 'required|min:6',
                'password' => 'required',
            ],
            [
                'employee_no.required' => 'Badges cannot be empty',
                'employee_no.min' => 'No Badge minimum 6 numbers',
                'password' => 'The password cannot be empty',
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag(),
            ]);
        } else {
            $employeeNo = $request->post('employee_no');

            $password = $request->password;
            $dataUser = DB::table('tbl_useradmin')
                ->where('badge_id', $employeeNo)
                ->first();

            // dd($dataUser);
            if ($dataUser) {
                $userPassword = $dataUser->password_msa;
                $validPassword = Hash::check($password, $userPassword);
                if ($validPassword) {
                    $request->session()->put('loggedInUser', ['session_badge' => $dataUser->badge_id, 'session_roles' => $dataUser->user_level]);
                    return response()->json([
                        'status' => 200,
                        'messages' => 'Login successful',
                        'role' => $dataUser->user_level,
                    ]);
                } else {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'Wrong Password',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Badge number not found',
                ]);
            }
        }
    }

    // change password
    public function indexChangePass()
    {
        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_rolemeeting')
                ->select('name')
                ->where('id', session()->get('loggedInUser')['session_roles'])
                ->first(),
        ];

        return view('auth.change-password', $data);
    }

    // proses change password
    public function prosesChangePass(Request $request)
    {
        $oldPassword = $request->post('old_password');
        $newPassword = $request->post('new_password');
        $confirmPassword = $request->post('new_password_confirmation');

        // ambil data user
        $dataUser = DB::table('tbl_useradmin')
            ->where('badge_id', session('loggedInUser')['session_badge'])
            ->first();

        if ($dataUser) {
            $userPass = $dataUser->password_msa;
            $validPassword = Hash::check($oldPassword, $userPass);

            if (!$validPassword) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Password lama anda tidak sesuai',
                ]);
            } else {
                $hashingPass = Hash::make($newPassword);

                $data = [
                    'password_msa' => $hashingPass,
                ];

                $result = DB::table('tbl_useradmin')
                    ->where('badge_id', session('loggedInUser')['session_badge'])
                    ->update($data);

                return response()->json([
                    'status' => 200,
                    'message' => 'Password berhasil diubah',
                ]);
            }
        }
    }

    public function logout()
    {
        if (session()->has('loggedInUser')) {
            session()->pull('loggedInUser');
            return redirect('/');
        }
    }
}
