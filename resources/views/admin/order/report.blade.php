<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Penjualan</title>

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

        .text-center {
            text-align: center;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <h3 class="text-center" style="text-align:center;">Laporan Penjualan Bulan
        {{ date('F'), strtotime($month->created_at) }}</h3>
    <div class="invoice-box">
        <table class="table table-striped">
            <tr class="heading text-center">
                <td style="text-align:center;">Invoice ID</td>
                <td style="text-align:center;">Tanggal</td>
                <td style="text-align:center;">Total Harga</td>
                <td style="text-align:center;">Status</td>
            </tr>
            @if ($orders->count() > 0)
                @foreach ($orders as $item)
                    <tr class="item text-center">
                        <td style="text-align:center;">{{ $item->id }}</td>
                        <td style="text-align:center;">{{ date('d F Y H:i:s', strtotime($item->created_at)) }} WIB
                        </td>
                        <td style="text-align:center;">Rp. {{ number_format($item->total_price) }}</td>
                        <td style="text-align:center;">Selesai</td>
                    </tr>
                @endforeach
            @else
                <td colspan="4">Tidak ada Penjualan</td>
            @endif
        </table>
    </div>
</body>

</html>
