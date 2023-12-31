<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th
                style="font-size:14px; padding:12px; border-bottom: 1px solid #f0f0f0 ;text-align:left; font-weight:bold;">
                @lang('billable::product.table_heading')
            </th>
            <th
                style="font-size:14px; padding:12px; border-bottom: 1px solid #f0f0f0; text-align:right; font-weight:bold;">
                @lang('billable::product.qty')
            </th>
            <th
                style="font-size:14px; padding:12px; border-bottom: 1px solid #f0f0f0; text-align:right; font-weight:bold;">
                @lang('billable::product.unit_price')
            </th>
            @if ($billable->isTaxable())
                <th
                    style="font-size:14px; padding:12px; border-bottom: 1px solid #f0f0f0; text-align:right; font-weight:bold;">
                    @lang('billable::product.tax')
                </th>
            @endif

            @if ($billable->hasDiscount)
                <th
                    style="font-size:14px; padding:12px; border-bottom: 1px solid #f0f0f0; text-align:right; font-weight:bold;">
                    @lang('billable::product.discount')
                </th>
            @endif
            <th
                style="font-size:14px; padding:12px; border-bottom: 1px solid #f0f0f0; text-align:right; font-weight:bold;">
                @lang('billable::product.amount')
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($billable->products as $product)
            <tr>
                <td style="border-bottom: 1px solid #f0f0f0; text-align:left;">
                    {{ ($product->sku ? $product->sku . ': ' : '') . $product->name }}
                    @if ($product->description)
                        <div style="color:#64748b;">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    @endif
                </td>

                <td style="border-bottom: 1px solid #f0f0f0; text-align:right;">
                    {{ $product->qty }} {{ $product->unit ?: '' }}
                </td>

                <td style="border-bottom: 1px solid #f0f0f0; text-align:right;">
                    {{ to_money($product->unit_price)->format() }}
                </td>

                @if ($billable->isTaxable())
                    <td style="border-bottom: 1px solid #f0f0f0; text-align:right;">
                        {{ $product->tax_label }} ({{ $product->tax_rate }}%)
                    </td>
                @endif

                @if ($billable->hasDiscount)
                    <td style="border-bottom: 1px solid #f0f0f0; text-align:right;">
                        @if ($product->discount_type === 'fixed')
                            <span>
                                {{ to_money($product->discount_total)->format() }}
                            </span>
                        @endif
                        @if ($product->discount_type === 'percent')
                            <span>
                                {{ $product->discount_total }}%
                            </span>
                        @endif
                    </td>
                @endif

                <td style="border-bottom: 1px solid #f0f0f0; text-align:right;">
                    {{ to_money($product->amount)->format() }}
                </td>
            </tr>
        @endforeach
    </tbody>
    @php
        $colspans = 3;
        if ($billable->hasDiscount && $billable->isTaxable()) {
            $colspans = 5;
        } elseif ($billable->hasDiscount || $billable->isTaxable()) {
            $colspans = 4;
        }

    @endphp
    <tfoot>
        <tr>
            <th style="font-size:14px; text-align:right; font-weight:bold;" colspan="{{ $colspans }}">
                @lang('billable::billable.sub_total')

                @if ($billable->hasDiscount)
                    <p style="font-style: italic; margin:0; font-weight: normal;">
                        (
                        @lang('billable::billable.includes_discount', [
                            // format
                            'amount' => to_money($billable->totalDiscount)->format(),
                        ])
                        )
                    </p>
                @endif
            </th>

            <td style="text-align:right;">
                {{ to_money($billable->sub_total)->format() }}
            </td>
        </tr>
        @if ($billable->tax_type !== 'no_tax')
            @foreach ($billable->getAppliedTaxes() as $tax)
                <tr>
                    <th style="font-size:14px; text-align:right; font-weight:bold;" colspan="{{ $colspans }}">
                        {{ $tax['label'] }} ({{ $tax['rate'] }}%)
                    </th>
                    <td style="text-align:right;">
                        @if ($billable->isTaxInclusive())
                            @lang('billable::billable.tax_amount_is_inclusive')
                        @endif
                        {{ to_money($tax['total'])->format() }}
                    </td>
                </tr>
            @endforeach
        @endif
        <tr>
            <th style="font-size:14px; text-align:right; font-weight:bold;" colspan="{{ $colspans }}">
                @lang('billable::billable.total')
            </th>
            <td style="text-align:right;">
                {{ to_money($billable->total)->format() }}
            </td>
        </tr>
    </tfoot>
</table>
