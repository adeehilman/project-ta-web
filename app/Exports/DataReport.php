<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DataReport implements FromView, ShouldAutoSize 

{
    public function __construct($search,$dept,$tahun,$bulan) {

        $this->search = $search;
        $this->dept = $dept;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
      

    }


    public function view(): View {
        $listdatareport = DB::select("
        SELECT
        a.badgeid,
        tk.fullname AS namakaryawan,
        tk.dept_code AS deptcode,
        td.dept_name AS deptname,
        tk.line_code AS linecode,
        a.kategori,
        a.createdate,
        a.updatedate,
        tsp.stat_title AS status
    FROM tbl_pengkiniandata a
    INNER JOIN tbl_karyawan tk ON a.badgeid = tk.badge_id
    INNER JOIN tbl_deptcode td ON tk.dept_code = td.dept_code
    INNER JOIN tbl_statuspengkinian tsp ON a.status = tsp.id
    WHERE YEAR(a.createdate) = '$this->tahun' AND MONTH(a.createdate) = '$this->bulan'
        AND UPPER(td.dept_name) LIKE UPPER('%$this->dept%')
        AND (
            UPPER(a.badgeid) LIKE UPPER('%$this->search%')
            OR UPPER(tk.fullname) LIKE UPPER('%$this->search%')
            OR UPPER(tk.dept_code) LIKE UPPER('%$this->search%')
            OR UPPER(tk.line_code) LIKE UPPER('%$this->search%')
            OR UPPER(a.kategori) LIKE UPPER('%$this->search%')
            OR UPPER(tsp.stat_title) LIKE UPPER('%$this->search%')
        )
    ORDER BY
        CASE
            WHEN tsp.stat_title = 'Data diperbarui' THEN 1
            WHEN tsp.stat_title = 'Ditolak' THEN 2
            WHEN tsp.stat_title = 'Selesai' THEN 3
            ELSE 4
        END          
");
    
        return view('export.exportDataReport', [
            'listdatareport' => $listdatareport,
        ]);
    }
    
}