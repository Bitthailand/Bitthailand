<?php
include './include/connect.php';

$id = intval($_REQUEST['id']);
echo "$id";
$sql = "SELECT * FROM order_details  WHERE id = '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$sql2 = "SELECT * FROM product_type  WHERE ptype_id = '$row[ptype_id]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();

$sql3 = "SELECT * FROM product  WHERE product_id = '$row[product_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
$sql4= "SELECT * FROM unit  WHERE id = '$row3[units]'";
$rs4 = $conn->query($sql4);
$row4 = $rs4->fetch_assoc();

?>



    <div class="row mt-12">
        <div class="form-group col-md-4">
            <label for="plant"><strong>ประเภทสินค้า <span class="text-danger"></span></strong></label>
            <input type="text" class="classcus form-control" value="<?php echo $row2['ptype_name']; ?>" placeholder="ประเภทสินค้า" disabled>
        </div>
        <div class="form-group col-md-8">
            <label for="plant"><strong>สินค้าที่สั่ง <span class="text-danger"></span></strong></label>
            <input type="text" class="classcus form-control" value="<?php echo $row3['product_name']; ?> - <?php echo $row3['product_name']; ?> - ยาว <?php echo $row3['width']; ?>  ขนาดลวด <?php echo $row3['dia_size']; ?> จำนวน <?php echo $row3['dia_count']; ?>  " placeholder="สินค้าผลิต" disabled>
        </div>
    </div>
    <div class="row mt-12">

        <div class="form-group col-md-4">
            <label for="qty"><strong>จำนวนสั่งผลิต <span class="text-danger"></span></strong></label>
            <input type="text" name="qty" value="<?php echo "$row[qty]"; ?>" data-index="1" onkeyup="calculate()" class="classcus form-control" placeholder="จำนวนสั่งผลิต"  required>
          
           
        </div>
        <div class="form-group col-md-4">
            <label for="sqm"><strong>ราคาต่อหน่วย<span class="text-danger"></span></strong></label>
            <input type="text" name="unit_price" value="<?php echo "$row[unit_price]"; ?>"  onkeyup="calculate()" data-index="2"  class="classcus form-control" placeholder="ราคาต่อหน่วย" required disabled>
           
        </div>
        <div class="form-group col-md-4">
            <label for="sqm"><strong>ราคารวม<span class="text-danger"></span></strong></label>
       
            <input type="text" name="total_price" value="<?php echo "$row[total_price]"; ?>" class="classcus form-control" placeholder="ราคารวม" required >
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            EDIT</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <input type="hidden" name="status_order" value="update">
        <input type="hidden" name="action" value="edit">
        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>


    <script>
    function calculate() {
        if (isNaN(document.forms["myform"]["qty"].value) || document.forms["myform"]["qty"].value == "") {
            var text1 = 0;
        } else {
            var text1 = parseInt(document.forms["myform"]["qty"].value);
        }
        if (isNaN(document.forms["myform"]["unit_price"].value) || document.forms["myform"]["unit_price"].value == "") {
            var text2 = 0;
        } else {
            var text2 = parseFloat(document.forms["myform"]["unit_price"].value);
        }
        
        document.forms["myform"]["total_price"].value = (text1 * text2);
      
    }
</script>

<script>
    $('#inputform2').on('keydown', 'input', function(event) {
        if (event.which == 13) {
            event.preventDefault();
            var $this = $(event.target);
            var index = parseFloat($this.attr('data-index'));
            $('[data-index="' + (index + 1).toString() + '"]').focus();
        }
    });
</script>