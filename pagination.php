<div>
    <?php
    // if (isset($_GET['PAGE'])) {
    //     $page = $_GET['PAGE'];
    // }
    echo '<ul class="pagination pagination-lg">';

    // Previous page link
    if ($page > 1) {
        $params['page'] = $page - 1;
        echo '<li><a href="?' . http_build_query($params) . '">Previous</a></li>';
    }

    // Display page links
    if ($total_pages <= 10) {
        // Less than or equal to 10 pages
        for ($i = 1; $i <= $total_pages; $i++) {
            $params['page'] = $i;
            $active = $page == $i ? 'active' : '';
            echo '<li class="' . $active . '"><a href="?' . http_build_query($params) . '">' . $i . '</a></li>';
        }
    } else {
        // More than 10 pages
        if ($page <= 5) {
            // First 5 pages
            for ($i = 1; $i <= 5; $i++) {
                $params['page'] = $i;
                $active = $page == $i ? 'active' : '';
                echo '<li class="' . $active . '"><a href="?' . http_build_query($params) . '">' . $i . '</a></li>';
            }
            echo '<li><span>...</span></li>';
        } else if ($page > $total_pages - 5) {

            // Last 5 pages
            echo '<li><span>...</span></li>';
            for ($i = $total_pages - 4; $i <= $total_pages; $i++) {
                $active = $page == $i ? 'active' : '';
                $params['page'] = $i;
                echo '<li class="' . $active . '"><a href="?' . http_build_query($params) . '">' . $i . '</a></li>';
            }
        } else {

            // Pages in between
            echo '<li><span>...</span></li>';
            for ($i = $page - 2; $i <= $page + 2; $i++) {
                $active = $page == $i ? 'active' : '';
                $params['page'] = $i;
                echo '<li class="' . $active . '"><a href="?' . http_build_query($params) . '">' . $i . '</a></li>';
            }
            echo '<li><span>...</span></li>';
        }
    }

    // Next page link
    if ($page < $total_pages) {
        $params['page'] = $page + 1;
        echo '<li><a href="?' . http_build_query($params) . '">Next</a></li>';
    }
    echo '</ul>';
    if ($total_records != 0) {
    ?>
        <ul class="pagination pagination-lg">
            <li class="active"><a href="#"> Total: <?php echo $total_records; ?></a></li>
        </ul>
    <?php } ?>
</div>