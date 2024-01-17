@php
    $count = 1;
@endphp
<table>
    <thead>
        <tr>
            <td style="text-align:center;font-size:20px; font-weight: bold; padding: 16px" colspan="8">PT. Sat Nusapersada, Tbk</td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:20px; font-weight: bold; padding: 16px" colspan="8">Pengkinian Data Report</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">No</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">No Badge</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Nama karyawan</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Dept Code</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Departemen</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Line Code</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Kategori</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Waktu Pengajuan</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Waktu Pembaruan</th>
            <th style="text-align:center;font-size:14px;border:1px solid black; font-weight: bold; padding: 16px" bgcolor="yellow">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listdatareport as $r)
        <tr>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $count }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->badgeid }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->namakaryawan }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->deptcode }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->deptname }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->linecode }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->kategori }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->createdate }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->updatedate }}</td>
            <td style="text-align:left;font-size:14px;border:1px solid black; padding: 16px">{{ $r->status }}</td>
        </tr>
        @php
            $count++;
        @endphp
        @endforeach
    </tbody>
</table>
