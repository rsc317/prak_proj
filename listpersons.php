<?php
include_once 'header.php';
include_once 'sidenav.php';
require_once 'include/listpersons.inc.php';
?>

    <main>
    <div class="container">
    <br>
    <table class="table table-bordered table-hover" style="width: 1408px;">
        <th style="text-align: center; " colspan="3">
            <div class="th-inner ">LIST PERSONS</div>
            <div class="fht-cell"></div>
        </th>
        <tr>
            <th style="text-align: center">E-Mail</th>
            <th style="text-align: center">Name</th>
        </tr>
        <?php foreach ($result as $row): ?>
            <tr>
                <td><a href=details.php?email=<?php echo $row['email']; ?>><?php echo $row['email']; ?></a></td>
                <td><?php echo $row['first_name']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php if (ceil($total_pages / $rop) > 0): ?>
    <div class="fixed-table-pagination" style="">
        <div class="float-left pagination">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item page-pre"><a class="page-link" aria-label="previous page"
                                                      href="listpersons.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                <?php endif; ?>

                <?php if ($page > 3): ?>
                    <li class="start"><a class="page-link" href="listpersons.php?page=1">1</a></li>
                    <li class="dots"><a class="page-link">...</a></li>
                <?php endif; ?>

                <?php if ($page - 2 > 0): ?>
                    <li class="page-item"><a class="page-link"
                                             href="listpersons.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a>
                    </li><?php endif; ?>
                <?php if ($page - 1 > 0): ?>
                    <li class="page-item"><a class="page-link"
                                             href="listpersons.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a>
                    </li><?php endif; ?>

                <li class="page-item active"><a class="page-link"
                                                href="listpersons.php?page=<?php echo $page ?>"><?php echo $page ?></a>
                </li>

                <?php if ($page + 1 < ceil($total_pages / $rop) + 1): ?>
                    <li class="page-item"><a class="page-link"
                                             href="listpersons.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a>
                    </li><?php endif; ?>
                <?php if ($page + 2 < ceil($total_pages / $rop) + 1): ?>
                    <li class="page-item"><a class="page-link"
                                             href="listpersons.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a>
                    </li><?php endif; ?>

                <?php if ($page < ceil($total_pages / $rop) - 2): ?>
                    <li class="dots"><a class="page-link">...</a></li>
                    <li class="end"><a class="page-link"
                                       href="listpersons.php?page=<?php echo ceil($total_pages / $rop) ?>"><?php echo ceil($total_pages / $rop) ?></a>
                    </li>
                <?php endif; ?>

                <?php if ($page < ceil($total_pages / $rop)): ?>
                    <li class="page-item page-next"><a class="page-link" aria-label="next page"
                                                       href="listpersons.php?page=<?php echo $page + 1 ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    </div>
    </main>
<?php endif;
?>
<?php
include_once 'footer.php';
