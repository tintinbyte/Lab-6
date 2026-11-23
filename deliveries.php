<?php
require_once 'includes/db.php';          // 1 · CONNECT
$page_title = 'Deliveries';
include 'includes/header.php';

// 2 · QUERY — every delivery on one day, with the farmer's number and name
$sql = "SELECT f.member_no, f.first_name, f.last_name, d.session, d.litres, d.accepted
        FROM milk_delivery d
        JOIN farmer f ON f.farmer_id = d.farmer_id
        WHERE d.delivery_date = '2026-10-12'
        ORDER BY f.member_no, d.session";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);       // Step 5.1
?>
    <main>
        <p><?php echo $count; ?> deliveries on this day.</p>

        <p>Milk received at the Kiserian, Ngong and Rongai centres.</p>

        <!-- KEEP YOUR LAB 3 CONTENT HERE: the "Record a delivery" heading,
             your <form> and its JavaScript checks, exactly as you had them. -->

        <table>
            <caption>Milk received, Monday 12 October 2026</caption>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Farmer</th>
                    <th>Session</th>
                    <th>Litres</th>
                    <th>Accepted</th>
                </tr>
            </thead>
            <tbody>
<?php
if ($count === 0) {
    echo '<tr><td colspan="5">No deliveries recorded on this day.</td></tr>';
} else {
    // 3 · FETCH each row, and 4 · SHOW it as a table row
    while ($row = mysqli_fetch_assoc($result)) {
        // the database stores 1 or 0; the page says Yes or No
        if ($row['accepted'] == 1) {
            $accepted = 'Yes';
        } else {
            $accepted = 'No';
        }
        echo '<tr>';
        echo '<td>' . $row['member_no'] . '</td>';
        echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
        echo '<td>' . ucfirst(strtolower($row['session'])) . '</td>';
        echo '<td>' . $row['litres'] . '</td>';
        echo '<td>' . $accepted . '</td>';
        echo '</tr>';
    }
}
?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Accepted today</td>
                    <td id="accepted-total"></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </main>
<?php include 'includes/footer.php'; ?>
