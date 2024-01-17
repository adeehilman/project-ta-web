<tr>
    <td></td>
    <td style="text-align: center">

        PT. SAT NUSAPERSADA Tbk

    </td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td style="text-align: center">MEETING REPORT SUMMARY</td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td></td>
    <td></td>
</tr>

<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td style="border: 1px solid black; width: 100px;"><b>Name</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Employee No</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Department</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Total Meetings</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Total Attendance</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Total Absent</b></td>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)
            <tr>
                <td style="border: 1px solid black; width: 100px;">{{ $item->fullname }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->participant }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->dept_name }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->tot_meeting }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->kehadiran }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->absent }}</td>


            </tr>
        @endforeach
    </tbody>
</table>
