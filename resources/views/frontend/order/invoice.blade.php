<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Invoice {{ $orders->id }}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ $logo }}" style="width: 100%; max-width: 250px" alt="Logo">
                            </td>

                            <td>
                                Invoice ID: {{ $orders->id }}<br />
                                {{ date('d F Y H:i:s', strtotime($orders->created_at)) }} WIB
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Byboot.id<br />
                                Alamat bibut<br />
                                nohp/email
                            </td>

                            <td>
                                {{ $orders->fname }} {{ $orders->lname }}<br />
                                {{ $orders->nohp }}, {{ $orders->address }}<br />
                                {{ $city->name }}, {{ $province->name }}, {{ $orders->postal_code }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Metode Pembayaran</td>
                <td>Status</td>
            </tr>

            <tr class="details">
                @if ($orders->payment_type == 'cstore')
                    <td>Alfamart/Indomaret</td>
                @else
                    <td>{{ $orders->payment_type }}</td>
                @endif
                <td>LUNAS</td>
            </tr>

            <tr class="heading">
                <td>Produk</td>
                <td>Harga</td>
            </tr>
            @foreach ($orders->orderitems as $item)
                <tr class="item">
                    <td>{{ $item->products->name }}, {{ $item->qty }}, {{ $item->prod_size }},
                        {{ $item->message }}</td>
                    <td>Rp. {{ number_format($item->price) }}</td>
                </tr>
            @endforeach
            <tr class="heading">
                <td>Jasa Pengiriman</td>
                <td>Harga</td>
            </tr>
            <tr class="item">
                <td>{{ $orders->courier }}</td>
                <td>Rp. {{ number_format($orders->ongkir) }}</td>
            </tr>
            <tr class="total">
                <td></td>

                <td>Total: Rp. {{ number_format($orders->total_price) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
