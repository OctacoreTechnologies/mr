<div class="page-break" style="padding: 115px 0 5px 5px; font-size: 14px; box-sizing: border-box;">
  <div class="technical-datayrt">
    <h2 style="margin-bottom: 10px; text-decoration: underline; font-weight: bolder;">
      {{ $headingNumber ?? '2.' }}&nbsp; {{ $headingText ?? 'TECHNICAL SPECIFICATION OF MIXER' }}
    </h2>

    <table class="parameter-table"
      style="border-collapse: collapse; line-height: 1.1; font-size: 14px; position: relative; left: -5px; width: 90%; top: 10px;">
      @foreach ($items as $item)
        <tr>
          <td style="vertical-align: top; width: 30%; padding-bottom: 4px; white-space: nowrap;">
            <span>&#8226;&nbsp; {{ $item['title'] }}</span>
          </td>
          <td style="vertical-align: top; padding-bottom: 4px; text-align: justify;">
            :&nbsp;{!! $item['description'] !!}
          </td>
        </tr>
      @endforeach
    </table>
  </div>
</div>