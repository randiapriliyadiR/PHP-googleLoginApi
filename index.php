<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
    <title>LOGIN DENGAN GOOGLE</title>
</head>

<body>
    <table>
        <?php 
if(@$_SESSION['login']):
$login = $_SESSION['login'];
foreach ($login as $key => $value):
?>
        <tr>
            <th><?php echo $key;?></th>
            <td><?php echo (substr($value, 0,5)=='https')?"<img width='100' src='".$value."' />":$value;?></td>
        </tr>
        <?php
endforeach;
else:
?>
        Anda belum login klik disini untuk <a href='login.php'>login</a>
        <?php
endif;
?>
    </table>
</body>

</html>