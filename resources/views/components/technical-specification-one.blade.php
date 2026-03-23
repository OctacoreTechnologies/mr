@php
    $text = $headingText ?? 'TECHNICAL SPECIFICATION OF MIXER';
    $words = explode(' ', $text);

    // Last 3 words ko alag karo (adjust kar sakte ho 2 ya 3)
    $lastWords = implode(' ', array_slice($words, -1));
    $firstPart = implode(' ', array_slice($words, 0, -1));
@endphp

<div class="page-break" style="padding: 27px 0px 15px 8px; font-size: 14px; box-sizing: border-box;">
    <div class="specification">
        <h3 style="margin-bottom:10px;
    text-decoration: underline;
    font-weight:bolder;
    font-size:22px;
    text-align:left; text-transform: uppercase; width: 102%;">

            {{ $headingNumber ?? '2.' }}
            {{ $firstPart }} 
            <span style="white-space: nowrap; text-transform: uppercase;">{{ $lastWords }}</span>

        </h3>

        <table class="parameter-table"
            style="border-collapse: collapse; line-height: 1; font-size: 14px; position: relative; width: 98%; top: 10px; padding-top:50px;margin-left:20px;">
            @foreach ($items as $item)
                <tr style="margin-top:0; ">
                    <td style="vertical-align: top; width: 40%; padding-bottom: 4px;word-break: break-word;">
                        <span>&#8226;&nbsp; {{ $item['title'] }}</span>
                    </td>
                    <td style="vertical-align: top; text-align: justify;">
                        :<span style="position: relative;left:6px;">{!! $item['description'] !!}</span>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>