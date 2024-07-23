<?php
if (isset($_POST['page'])) {
    // Include pagination library file 
    include_once 'Pagination.class.php';

    // Include database configuration file 
    require_once 'admin/includes/dbcon.php';

    // Set some useful configuration 
    $baseURL = 'getData.php';
    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
    $limit = 20;

    $keywords = $pdo->quote($_POST['keywords']);

    // Set conditions for search 
    $whereSQL = '';
    if (!empty($_POST['keywords'])) {
        $whereSQL = " WHERE (prod_name LIKE '%" . $keywords . "%') ";
    }

    // Count of all records 
    $query   = $pdo->query("SELECT COUNT(prod_id) as rowNum FROM product " . $whereSQL);
    $result  = $query->fetch(PDO::FETCH_ASSOC);
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
    $query = $pdo->query("SELECT * FROM product $whereSQL ORDER BY prod_datecreated DESC LIMIT $offset,$limit");
?>
    <!-- Data list container -->
    <div class="container">
        <div class="row justify-content-center">


            <?php
            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $offset++
            ?>

                    <div style="padding-top: 20px; border-bottom: 1px solid #8c8b8b;">
                        <form action="book?Author_name=<?php echo ($row['bp_author']) ?>&title=<?php echo ($row['bp_booktitle']) ?>& types=<?php echo ($row['bp_booktype']) ?>" method="POST">
                            <div class="col-sm justify-content-center">

                                <div class="card text-center shadow p-3 mb-4 rounded" style="min-height: 270px; width: 300px; margin-left: auto; margin-right: auto;">
                                    <button name="view_more" class="btn" style="background-color: transparent;"><img src="admin/assets/image/prodPhoto/<?php echo $row['prod_image']; ?>" alt="image" height="200px;"></button>


                                    <h1 class="authorws" style="font-size: 20px;"><?php echo $row['prod_name']; ?></h1>
                                    <h1 style="font-size: 14px;font-weight: normal;"><?php echo $row['prod_desc']; ?></h1>
                                    <h1 class="authorws" style="font-size: 16px;color: red;">$ <?php echo $row['prod_price']; ?></h1>

                                </div>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<tr><td colspan="6">No records found...</td></tr>';
            }
            ?>
        </div>
        <div class="Pagination">
            <?php echo $pagination->createLinks(); ?>
            <!-- Display pagination links -->


        </div>
    </div>

<?php
}
?>