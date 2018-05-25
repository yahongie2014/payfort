<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment page</title>
  <style media="screen">
    html, body {
      margin:0;
      padding:0;
    }
    * {
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
    }
    body {
      font-size:14px;
      font-family:Arial, times;
    }
    .container {
      width:100%;
      max-width: 760px;
      margin:0 auto;
    }
    .container .pay-container {
      width:320px;
      padding:20px;
      margin:50px auto 0 auto;
      background-color:#efefef;
    }
    table {
      border:0;
      padding:0;
      margin:0;
      width:100%;
    }
    input[type="text"],
    input[type="submit"] {
      width:100%;
      padding:10px;
      display:block;
      border:1px solid #e2e2e2;
      margin:0 0 10px 0;
    }
    input[type="text"] {
      font-size:16px;
      font-weight:bold;
    }
    input[type="submit"] {
      font-size:14px;
      font-weight:bold;
      color:#ffffff;
      background-color:#ff0000;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="pay-container">
      <form class="payment-form" id="payfort_fort_form" action="{{url('#')}}" method="post">
        <!-- this is your order id number generated from your cart system -->
        <input type="hidden" name="product_id" value="1" id="client_merchant_oid">
        <!-- this is your order total, the amount that you want to charge the card -->
        <input type="hidden" name="product_amount" value="10" id="client_merchant_amount">
        <!-- this is options and can be any name that you want to provide to the product -->
        <input type="hidden" name="product_name" value="micro-monthly">
        <!-- paymentMethod is a mandatory value and must be included -->
        <input type="hidden" name="paymentMethod" value="cc_merchant_page_2">
        <!-- This is your route parameter to process on the ajax call. If you change the value here, change in pay.php too -->
        <input type="hidden" name="action" value="generate_final_form">

        <table border="0">
          <tr>
            <td colspan="2"><input type="text" id="payfort_fort_card_holder_name" name="card_holder_name" value="" placeholder="Name on card"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="text" id="payfort_fort_card_number" name="card_number" value="" placeholder="Credit card number"></td>
          </tr>
          <tr>
            <td width="50%"><input type="text" id="payfort_fort_expiry_month" name="expiry_month" value="" placeholder="Expiry month"></td>
            <td width="50%"><input type="text" id="payfort_fort_expiry_year" name="expiry_year" value="" placeholder="Expiry year"></td>
          </tr>
          <tr>
            <td width="50%"><input type="text" id="payfort_fort_cvv" name="cvv" value="" placeholder="CVV"></td>
            <td width="50%"><input type="submit" id="payfort_fort_pay_action" value="Pay SAR 10.00"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>

  <script src="assets/js/jquery-3.1.1.js"></script>
  <!-- the checkout.js file contains all javascript related to processing the payment transaction -->
  <script src="assets/js/checkout.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#payfort_fort_pay_action').on('click',function(e) {
        e.preventDefault();
        payfortFortMerchant.process();
      });
    });
  </script>
</body>
</html>
