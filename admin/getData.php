<?php
if (isset($_POST['page'])) {
    // Include pagination library file 
    include_once 'Pagination.class.php';

    // Include database configuration file 
    require_once 'dbConfig.php';

    // Set some useful configuration 
    $baseURL = 'getData.php';
    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
    $limit = 10;

    // Set conditions for search 
    $whereSQL = '';
    if (!empty($_POST['keywords'])) {
        $whereSQL = " WHERE (op_username LIKE '%" . $_POST['keywords'] . "%' OR op_id LIKE '%" . $_POST['keywords'] . "%') ";
    }
    // if (isset($_POST['filterBy']) && $_POST['filterBy'] != '') {
    //     $whereSQL .= (strpos($whereSQL, 'WHERE') !== false) ? " AND " : " WHERE ";
    //     $whereSQL .= " status = " . $_POST['filterBy'];
    // }

    // Count of all records 
    $query   = $db->query("SELECT COUNT(*) as rowNum FROM order_prod " . $whereSQL);
    $result  = $query->fetch_assoc();
    $rowCount = $result['rowNum'];

    // Initialize pagination class 
    $pagConfig = array(
        'baseURL' => $baseURL,
        'totalRows' => $rowCount,
        'perPage' => $limit,
        'currentPage' => $offset,
        'contentDiv' => 'dataContainer',
        'link_func' => 'searchFilter'
    );
    $pagination =  new Pagination($pagConfig);

    // Fetch records based on the offset and limit 
    $query = $db->query("SELECT * FROM order_prod $whereSQL ORDER BY op_id LIMIT $offset,$limit");
?>
    <!-- Data list container -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($query->num_rows > 0) {
                while ($row = $query->fetch_assoc()) {
                    
            ?>
                    <tr>
                        <th scope="row"><?php echo $row["op_id"]; ?></th>
                        <td><?php echo $row["op_username"]; ?></td>
                        <td><?php echo $row["op_quantity"]; ?></td>
                        <td><?php echo $row["op_price"]; ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['op_orderDate'])); ?></td>
                    </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="6">No records found...</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <!-- Display pagination links -->
    <?php echo $pagination->createLinks(); ?>
<?php
}
?>