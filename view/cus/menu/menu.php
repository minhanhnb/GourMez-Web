<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(".list a").click(function(e) {
        e.preventDefault();
        var page = $(this).attr("href");
        // Load only the food-item section
        $.get(page, function(data) {
            var foodItemHtml = $(data).find('.food-item').html();
            $(".food-item").html(foodItemHtml);

        });
    });
});

</script>
</head>
<?php
    if(isset($_GET['trang'])){
        $page = $_GET['trang'];
    } else {
        $page = 1; 
    }

    if($page == 1){
        $begin = 0; 
    } else {
        $begin = ($page - 1) * 8; 
    }
    $conn = connectdb();

    $sql_lietke_sanpham = "SELECT * FROM food, category WHERE food.cate_id = category.cate_id ORDER BY food_id ASC LIMIT $begin, 8";
    $query_lietke_sanpham = mysqli_query($conn, $sql_lietke_sanpham);
?>
<div id="all_dishes" style="margin-top: 100px; display: flex;">
    <div class="sidebar_1">
        <?php 
            include("../view/cus/menu/sidebar.php");
        ?>
    </div>
    <div class="noidung_menu" style="flex-grow: 1">
        <img src="../view/cus/menu/s.png" width="100%";height="50%">
        <h1 class="title_thucdon">Hôm nay ăn gì?</h1>
        <div class="food-item">
            <?php
                $i = 0;
                while ($row = mysqli_fetch_array($query_lietke_sanpham)) {
                    $i++;
            ?>
            <li class="Thucdon_mon">  
                <img src="../view/admin/ql_sanpham/uploads/<?php echo $row['img'] ?>" style="width: 150px; height: 150px;">
                <p class="Ten_mon"><?php echo $row['food_name'] ?></p>
                <p>
                    <span class="label">Giá bán:</span> 
                    <span class="price"><?php echo number_format($row['selling_price'],0,',','.').'vnđ' ?></span>
                </p>
                <button class="btn_xemchitiet">
                    <a href="hienthi_menu.php?quanly=chitiet_sp&id=<?php echo $row['food_id']?>" style="text-decoration: none; color: #ffff;">Xem chi tiết</a>
                </button>
            </li>
            <?php
                }
            ?>
        </div>
        <?php
            $sql_trang = mysqli_query($conn,"SELECT * FROM food");
            $row_count = mysqli_num_rows( $sql_trang);
            $trang = ceil($row_count/8);
        ?>
        <div class="list_trang">
            <ul class="list">
                <?php
                    for($i=1; $i<=$trang;$i++){
                    ?>
                        <li><a href="tranghienthi.php?quanly=thucdon&trang=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }
                    ?>
            </ul>
        </div>
        <?php
            $conn = connectdb();
            $sql_lietke= "SELECT * FROM discount_news ORDER BY id ASC";
            $query_lietke = mysqli_query($conn, $sql_lietke);
            
            $discounts = mysqli_fetch_all($query_lietke, MYSQLI_ASSOC);
            shuffle($discounts);
            
            $selected_discounts = array_slice($discounts, 0, 3);
        ?>
        <h1 class="title_datngaynao">Đặt ngay nào</h1>
            <div class="onediscount"  style=" margin-left: 13vw;">
                <?php foreach ($selected_discounts as $row): ?>
                <li class="Thucdon_mon2">
                    <img src="../view/admin/<?php echo $row['img'] ?>" style="width: 170px; height: 170px;">
                    <p class="discount_name" style=" color: #F6E7D8; font-size: 19px;font-family:Lalezar"><?php echo $row['discount_name'] ?></p>
                    <button class="btn_xemchitiet">
                        <a href="tranghienthi.php?quanly=chitietkm&id=<?php echo $row['id']?>" style="text-decoration: none; color: #ffff;">Xem chi tiết</a>
                    </button>
                </li>
                <?php endforeach; ?>
            </div>
    </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function() {
    var noidungMenuHeight = document.querySelector('.noidung_menu').offsetHeight;
    var sidebar = document.querySelector('.sidebar_1');
    sidebar.style.height = noidungMenuHeight + 'px';
});
</script>
