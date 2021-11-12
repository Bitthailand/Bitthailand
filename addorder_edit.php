<?php
include './include/connect.php';
// $emp_id=$_SESSION["username"]; 
$id = intval($_REQUEST['id']);
// echo "$id";
$sql = "SELECT * FROM order_details  WHERE id = '$id' ";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$sql2 = "SELECT * FROM product_type  WHERE ptype_id = '$row[ptype_id]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();

$sql3 = "SELECT * FROM product  WHERE product_id = '$row[product_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
$sql4 = "SELECT * FROM unit  WHERE id = '$row3[units]'";
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
        <label for="plant"><strong>สต็อกโรงงาน1 <span class="text-danger"></span></strong></label>
        <input type="text" class="classcus form-control" value="<?php echo $row3['fac1_stock']; ?>" id="face1_stock" name="face1_stock" readonly>
    </div>
    <div class="form-group col-md-4">
        <label for="plant"><strong>สต็อกโรงงาน2 <span class="text-danger"></span></strong></label>
        <input type="text" class="classcus form-control" value="<?php echo $row3['fac2_stock']; ?>" id="face2_stock" name="face2_stock" readonly>
    </div>
    <div class="form-group col-md-4">
        <label for="sqm"><strong>ราคาต่อหน่วย<span class="text-danger"></span></strong></label>
        <input type="text" name="unit_pricex" id="unit_pricex" value="<?php echo "$row[unit_price]"; ?>"  class="classcus form-control" readonly>

    </div>
</div>
<div class="row mt-12">

    <!-- <div class="form-group col-md-4">
        <label><strong>จำนวนสั่งโรงงาน1 <span class="text-danger"></span></strong></label>
        <input type="text" name="face1_out" id="face1_out" value="<?php echo "$row[face1_stock_out]"; ?>" onkeyup="keyup()" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>
    </div>
    <div class="form-group col-md-4">
        <label><strong>จำนวนสั่งโรงงาน2 <span class="text-danger"></span></strong></label>
        <input type="text" name="face2_out" id="face2_out" value="<?php echo "$row[face2_stock_out]"; ?>" onkeyup="keyup()" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>
    </div> -->
    <div class="form-group col-md-4">
        <label for="sqm"><strong>จำนวนสั่งรวม<span class="text-danger"></span></strong></label>

        <input type="text" name="qty" id="qtyx" value="<?php echo "$row[qty]"; ?>" onkeyup="keyup()" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>

    </div>
    <div class="form-group col-md-4">
    <label for="sqm"><strong>ราคารวม<span class="text-danger"></span></strong></label>
    <input type="text" name="total_price" id="total_pricex" value="<?php echo "$row[total_price]"; ?>" class="classcus form-control" readonly>
</div>
</div>
<div class="row mt-12">

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
        EDIT</button>
    <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
    <input type="hidden" name="action" value="edit">

    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


<script>
    function keyup() {
        var face1_out = $('#face1_out').val();
        var face2_out = $('#face2_out').val();
        var face1_stock = $('#face1_stock').val();
        var face2_stock = $('#face2_stock').val();
        var qtyx = $('#qtyx').val();
        var unit_price = $('#unit_pricex').val();
        var face1_outx = Number(face1_out);
        var face2_outx = Number(face2_out);
        var qtyx = Number(qtyx);
        var face1x_stock = Number(face1_stock);
        var face2x_stock = Number(face2_stock);
        var unit_pricex = Number(unit_price);
        var qtyx = Number(qtyx);
        console.log('ct', face1_out)
        console.log('qtyx', qtyx)
        console.log('unit_pricex', unit_pricex)
        // if (face1x_stock < face1_outx) {

        //     alert('กรอกเลขเกินจำนวนสต็อก')
        //     var dff = 0;
        //     $('#face1_out').val(dff);


        // }

        // if (face2x_stock < face2_outx) {
        //     alert('กรอกเลขเกินจำนวนสต็อก')
        //     var dff = 0;
        //     $('#face2_out').val(dff);

        // }
        // qty = parseFloat(face1_outx) + parseFloat(face2_outx);
        var total_price =  parseFloat(unit_pricex)*parseFloat(qtyx);
        console.log('qty', qty)
        console.log('total_price', total_price)
        $('#qtyx').val(qtyx);
        $('#total_pricex').val(total_price);


    }
    $("#dev_date").on("change", function() {

        let dev_date = $("#dev_date").val();
        console.log('btu', dev_date)
        if (dev_date === undefined || dev_date === '') {
            document.getElementById("btu").disabled = true;
        } else {
            document.getElementById("btu").disabled = false;

        }

    });
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