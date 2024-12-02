<x-app-layout clients title="{{ __('Invoice') }}">
    <section class="py-20">
        <div class="max-w-5xl mx-auto bg-ctp-mantle rounded-md">
            <article class="overflow-hidden">
                <div class="bg-ctp-mantle rounded-md">
                    <div class="p-9 flex flex-row w-full justify-between">
                        <div class=" flex h-full">
                            <div>
                                <x-application-logo />
                            </div>
                            <span class="ml-2 my-auto  text-xl font-extrabold font-body">
                                {{ config('app.name', 'Paymenter') }}
                            </span>
                        </div>
                        @if ($invoice->status == 'pending')
                            <div class="">
                                <p class="text-ctp-red font-semibold mt-2 text-xl">
                                    {{__('Invoice Not Paid')}}
                                </p>
                            </div>
                        @elseif($invoice->status == 'cancelled')
                            <div class="">
                                <p class="text-ctp-yellow font-semibold mt-2 text-xl">
                                    {{__('Invoice Cancelled')}}
                                </p>
                            </div>
                        @else
                            <div class="text-end">
                                <p class="text-ctp-green font-semibold mt-2 text-xl">
                                    {{__('Invoice Paid')}}
                                </p>
                                <span class="block text-sm text-ctp-subtext0 ">
                                    {{ $invoice->paid_at }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-9">
                        <div class="flex w-full">
                            <div class="grid grid-cols-4 gap-12">
                                <div class=" text-sm font-light ">
                                    <p class=" text-sm font-bold ">
                                        {{ __('Billed To') }}</p>
                                    <p>{{ config('settings::company_name')??config('app.name', 'Paymenter') }}</p>
                                    <p>{{ config('settings::company_address') }}</p>
                                    <p>{{ config('settings::company_zip') }} {{ config('settings::company_city') }}</p>
                                    <p>{{ config('settings::company_country') }}</p>
                                    <p>{{ config('settings::company_vat') ?__('VAT').":":null }} {{ config('settings::company_vat') }}</p>
                                </div>
                                <div class=" text-sm font-light ">
                                    <p class=" text-sm font-bold ">
                                        {{ __('Purchaser:') }}
                                    </p>
                                    <p>{{ auth()->user()->name }}</p>
                                    <p>{{ auth()->user()->zip }} {{ auth()->user()->city }}</p>
                                    <p>{{ auth()->user()->address }}</p>
                                    <p>{{ auth()->user()->country }}</p>
                                </div>
                                </div>
                                <div class=" text-sm font-light ">
                                    <p class=" text-sm font-bold ">
                                        {{ __('Invoice Number') }}:</p>
                                    <p>{{ $invoice->id }}/{{ $invoice->created_at->format('m/Y') }}</p>

                                    <p class=" mt-2 text-sm font-bold ">
                                        {{ __('Date of Issue') }}:
                                    </p>
                                    <p>{{ $invoice->created_at }}</p>
                                </div>
                                @if ($invoice->status == 'pending')
                                    <div class=" text-sm font-light ">
                                        <p class=" font-bold text-sm ">
                                            {{ __('Due Date') }}</p>
                                        <p>{{ $invoice->due_at??"N/A" }}</p>
                                    </div>
                                @elseif($invoice->status == 'cancelled')
                                    <div class=" text-sm font-light ">
                                        <p class=" font-bold text-sm ">
                                            {{__('Cancellation Date')}}</p>
                                        <p>{{ $invoice->cancelled_at??"N/A" }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-9">
                        <div class="flex flex-col mx-0 mt-8">
                            <table class="min-w-full divide-y divide-ctp-surface0 ">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class=" py-3.5 pl-4 pr-3 text-left text-sm font-normal  sm:pl-6 md:pl-0">
                                            {{ __('Description') }}
                                        </th>
                                        <th scope="col"
                                            class=" hidden py-3.5 px-3 text-right text-sm font-normal  sm:table-cell">
                                            {{ __('Quantity') }}
                                        </th>
                                        <th scope="col"
                                            class=" hidden py-3.5 px-3 text-right text-sm font-normal  sm:table-cell">
                                            {{ __('Rate') }}
                                        </th>
                                        <th scope="col"
                                            class=" py-3.5 pl-3 pr-4 text-right text-sm font-normal  sm:pr-6 md:pr-0">
                                            {{ __('Amount') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $discount = 0.00; @endphp
                                    @foreach ($products as $product)
                                        @php
                                        if ($product->original_price > $product->price) {
                                            $discount += $product->original_price - $product->price;
                                        }
                                        @endphp
                                        <tr class="border-b border-ctp-surface0">
                                            <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
                                                <div class=" font-medium  @if($invoice->status == 'cancelled') line-through @endif">
                                                    {{ $product->name ?? $product2->description }}
                                                </div>
                                                <div class=" mt-0.5  sm:hidden @if($invoice->status == 'cancelled') line-through @endif">
                                                    {{ __('1 unit at') }}
                                                    <x-money :amount="number_format((float) $product->basePrice, 2, '.', '')" />
                                                </div>
                                            </td>
                                            <td
                                                class=" hidden px-3 py-4 text-sm text-right  sm:table-cell @if($invoice->status == 'cancelled') line-through @endif">
                                                {{ $product->quantity ?? $product2->quantity }}
                                            </td>
                                            <td
                                                class=" hidden px-3 py-4 text-sm text-right  sm:table-cell @if($invoice->status == 'cancelled') line-through @endif">
                                                @if ($product->discount)
                                                    <span class="text-ctp-red line-through">
                                                        <x-money :amount="number_format((float) $product->original_price, 2, '.', '')" />
                                                    </span>
                                                    &nbsp;&nbsp;
                                                    <x-money :amount="number_format((float) $product->price, 2, '.', '')" />
                                                @else
                                                    &nbsp;&nbsp;
                                                    <x-money :amount="number_format((float) $product->price / $product->quantity, 2, '.', '')" />
                                                @endif
                                            </td>
                                            <td
                                                class=" py-4 pl-3 pr-4 text-sm text-right  sm:pr-6 md:pr-0 @if($invoice->status == 'cancelled') line-through @endif">
                                                <x-money :amount="number_format((float) ($product->price * $product->quantity), 2, '.', '')" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @if($discount > 0)
                                    <tr>
                                        <th scope="row" colspan="3"
                                            class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right  sm:table-cell md:pl-0">
                                            {{__('Discount')}}
                                        </th>
                                        <th scope="row"
                                            class="pt-6 pl-4 pr-3 text-sm font-light text-left  sm:hidden">
                                            {{__('Discount')}}
                                        </th>
                                        <td class="pt-6 pl-3 pr-4 text-sm text-right  sm:pr-6 md:pr-0 @if($invoice->status == 'cancelled') line-through @endif">
                                            <x-money :amount="number_format((float) ($discount), 2, '.', '')" />
                                        </td>
                                    </tr>
                                    @endif
                                    <!--
                                    can be enabled if this is made
                                    <tr>
                                        <th scope="row" colspan="3"
                                            class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right  sm:table-cell md:pl-0">
                                            Subtotal
                                        </th>
                                        <th scope="row"
                                            class="pt-6 pl-4 pr-3 text-sm font-light text-left  sm:hidden">
                                            Subtotal
                                        </th>
                                        <td class="pt-6 pl-3 pr-4 text-sm text-right  sm:pr-6 md:pr-0">
                                            @php $subtotal = 0; @endphp
                                            @foreach ($products as $product)
@php $subtotal += $product->price * $product->quantity; @endphp
@endforeach
                                            {{ $currency_sign }}{{ number_format((float) $subtotal, 2, '.', '') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="3"
                                            class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right  sm:table-cell md:pl-0">
                                            Discount
                                        </th>
                                        <th scope="row"
                                            class="pt-6 pl-4 pr-3 text-sm font-light text-left  sm:hidden">
                                            Discount
                                        </th>
                                        <td class="pt-6 pl-3 pr-4 text-sm text-right  sm:pr-6 md:pr-0">
                                            $0.00
                                        </td>
                                    </tr>
                                -->

                                    @if(config('settings::tax_enabled') && $tax->amount > 0)
                                        <tr>
                                            <th scope="row" colspan="3"
                                                class="hidden pt-4 pl-6 pr-3 text-sm font-light text-right  sm:table-cell md:pl-0">
                                                {{ $tax->name }}({{ $tax->rate }}%)
                                            </th>
                                            <th scope="row"
                                                class="pt-4 pl-4 pr-3 text-sm font-light text-left  sm:hidden">
                                                {{ $tax->name }}({{ $tax->rate }}%)
                                            </th>
                                            <td class="pt-4 pl-3 pr-4 text-sm text-right  sm:pr-6 md:pr-0">
                                                <x-money :amount="$tax->amount" />
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row" colspan="3"
                                            class=" hidden pt-4 pl-6 pr-3 text-sm font-normal text-right  sm:table-cell md:pl-0">
                                            {{ __('Total') }}
                                        </th>
                                        <th scope="row"
                                            class=" pt-4 pl-4 pr-3 text-sm font-normal text-left  sm:hidden">
                                            {{ __('Total') }}
                                        </th>
                                        <td
                                            class=" pt-4 pl-3 pr-4 text-sm font-normal text-right  sm:pr-6 md:pr-0">
                                            <x-money :amount="number_format((float) $total, 2, '.', '')" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            @if ($invoice->status == 'pending')
                                <div class="flex justify-between mt-3">
                                    <div>

                                    </div>
                                    <div class="text-sm font-light  col-span-2 text-right justify-end">
                                        <p>
                                        <form action="{{ route('clients.invoice.pay', $invoice->id) }}" method="post">
                                            @csrf
                                            <label for="payment_method"
                                                   class=" block text-sm font-medium text-ctp-subtext0">{{ __('Payment method') }}</label>
                                            <x-input id="payment_method" name="payment_method" type="select"
                                                     autocomplete="payment_method">
                                                @if (config('settings::credits'))
                                                    <option value="credits">
                                                        {{__('Pay with credits')}}
                                                    </option>
                                                @endif
                                                @foreach ($gateways as $gateway)
                                                    <option class=""
                                                            value="{{ $gateway->id }}">
                                                        {{ isset($gateway->display_name) ? $gateway->display_name : $gateway->name }}
                                                    </option>
                                                @endforeach
                                            </x-input>
                                            <button type="submit" class="button button-success mt-3">
                                                {{__('Pay')}}
                                            </button>
                                        </form>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-48 p-9">
                        <div class="border-t pt-9 border-ctp-surface0">
                            <div class=" text-center text-sm font-light ">
                                <p>
                                    {{ __('Thanks for choosing us. We hope you enjoy your purchase.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</x-app-layout>
