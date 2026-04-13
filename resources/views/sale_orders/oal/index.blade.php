<x-sale-order-index :salesOrders="$salesOrders"  :title="'OAL(Order Acceptance Letter)'" :edit="'order-acceptance-letter'" :createBtn="false" :oalPdf="true"/>
@push('js')
  <script src="{{ asset('js/sale_order.js') }}"></script>
@endpush
