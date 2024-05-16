<!-- <div class="pagination">
    <?php if ($currentPage > 1): ?>
        <a href="?page=1">&laquo; First</a>
        <a href="?page=<?php echo $currentPage - 1; ?>">&lt; Previous</a>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $currentPage): ?>
                <span class="current-page"><?php echo $i; ?></span>
            <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?php echo $currentPage + 1; ?>">Next &gt;</a>
        <a href="?page=<?php echo $totalPages; ?>">Last &raquo;</a>
    <?php endif; ?>
</div> -->

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=1" aria-label="First">
                    <span aria-hidden="true">&laquo; First</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&lt; Previous</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($totalPages > 1): ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $currentPage): ?>
                    <li class="page-item active">
                        <span class="page-link"><?php echo $i; ?></span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
        <?php endif; ?>

        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">Next &gt;</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $totalPages; ?>" aria-label="Last">
                    <span aria-hidden="true">Last &raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
