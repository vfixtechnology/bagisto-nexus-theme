<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>
        @lang('shop::app.checkout.success.thanks')
    </x-slot>

    @php
        $order = null;

        if (isset($order) && $order) {
        } elseif (session()->has('order_id')) {
            $order = app('Webkul\Sales\Repositories\OrderRepository')->find(session('order_id'));
        } elseif (request()->has('order_id')) {
            $order = app('Webkul\Sales\Repositories\OrderRepository')->find(request('order_id'));
        } elseif (request()->route('id')) {
            $order = app('Webkul\Sales\Repositories\OrderRepository')->find(request()->route('id'));
        }
    @endphp

    <div class="py-2">
        <div class="container mx-auto px-3 pt-5 max-w-3xl">
            @if($order)
                <div class="bg-white border border-gray-200 rounded shadow-sm text-sm">

                    <!-- Header -->
                    <div class="bg-green-600 px-4 py-4 text-center border-b border-gray-200">
                        <p class="text-white">Your order ID</p>
                        <p class="text-xl font-semibold text-white">
                            @if (auth()->guard('customer')->user())
                                <a class="text-white hover:underline" href="{{ route('shop.customers.account.orders.view', $order->id) }}">
                                    #{{ $order->increment_id }}
                                </a>
                            @else
                                #{{ $order->increment_id }}
                            @endif
                        </p>

                        <h1 class="text-2xl font-bold text-white mt-1 mb-1">Thank you for your order!</h1>

                        <p class="text-white text-sm">
                            {!! $order->checkout_message ? nl2br($order->checkout_message) : 'We will email your order details and tracking info.' !!}
                        </p>
                    </div>

                    <!-- Details -->
                    <div class="px-4 py-4">
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <h3 class="font-semibold border-b mb-2 pb-1 text-gray-800">Customer Info</h3>
                                <div class="space-y-1">
                                    <div class="flex ">
                                        <span class="font-medium">Name:</span>
                                        <span class="ms-2"> {{ $order->customer_first_name }} {{ $order->customer_last_name }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium">Email:</span>
                                        <span class="ms-2"> {{ $order->customer_email }}</span>
                                    </div>
                                       <div class="flex">
                                        <span class="font-medium">Phone:</span>
                                        <span class="ms-2"> {{ $order->billing_address->phone }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium">Date:</span>
                                        <span class="ms-2"> {{ $order->created_at->format('M d, Y g:i A') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-semibold border-b mb-2 pb-1 text-gray-800">Payment Info</h3>
                                <div class="space-y-1">
                                    <div class="flex">
                                        <span class="font-medium">Method:</span>
                                        <span class="ps-1"> {{ $order->payment->method_title ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium">Paid:</span>
                                        <span class="ms-2 text-green-600"> {{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium">Status:</span>
                                        <span class="ms-2 text-blue-600 capitalize">{{ $order->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items -->
                        @if($order->items && count($order->items) > 0)
                            <div class="mb-4">
                                <h3 class="font-semibold border-b mb-2 pb-1 text-gray-800">Order Items</h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="bg-gray-50 border-b">
                                                <th class="text-left py-2 px-3">Product</th>
                                                <th class="text-center py-2 px-3">Qty</th>
                                                <th class="text-right py-2 px-3">Price</th>
                                                <th class="text-right py-2 px-3">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr class="border-b">
                                                    <td class="px-3 py-2">
                                                        <div class="font-medium">{{ $item->name }}</div>
                                                        @if ($item->type == 'configurable')
                                                            @if (isset($item->additional['attributes']))
                                                                <div class="text-xs text-gray-500">
                                                                    @foreach ($item->additional['attributes'] as $attribute)
                                                                        {{ $attribute['attribute_name'] }}: {{ $attribute['option_label'] }}<br>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (!empty($item->additional['product_sku']))
                                                            <div class="text-xs text-gray-500">SKU: {{ $item->additional['product_sku'] }}</div>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 py-2 text-center">{{ (int) $item->qty_ordered }}</td>
                                                    <td class="px-3 py-2 text-right">{{ core()->formatPrice($item->price, $order->order_currency_code) }}</td>
                                                    <td class="px-3 py-2 text-right font-medium">{{ core()->formatPrice($item->total, $order->order_currency_code) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Totals -->
                        <div class="border-t pt-3">
                            <div class="space-y-1 max-w-xs ml-auto text-sm">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span>{{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}</span>
                                </div>
                                @if ($order->shipping_amount > 0)
                                    <div class="flex justify-between">
                                        <span>Shipping:</span>
                                        <span>{{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}</span>
                                    </div>
                                @endif
                                @if ($order->tax_amount > 0)
                                    <div class="flex justify-between">
                                        <span>Tax:</span>
                                        <span>{{ core()->formatPrice($order->tax_amount, $order->order_currency_code) }}</span>
                                    </div>
                                @endif
                                @if ($order->discount_amount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>Discount:</span>
                                        <span>-{{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between font-bold text-gray-900 border-t pt-2">
                                    <span>Grand Total:</span>
                                    <span>{{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-6 justify-center">

                            <!-- Continue Shopping -->
                            <a
                                href="{{ route('shop.home.index') }}"
                                class="w-max cursor-pointer rounded bg-blue-900 hover:bg-blue-800 px-8 py-3 text-center text-base font-medium text-white"
                            >
                                Continue Shopping
                            </a>

                        <!-- WhatsApp Button -->
                            <button
                                onclick="shareOnWhatsApp()"
                                class="w-max cursor-pointer rounded bg-green-500 px-5 py-3 text-center text-base font-medium text-white flex items-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="white" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 0.438c-8.625 0-15.563 6.938-15.563 15.563 0 2.75 0.719 5.438 2.125 7.813l-2.25 8.188 8.438-2.219c2.25 1.219 4.813 1.813 7.25 1.813h0.063c8.625 0 15.563-6.938 15.563-15.563s-6.938-15.563-15.563-15.563zM16 28.625h-0.063c-2.125 0-4.375-0.625-6.188-1.75l-0.438-0.25-5.938 1.531 1.594-5.813-0.281-0.438c-1.313-2-1.938-4.313-1.938-6.688 0-7.063 5.75-12.813 12.813-12.813 3.438 0 6.625 1.344 9.031 3.75s3.75 5.594 3.75 9.031c0 7.063-5.75 12.813-12.813 12.813zM23.375 20.188c-0.313-0.188-1.875-0.938-2.188-1.063s-0.5-0.188-0.688 0.188c-0.188 0.375-0.813 1.063-1 1.25-0.188 0.188-0.375 0.219-0.688 0.063-0.313-0.156-1.313-0.5-2.5-1.563-0.938-0.813-1.563-1.813-1.75-2.125s-0.031-0.531 0.125-0.688c0.125-0.125 0.281-0.313 0.438-0.5s0.219-0.375 0.313-0.625c0.094-0.25 0.031-0.469-0.031-0.625-0.063-0.156-0.875-2.156-1.188-2.938-0.281-0.688-0.563-0.594-0.781-0.594s-0.438-0.031-0.688-0.031c-0.25 0-0.656 0.094-0.969 0.438-0.313 0.344-1.25 1.219-1.25 2.969s1.281 3.438 1.469 3.688c0.188 0.25 2.563 3.938 6.188 5.5 0.875 0.375 1.563 0.625 2.125 0.781 0.875 0.25 1.625 0.219 2.25 0.125 0.688-0.094 2.125-0.875 2.438-1.688s0.313-1.563 0.219-1.688c-0.094-0.125-0.313-0.219-0.625-0.375z"/>
                                </svg>
                                Send order details on WhatsApp
                            </button>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
    function shareOnWhatsApp() {
        try {
            // Function to decode HTML entities
            function decodeHtmlEntities(str) {
                const textArea = document.createElement('textarea');
                textArea.innerHTML = str;
                return textArea.value;
            }

            const orderId = "{{ $order->increment_id ?? 'N/A' }}";
            const customerName = decodeHtmlEntities("{{ $order->customer_first_name }} {{ $order->customer_last_name }}");
            const customerEmail = "{{ $order->customer_email ?? 'N/A' }}";
            const customerPhone = "{{ $order->billing_address->phone ?? 'N/A' }}";
            const orderStatus = "{{ $order->status_label ?? $order->status ?? 'N/A' }}";
            const paymentMethod = "{{ $order->payment->method_title ?? 'N/A' }}";
            const orderTotal = "{{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}";

            let productsList = "";
            @foreach($order->items as $item)
                {
                    let productName = decodeHtmlEntities("{{ $item->name }}");
                    productsList += `• ${productName}`;

                    @if ($item->type == 'configurable' && isset($item->additional['attributes']))
                        productsList += ` (`;
                        @foreach ($item->additional['attributes'] as $attribute)
                            {
                                const attrName = decodeHtmlEntities("{{ $attribute['attribute_name'] }}");
                                const optionLabel = decodeHtmlEntities("{{ $attribute['option_label'] }}");
                                productsList += `${attrName}: ${optionLabel}`;
                                @if (!$loop->last)
                                    productsList += `, `;
                                @endif
                            }
                        @endforeach
                        productsList += `)`;
                    @endif
                    productsList += ` (Qty: {{ $item->qty_ordered }})\n`;
                }
            @endforeach

            let shippingAddress = "";
            @if($order->shipping_address)
                shippingAddress = `{{ $order->shipping_address->address ?? '' }} {{ $order->shipping_address->address2 ?? '' }},
{{ $order->shipping_address->city ?? '' }}, {{ $order->shipping_address->state ?? '' }},
{{ $order->shipping_address->postcode ?? '' }}, {{ $order->shipping_address->country ?? '' }}`.trim();
            @else
                shippingAddress = "N/A";
            @endif

            const message = `Hi,

I just placed an order:

*Order ID:* #${orderId}
*Name:* ${customerName}
*Email:* ${customerEmail}
*Phone:* ${customerPhone}

*Shipping Address:*
${shippingAddress}

*Products:*
${productsList}
*Amount:* ${orderTotal}
*Order Status:* ${orderStatus}
*Payment Mode:* ${paymentMethod}

Thanks!`;

            const encodedMessage = encodeURIComponent(message);
            window.open(`https://wa.me/919898989898?text=${encodedMessage}`, '_blank');
        } catch (error) {
            console.error('WhatsApp share failed:', error);
            alert('Unable to share order via WhatsApp. Please try manually.');
        }
    }
</script>
</x-shop::layouts>
