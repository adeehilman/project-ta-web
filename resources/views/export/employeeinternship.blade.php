<tr>
    <td></td>
    <td style="text-align: center">

        PT. SAT NUSAPERSADA Tbk

    </td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td style="text-align: left; font-weight: bold; vertical-align: middle;">BADGE ID :  {{$badgeId}}</td>
    <td style=""></td>
    <td style="text-align: left; font-weight: bold; vertical-align: middle;">Total Attended :  {{$Total_attend}}</td>
    <td></td>
</tr>



<tr>
    <td style="text-align: left; font-weight: bold; vertical-align: middle; ">NAME:  {{$Fullname}}</td>
    <td></td>
    <td style="text-align: left; font-weight: bold; vertical-align: middle;">Total Not Attended:  {{$Total_not_attend}}</td>
    <td></td>
</tr>

<tr>
    <td style="text-align: left; font-weight: bold; vertical-align: middle;">DEPARTMENT : {{$Department}}</td>
    <td></td>
    <td style="text-align: left; font-weight: bold; font-weight: bold;">Total Absent : {{$Absent}}</td>
    <td></td>
</tr>

<tr>
    <td></td>
    <td></td>
</tr>
<table style="border-collapse: collapse;">
    <thead>
        <tr>
            <td style="border: 1px solid black; width: 100px;"><b>Date</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Time In</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Time Out</b></td>
            <td style="border: 1px solid black; width: 100px;"><b>Status</b></td>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $item)
            <tr>
                <td style="border: 1px solid black; width: 170px;">{{ $item->submit_date }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->scanin }}</td>
                <td style="border: 1px solid black; width: 100px;">{{ $item->scanout }}</td>
                <td style="border: 1px solid black; width: 200px;">{{ $item->status }}</td>


            </tr>
        @endforeach
    </tbody>
</table>
