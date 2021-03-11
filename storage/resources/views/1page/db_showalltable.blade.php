ไม่พบ หน้าเพจ ที่ต้องการ

<table>
    <tr>
<td>
@php
    $jj = DB::select('show tables');
    $mos = json_decode(json_encode($jj));
    //dd($mos)
@endphp

</td>
<td valign="top">

    <table border="1">
        <td>ชื่อ Table</td>
        <td>สร้าง form</td>

    @foreach($mos as $m =>$ms)
        @foreach($ms as $e)
            <tr>
                
                <td>{{$e}}</td>
                <td width="100">
                    <a href="kljlj?table={{$e}}">
                    สร้าง form
                    </a>
                </td>

            </tr>
        @endforeach
    @endforeach
    </table>

</td>

</tr>
</table>
