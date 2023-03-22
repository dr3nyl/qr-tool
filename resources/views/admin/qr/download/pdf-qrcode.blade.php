<table style="width:100%">

    @foreach($data as $key => $value)

        @if ($key % 3 == 0)
            <tr>
        @endif

        <td>
            <img src="data:image/png;base64, {!! $value['qrcode'] !!}">
            <p>{{ $value['name'] }}</p>
        </td>

        @if (($key + 1) % 3 == 0)
            </tr>
        @endif

    @endforeach

    @if (($key + 1) % 3 != 0)
        </tr>
    @endif

</table>