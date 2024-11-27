<?php 
session_start();
include ('connect.php');

// kiem tra dang nhap 
if (!isset($_SESSION['status'])||$_SESSION['status']!='login')
{
    header('location:login.php');
    exit();
}

// kiem tra csrf token
if (!isset($_SESSION['csrf_token']))
{
    $_SESSION['csrf_token']=bin2hex(random_bytes(32));
}

// kiem tra vai tro
if ($_SESSION['role']!=="GV")
{
    header('location:login.php');
    exit();
}
// thuc hien truy van 
$stmt=$conn->prepare('select * from sinhvien ');
$stmt->execute();
$result=$stmt->get_result();

?>
<!DOCTYPE html>
<html lang="vi">
<head>
</head>
<body>
    <h1>danh sach sinh vien</h1>
    <form method="POST" action="">
        <table border="1">
        <tr>
            <th>STT</th>
            <th>Masv</th>
            <th>Họ và Tên</th>
            <th>điểm thành phần 1</th>
            <th>điểm thành phần 2</th>
            <th>điểm quá trình</th>
        </tr>
            <?php while($sv=$result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($sv['id']); ?></td>
                <td><?php echo htmlspecialchars($sv['maSV']); ?></td>
                <td><?php echo htmlspecialchars($sv['tenSV']); ?></td>
                <td><input type="text" name="tp1[]" required></td>
                <td><input type="text" name="tp2[]" required></td>
                <td></td>
                <input type="hidden" name="id[]" value="<?php echo $sv['id']; ?>">
            </tr>
            <?php endwhile; ?>
        </table>
        
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="submit" name="submit" value="Lưu">
    </form>

</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit']) )
    {
       // check csrf_token
       if($_SESSION['csrf_token']!==$_POST['csrf_token'])
       {
            echo "token khong hop le";
            exit();
       }

    // xử lý giá trị trả về. 
       $id=$_POST['id'];
       $tp1=$_POST['tp1'];
       $tp2=$_POST['tp2'];
        for ($i=0; $i<count($id); $i++)
        {
         // kiem tra rỗng.
             if(empty($tp1[$i])||empty($tp2[$i]))
             {
                 echo "<script>alert('Vui lòng điền đầy đủ thông tin diem.');</script>";
                 exit();
             }
             $qt = $tp1[$i] * 0.7 + $tp2[$i] * 0.3;
             $stmt=$conn->prepare('replace into diem(sinhvien_id,diem_tp1,diem_tp2,diem_qt) values (?,?,?,?)');
             $stmt->bind_param('iddd', $id[$i],$tp1[$i],$tp2[$i],$qt);
             if(!($stmt->execute()))
             {
                exit();
             }
        }
         echo "<script>
                alert('Successful!');
                window.location.href='home.php';
               </script>";
               exit();
    }
    $conn->close();
?>

