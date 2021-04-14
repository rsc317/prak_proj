<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/listpersons.inc.php';

if(!isset($_SESSION['email'])){
    header("location: ../login.php");
    exit();
}

?>
    <table>
        <tr>
            <th>E-Mail</th>
            <th>Firstname</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><a href = details.php?email=<?php echo $row['email']; ?>><?php echo $row['email']; ?></a></td>
                <td><?php echo $row['first_name']; ?></td>
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

<?php endif;
?>
<?php
include_once 'footer.php';
