<?php
  include_once("../model/connect.php");
?>

<?php 
if(isset($_GET['quanly']))
{ 
  switch($_GET['quanly'])
  {
    case 'danhmucsanpham':
      include("../view/cus/menu/danhmuc.php");
      break;
    case 'chitiet_sp':
      include("../view/cus/menu/chitiet_sp.php");
      break;
    default:
      include("../view/cus/menu/menu.php");
      break;
  }
}
else {
  include("../view/cus/menu/menu.php");
}
?>
