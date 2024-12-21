<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            width: 800px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .header .logo img {
            max-height: 60px;
        }

        .header .company-details {
            text-align: right;
        }

        .company-details h3 {
            margin: 0;
            font-size: 18px;
        }

        .company-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .invoice-details .section {
            width: 48%;
        }

        .invoice-details .section h4 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .qr-code img {
            max-width: 100px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        table th {
            background-color: #f4f4f4;
            font-size: 14px;
        }

        table td {
            font-size: 14px;
        }

        table .product-image img {
            max-width: 70px;
            max-height: 70px;
        }

        .totals {
            margin-top: 20px;
            text-align: right;
        }

        .totals .row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin: 5px 0;
        }

        .totals .row strong {
            font-size: 16px;
        }

        .notes {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="https://via.placeholder.com/150x50?text=Lili+Logo" alt="Logo">
        </div>
        <div class="company-details">
            <h3>مجموعة ليلي للتسوق</h3>
            <p>زوروا موقعنا الرسمي للحصول على خصومات كبيرة</p>
            <p>lili-group.com</p>
        </div>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-details">
        <div class="section">
            <h4>فاتورة</h4>
            <p><strong>رقم الطلب:</strong> Lili-1603</p>
            <p><strong>تاريخ الطلب:</strong> 2024-10-19</p>
            <p><strong>طريقة الدفع أو السداد:</strong> Cash on Delivery (COD)</p>
            <div class="qr-code">
                <img src="https://via.placeholder.com/100x100?text=QR" alt="QR Code">
            </div>
        </div>
        <div class="section">
            <h4>تفاصيل الشحن</h4>
            <p>ريم فيصل ريم فيصل</p>
            <p>موصل قوشات</p>
            <p>موصل قوشات</p>
            <p>موصل, العراق</p>
            <p>07508387812</p>
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
        <tr>
            <th>صورة المنتج</th>
            <th>عنوان</th>
            <th>وحدة المخزون</th>
            <th>كمية</th>
            <th>سعر الوحدة</th>
            <th>مجموع</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="product-image">
                <img src="https://via.placeholder.com/70?text=Product" alt="Product">
            </td>
            <td>Women Crossbody - Blue / one-size</td>
            <td>sg2303082146156560</td>
            <td>1</td>
            <td>21,000</td>
            <td>21,000</td>
        </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        <div class="row">
            <span>المجموع الفرعي:</span>
            <span>21,000</span>
        </div>
        <div class="row">
            <span>الشحن:</span>
            <span>7,000</span>
        </div>
        <div class="row">
            <strong>مجموع:</strong>
            <strong>28,000</strong>
        </div>
    </div>

    <!-- Notes -->
    <div class="notes">
        <strong>ملاحظات:</strong>
    </div>
</div>
</body>
</html>
