<?php
include 'connect_db.php';

$inventory_sql = "SELECT rooms.*, room_types.name as type_name 
                  FROM rooms 
                  JOIN room_types ON rooms.room_type_id = room_types.id 
                  ORDER BY rooms.room_number ASC";
$inventory_result = mysqli_query($connect, $inventory_sql);

if (mysqli_num_rows($inventory_result) > 0) {
    while($inv = mysqli_fetch_assoc($inventory_result)) {
        ?>
        <tr>
            <td><strong><?php echo $inv['room_number']; ?></strong></td>
            <td><?php echo $inv['type_name']; ?></td>
            <td>
                <span class="status-badge status-<?php echo $inv['status']; ?>">
                    <?php echo ucfirst($inv['status']); ?>
                </span>
            </td>
            <td>
                <button class="edit-btn-small" 
                    onclick="openPhysicalModal('edit', '<?php echo $inv['id']; ?>', '<?php echo $inv['room_number']; ?>', '<?php echo $inv['room_type_id']; ?>', '<?php echo $inv['status']; ?>')"
                    style="background:#ffc107; color:black; border:none; padding:5px 10px; border-radius:4px; cursor:pointer; margin-right:5px;">
                    Edit
                </button>
                
                <button class="delete-btn-small" 
                    onclick="deletePhysicalRoom(<?php echo $inv['id']; ?>)"
                    style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                    Delete
                </button>
            </td>
        </tr>
        <?php 
    }
} else {
    echo "<tr><td colspan='4' style='text-align:center;'>No rooms added yet.</td></tr>";
}
?>