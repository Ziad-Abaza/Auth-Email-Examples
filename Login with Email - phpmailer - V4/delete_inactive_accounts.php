<!-- delete_inactive_accounts.php -->
<?php
include 'db_config.php';

// الحصول على التاريخ والوقت الحالي
$currentDateTime = date('Y-m-d H:i:s');

// استعلام لاسترداد الحسابات غير المفعلة والتي مضى على وجودها ساعة
$sql_inactive_accounts = "SELECT * FROM users WHERE is_active = 0 AND token_expiration <= '$currentDateTime'";
$result_inactive_accounts = mysqli_query($conn, $sql_inactive_accounts);

if (mysqli_num_rows($result_inactive_accounts) > 0) {
    // حذف الحسابات غير المفعلة
    while ($row = mysqli_fetch_assoc($result_inactive_accounts)) {
        $user_id = $row['id'];
        // استعلام لحذف الحساب من قاعدة البيانات
        $sql_delete_account = "DELETE FROM users WHERE id = $user_id";
        mysqli_query($conn, $sql_delete_account);
        // يمكنك هنا أيضًا إجراء أي إجراءات إضافية قبل حذف الحساب، مثل حذف محتوى مرتبط بالحساب، إلخ.
    }
}

// إغلاق اتصال قاعدة البيانات
mysqli_close($conn);
?>
