   
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select an option",
                allowClear: true
            });
        });

        // Reminder toggle
        function toggleReminderField() {
            var selectedValue = $('#status').val();

            if (selectedValue === 'Draft') {
                $('#reminder').show();
            } else {
                $('#reminder').hide();
            }
        }

        toggleReminderField();

        $('#status').change(function() {
            toggleReminderField();
        });


        // GLOBAL COUNTS
        // let remarkCount = $('.remark-item').length;
        // let itemCount = {{ $quotation->items->count() ?? 0 }};
        // let itemCount =0;
        let itemCount = $('.item-row').length;

        function updateTotal() {

            var price = parseFloat($('#total_price').val().replace(/,/g, '')) || 0;
            var quantity = parseFloat($('#quantity').val().replace(/,/g, '')) || 1;
            var discountType = $('#discountType').val();
            var discountPercentage = parseFloat($('#discount_percentage').val().replace(/,/g, '')) || 0;
            var discountAmount = parseFloat($('#discount_amount').val().replace(/,/g, '')) || 0;

            var total = price * quantity;

            if (discountType === 'percentage') {
                total = total - (total * discountPercentage / 100);
                $('#discount_amount').val(0);
            } else if (discountType === 'amount') {
                total = total - discountAmount;
                $('#discount_percentage').val(0);
            }

            // Items total
            var itemsTotal = 0;

            $('.item-row').each(function() {

                let price = parseFloat($(this).find('.item-price').val().replace(/,/g, '')) || 0;
                let qty = parseFloat($(this).find('.item-qty').val()) || 0;

                itemsTotal += price * qty;

            });

            total = total + itemsTotal;

            $('#total_amount').val(total.toFixed(2));
        }
        $(document).ready(function() {

            // Hide discount fields initially
            $('#discountPercentage').hide();
            $('#discountAmount').hide();

            // ==============================
            // TOTAL CALCULATION
            // ==============================

            // Discount type change
            $('#discountType').on('change', function() {

                var discountType = $(this).val();

                if (discountType === 'percentage') {
                    $('#discountPercentage').show();
                    $('#discountAmount').hide();
                } else if (discountType === 'amount') {
                    $('#discountAmount').show();
                    $('#discountPercentage').hide();
                } else {
                    $('#discountPercentage').hide();
                    $('#discountAmount').hide();
                }

                updateTotal();
            });

            // Input change
            $(document).on(
                'input',
                '#total_price, #quantity, #discount_percentage, #discount_amount',
                function() {
                    updateTotal();
                }
            );

            // Initial load
            (function() {

                var initialDiscountType = $('#discountType').val();

                if (initialDiscountType === 'percentage') {
                    $('#discountPercentage').show();
                    $('#discountAmount').hide();
                } else if (initialDiscountType === 'amount') {
                    $('#discountAmount').show();
                    $('#discountPercentage').hide();
                } else {
                    $('#discountPercentage').hide();
                    $('#discountAmount').hide();
                }

                updateTotal();
            })();


            // ==============================
            // ADD REMARK
            // ==============================
            $(document).on('click', '#addRemarkBtn', function() {

                let html = `
            <div class="form-group col-md-6 remark-item">
                <input type="hidden" name="remarks[${remarkCount}][id]" value="">

                <label>Remark ${remarkCount + 1}</label>
                <textarea name="remarks[${remarkCount}][remark]" rows="4" class="form-control"></textarea>

                <button type="button" class="btn btn-danger btn-xs mt-1 removeRemark">
                    Remove
                </button>
            </div>
            `;

                $(this).closest('.form-group').before(html);

                remarkCount++;
            });


            // ==============================
            // ADD ITEM
            // ==============================
            $(document).on('click', '#addItemBtn', function() {

                let html = `
            <div class="form-group col-md-6 item-row">
                <input type="hidden" name="items[${itemCount}][id]" value="">

                <label>Item ${itemCount + 1}</label>

                <input type="text"
                       name="items[${itemCount}][name]"
                       placeholder="Item Name"
                       class="form-control mb-1">

                <input type="text"
                       name="items[${itemCount}][price]"
                       placeholder="Item Price"
                       class="form-control mb-1 format-number item-price">

                <input type="number"
                       name="items[${itemCount}][qty]"
                       placeholder="Qty"
                       value="1"
                       class="form-control mb-1 item-qty">
                       
                <select name='items[${itemCount}][qty_unit]'  class="form-control mb-1 p-2">
                    <option value='Nos'>Nos</option>
                    <option value='Meter'>Meter</option>
                    <option value='Kg'>Kg</option>
                    <option value='Shed'>Shed</option>
                </select>

                <input type="text"
                       name='item_total_amount'
                       placeholder="Item Total"
                       class="form-control mb-1 item-total format-number"
                       readonly>

                <button type="button" class="btn btn-danger btn-xs mt-1 removeItem">
                    Remove
                </button>
            </div>
            `;

                let newItem = $(html);

                $('#total').before(newItem);

                // Apply number format
                newItem.find('.format-number').each(function() {
                    initFormatNumber(this);
                });

                itemCount++;
            });

        });


        // ==============================
        // REMOVE REMARK
        // ==============================
        $(document).on('click', '.removeRemark', function() {
            $(this).closest('.remark-item').remove();
            updateRemarkNumbers();
        });

        function updateRemarkNumbers() {
            remarkCount = 0;

            $('.remark-item').each(function() {
                remarkCount++;
                $(this).find('label').text('Remark ' + remarkCount);
            });
        }


        // ==============================
        // REMOVE ITEM
        // ==============================
        $(document).on('click', '.removeItem', function() {
            $(this).closest('.item-row').remove();
            updateItemNumbers();
        });

        function updateItemNumbers() {
            let count = 1;

            $('.item-row').each(function() {
                $(this).find('label').text('Item ' + count);
                count++;
            });
        }


        // ==============================
        // ITEM TOTAL CALCULATION
        // ==============================
        function calculateItemTotal(row) {

            let price = parseFloat(row.find('.item-price').val().replace(/,/g, '')) || 0;
            let qty = parseFloat(row.find('.item-qty').val()) || 0;

            let total = price * qty;

            row.find('.item-total').val(total.toFixed(2));

            updateTotal();
        }

        $(document).on('input', '.item-price, .item-qty', function() {

            let row = $(this).closest('.item-row');
            calculateItemTotal(row);

        });
