<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
error_reporting(0);
?>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        font-family: "Angsana New";
        font-size: 16px;
    }

    html {
        font-family: "Angsana New";
        font-size: 16px;
        color: #000000;
    }

    body {
        font-family: "Angsana New";
        font-size: 16px;
        padding: 0;
        margin: 0;
        color: #000000;
    }

    .headTitle {
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        font-family: "Angsana New";
    }

    .headerTitle01 {
        border: 1px solid #333333;
        border-left: 1px solid #000;
        border-bottom-width: 1px;
        border-top-width: 1px;
        font-size: 18px;
        font-family: "Angsana New";
        font-weight: 700;
    }

    .headerTitle01_r {
        border: 1px solid #333333;
        border-left: 2px solid #000;
        border-right: 2px solid #000;
        border-bottom-width: 2px;
        border-top-width: 2px;
        font-size: 18px;
        font-family: "Angsana New";
    }

    /* สำหรับช่องกรอกข้อมูล  */
    .box_data1 {
        font-family: "Angsana New";
        height: 18px;
        border: 0px dotted #333333;
        border-bottom-width: 1px;
    }

    /* กำหนดเส้นบรรทัดซ้าย  และด้านล่าง */
    .left_bottom {
        border-left: 1px solid #000;
        /* border-bottom: 1px solid #000; */
        font-family: "Angsana New";
        font-size: 18px;
    }

    .rightx {
        border-right: 1px solid #000;
        /* border-bottom: 1px solid #000; */
        font-family: "Angsana New";
        font-size: 18px;
    }

    .bottomx {
        border-bottom: 1px solid #000;
        /* border-bottom: 1px solid #000; */
        font-family: "Angsana New";
        font-size: 18px;
    }

    .bottomx2 {
        border-bottom: 1px solid #000;
        border-right: 1px solid #000;
        font-family: "Angsana New";
        font-size: 18px;
    }

    .bottomx2_firt {
        border-bottom: 1px solid #000;
        border-right: 1px solid #000;
        border-left: 1px solid #000;
        font-family: "Angsana New";
        font-size: 18px;
    }

    .bottomx_rl {
        border-bottom: 1px solid #000;
        border-right: 1px solid #000;
        font-family: "Angsana New";
        font-size: 18px;
    }

    /* กำหนดเส้นบรรทัดซ้าย ขวา และด้านล่าง */
    .left_right_bottom {
        border: 1px solid #000;
        /* border-bottom: 1px solid #000; */
        padding-left: 10px;
        font-family: "Angsana New";

    }

    .left_bottom1 {
        border-left: 1px solid #000;
        border-bottom: 1px solid #000;
        /* border-right: 1px solid #000; */
        font-family: "Angsana New";
        font-size: 18px;
    }

    /* สร้างช่องสี่เหลี่ยมสำหรับเช็คเลือก */
    .chk_box {
        display: block;
        width: 10px;
        height: 10px;
        overflow: hidden;
        border: 1px solid #000;
    }

    /* css ส่วนสำหรับการแบ่งหน้าข้อมูลสำหรับการพิมพ์ */
    @media all {
        .page-break {
            display: none;
        }

        .page-break-no {
            display: none;
        }
    }

    @media print {
        .page-break {
            display: block;
            height: 1px;
            page-break-before: always;
        }

        .page-break-no {
            display: block;
            height: 1px;
            page-break-after: avoid;
        }
    }
</style>
<html>

<head>
    <link href="../../dist-assets/css/themes/styleforprint3_label.css?v=5" rel="stylesheet" />
</head>

<body>


    <div class="col-12 text-right">
        <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์</button>
    </div>
    <div align="center">
        <?php
         $result_count = mysqli_query($conn, "SELECT qty  As sum_qty FROM tools   where    status='0' ");
         $total_records = mysqli_fetch_array($result_count);
         $total_records = $total_records['sum_qty'];
        $result = mysqli_query($conn, "SELECT * FROM tools  where    status='0'   order by date_import  ASC     ");
        echo "<table border=\"0\"  cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" ><tr>";
        // $intRows = 0;
        while ($row = mysqli_fetch_array($result)) {
           
            for ($intRowsx = 1; $intRowsx<= $row['qty']; $intRowsx++) {
                // $intRows=$intRows+$row['qty'];
                $intRows++;

           
            // for ($x = 1; $x <= $row['qty']; $x++) {
            // if($row['qty']< 1){ 
            // for ($x = 0; $x <= $row['qty']; $x++) {
               
            echo "<td>";


          
            ?>
               
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="60" class="left_right_bottom">
                                <div align="left">
                                    <p style="font-size: 20px;"><?=$intRows?>//<?= $row['id'] ?>::<?= $row['name'] ?><br><?= $row['comment'] ?>จำนวน<?= $row['qty'] ?></p>
                                </div>
                            </td>
                        </tr>
               
            
                    </table>
                   
            
                  
                <?php
                echo "</td>";
                if (($intRows) % 3 == 0) {
                    echo "</tr>";
                } else {
                    echo "<td>";
                }
                // }
                // }
         } }
            echo "</tr></table>";
                ?>


    </div>
</body>

</html>