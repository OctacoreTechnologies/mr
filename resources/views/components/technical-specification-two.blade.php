
<div class="page-break" style="padding: 100px 0px 15px 5px; font-size: 14px; box-sizing: border-box;">
  <div class="technical-datayrt">
    <table class="parameter-table"
      style="border-collapse: collapse; line-height: 1; font-size: 14px; position: relative;  width: 98%; top: 110px;">
      @foreach ($items as $item)
        <tr>
          <td style="vertical-align: top; width: 40%; padding-bottom: 4px; overflow-wrap: break-word;">
            <span>&#8226;&nbsp; {{ $item['title'] }}</span>
          </td>
          <td style="vertical-align: top; padding-bottom: 4px; text-align: justify;">
            :<span style="position: relative;left:6px;">{{ $item['description'] }}</span>
          </td>
        </tr>
      @endforeach
    </table>
  </div>
</div>