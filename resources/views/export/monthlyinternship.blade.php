<tr>
    <td colspan="12" style="text-align: center; font-weight: bold;">DAFTAR UANG MAGANG SISWA/WI PKL</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td colspan="12" style="text-align: center; font-weight: bold;">{{ $month}}</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td>Department : {{$dept}}</td>
    <td></td>
    <td></td>
</tr>
<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center;"><b>NO </b></td>
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center;"><b>NO BADGE</b></td>
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center;"><b>NAMA </b></td>
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center;"><b>PENDIDIKAN</b></td>
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center;"><b>DEPT</b></td>
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center;"><b>COST CENTRE</b></td>
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center; white-space: nowrap;"><b>INTERNSHIP END DATE</b></td>
            <td rowspan="2" colspan="3" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center; white-space: nowrap;"><b>JUMLAH UANG MAKAN</b></td>
            <td style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center; white-space: nowrap;"><b>TOTAL</b></td>
           
            <td rowspan="2" style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center; white-space: nowrap;"><b>TANDA TANGAN</b></td>
        </tr>
        <tr>
            <td style="height: 40px; border: 1px solid black;  vertical-align: middle; text-align: center; white-space: nowrap;"><b>UANG MAKAN</b></td>
        </tr>
    </thead>

    <tbody>
        <?php $i = 1; ?>
        @foreach ($data as $item)
   
            <tr>
                <td style="border: 1px solid black; width: 50px; vertical-align: middle; height: 50px;  text-align: center;">{{ $i++ }}</td>
                <td style="border: 1px solid black; width: 100px; vertical-align: middle;  text-align: center;">{{ $item->badge_id }}</td>
                <td style="border: 1px solid black; width: 250px; vertical-align: middle;  text-align: left;">{{ $item->fullname }}</td>
                <td style="border: 1px solid black; width: 100px; vertical-align: middle;  text-align: center;"></td>
                <td style="border: 1px solid black; width: 200px; vertical-align: middle;  text-align: center;">{{ $item->dept_name }}</td>
                <td style="border: 1px solid black; width: 250px; vertical-align: middle;  text-align: center;"></td>
                <td style="border: 1px solid black; width: 150px; vertical-align: middle;  text-align: center;">{{ $item->formatted_selesai_kontrak }}</td>
                <td style="border: 1px solid black; width: 130px; vertical-align: middle;  text-align: center;"></td>
                <td style="border: 1px solid black; width: 30px; vertical-align: middle;  text-align: center;">X</td>
                <td style="border: 1px solid black; width: 40px; vertical-align: middle;  text-align: center;">{{ $item->total_present }} </td>
                <td style="border: 1px solid black; width: 200px; vertical-align: middle;  text-align: center;"></td>
                <td style="border: 1px solid black; width: 150px; vertical-align: middle;  text-align: centerleft; white-space: normal;"></td>
                
            </tr>
        @endforeach
    </tbody>
</table>
