<!doctype html>
<html>
<head>
<style>
.invoice-box, .invoice-box table {
           width: 100%;
           line-height: inherit;
           text-align: left;
           table-layout: fixed;
           background-color: transparent;
           border-collapse: collapse;
           max-width: 800px;
           font-size: 12px;
           font-weight: 300;
           font-family: 'Gill Sans', sans-serif;
       }
 
</style>
</head>
 
<body>
<div id="invoiceItemJSON"></div>
</body>

<script>
   const invoiceItems = {% if Data.InvoiceItem %}
                           {{- Data.InvoiceItem | to_json -}};
                       {%- endif -%}
   var firstInvoiceQuantity = invoiceItems[0].Quantity;
   document.getElementById("invoiceItemQuantity").innerHTML = firstInvoiceQuantity;
</script>
</html> 