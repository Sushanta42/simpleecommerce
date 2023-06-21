<x-admin-layout>
    <div class="container">
        <section class="section">
            <div class="section-body">
                <div class="invoice" id="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h2>Invoice</h2>
                                    <div class="invoice-number">Order #{{ $order->id }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Billed To:</strong><br>
                                            {{ $order->user->name }}<br>
                                            {{ $order->user->phone }}<br>
                                            {{ $order->user->common_address->name }}<br>
                                            NC, 27591, USA
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right ship-address">
                                        <address>
                                            <strong>Shipped To:</strong><br>
                                            {{ $order->user->name }}<br>
                                            {{ $order->user->phone }}<br>
                                            {{ $order->user->common_address->name }}<br>
                                            Springfield Center, USA
                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Payment Method:</strong><br>
                                            Visa ending **** 5687<br>
                                            test@example.com
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right order-date">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            {{ $order->created_at }}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Order Summary</div>
                                <p class="section-lead">All items here cannot be deleted.</p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                        <thead>
                                            <tr>
                                                <th data-width="40" style="width: 40px;">#</th>
                                                <th>Item</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-right">Totals</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->order_items as $index => $item)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td class="text-center invoice-detail-value-rs">Rs.
                                                        {{ $item->product->sale_price }}</td>
                                                    <td class="text-center invoice-detail-value-rs">
                                                        {{ $item->quantity }}</td>
                                                    <td class="text-right invoice-detail-value-rs">Rs.
                                                        {{ $item->amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-8">
                                        <div class="section-title">Payment Method</div>
                                        <p class="section-lead">The payment method that we provide is to make it easier
                                            for you to pay
                                            invoices.</p>
                                        <div class="images">
                                            <img src="/assets/img/cards/visa.png" alt="visa">
                                            <img src="/assets/img/cards/jcb.png" alt="jcb">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Subtotal</div>
                                            <div class="invoice-detail-value invoice-detail-value-st">Rs.
                                                {{ $order->total }}</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Shipping</div>
                                            <div class="invoice-detail-value">Free</div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">Rs.
                                                {{ $order->total }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-right">
                        {{-- <div class="float-lg-left mb-lg-0 mb-3">
                            <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i>
                                Process
                                Payment</button>
                            <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>
                                Cancel</button>
                        </div> --}}
                        <button class="btn btn-warning btn-icon icon-left no-print" onclick="printInvoice()"><i
                                class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-admin-layout>

<script>
    function printInvoice() {
        var invoiceDiv = document.getElementById('invoice');
        var printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Invoice</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('.ship-address { position: absolute; top: 90px; right: 20px; }');
        printWindow.document.write('.order-date { position: absolute; top: 190px; right: 40px; }');
        printWindow.document.write('.invoice-detail-value-lg { font-size: 25px; }'); // Set font size
        printWindow.document.write('.invoice-detail-value-st { font-size: 20px; }'); // Set font size
        printWindow.document.write(
        '@media print { .no-print { display: none; } }'); // Add media query to hide print elements
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<div class="ship-address">'); // Add ship-address div
        printWindow.document.write(document.querySelector('.col-md-6.text-md-right')
            .innerHTML); // Copy ship address content
        printWindow.document.write('</div>');
        printWindow.document.write(invoiceDiv.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
