@if(isset($Visitorsdata))

@foreach($Visitorsdata as $dt)

<tr>
    <td><a href="javascript:void(0);">{{$dt->Location}}</a></td>
    <td>{{$dt->Visitors}}</td>
    <td class="text-align-center">
        <div class="sparkline txt-color-blue text-align-center" data-sparkline-height="22px" data-sparkline-width="90px" data-sparkline-barwidth="2">
            {{$dt->UserActivity}}
        </div>
    </td>
    <!-- <td class="text-align-center">
        <div class="sparkline display-inline" data-sparkline-type='pie' data-sparkline-piecolor='["#E979BB", "#57889C"]' data-sparkline-offset="90" data-sparkline-piesize="23px">
            17,83
        </div>
    </td> -->

</tr>
@endforeach @endif