<x-sale-order-index :salesOrders="$salesOrders"  :title="'OAL(Order Acceptance Letter)'" :edit="'oal'" :createBtn="false" :oalPdf="true"/>
@push('js')
  <script src="{{ asset('js/sale_order.js') }}"></script>
@endpush
