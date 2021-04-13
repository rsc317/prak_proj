<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/listpersons.inc.php';
require_once 'include/dbc.inc.php';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$rop = 5;
$c_page = ($page - 1) * $rop;

$result = getLimitedUsers($conn, $c_page, $rop);
$total_pages = getTotalNumberOfUsers($conn);
?>
    <table>
        <tr>
            <th>E-Mail</th>
            <th>Firstname</th>
            <th>Givenname</th>
            <th>Streetname</th>
            <th>Number</th>
            <th>Postcode</th>
            <th>City</th>
            <th>Phonenumber</th>
            <th>Active</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['given_name']; ?></td>
                <td><?php echo $row['street_name']; ?></td>
                <td><?php echo $row['street_number']; ?></td>
                <td><?php echo $row['post_code']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['phone_number']; ?></td>
                <td><?php echo $row['active']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php if (ceil($total_pages / $rop) > 0): ?>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="prev"><a href="listpersons.php?page=<?php echo $page - 1 ?>">Prev</a></li>
        <?php endif; ?>

        <?php if ($page > 3): ?>
            <li class="start"><a href="listpersons.php?page=1">1</a></li>
            <li class="dots">...</li>
        <?php endif; ?>

        <?php if ($page - 2 > 0): ?>
            <li class="page"><a href="listpersons.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a>
            </li><?php endif; ?>
        <?php if ($page - 1 > 0): ?>
            <li class="page"><a href="listpersons.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a>
            </li><?php endif; ?>

        <li class="currentpage"><a href="listpersons.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

        <?php if ($page + 1 < ceil($total_pages / $rop) + 1): ?>
            <li class="page"><a href="listpersons.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a>
            </li><?php endif; ?>
        <?php if ($page + 2 < ceil($total_pages / $rop) + 1): ?>
            <li class="page"><a href="listpersons.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a>
            </li><?php endif; ?>

        <?php if ($page < ceil($total_pages / $rop) - 2): ?>
            <li class="dots">...</li>
            <li class="end"><a
                        href="listpersons.php?page=<?php echo ceil($total_pages / $rop) ?>"><?php echo ceil($total_pages / $rop) ?></a>
            </li>
        <?php endif; ?>

        <?php if ($page < ceil($total_pages / $rop)): ?>
            <li class="next"><a href="listpersons.php?page=<?php echo $page + 1 ?>">Next</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<?php
include_once 'footer.php';
