<div class="pagination-container margin-top-30 margin-bottom-10" aria-label="<?= lang('Pager.pageNavigation') ?>">
    <nav class="Page navigation">
        <ul class="pagination">
            <?php if ($pager->hasPreviousPage()) : ?>
                <li class="page-item">
                    <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="page-link">
                        <span aria-hidden="true">Previous</span>
                    </a>
                </li>
            <?php endif ?>
            <?php foreach ($pager->links() as $link) : ?>
                <li class="page-item  <?= $link['active'] ? 'active' : '' ?>" aria-current="page">
                    <a href="<?= $link['uri'] ?>" class="page-link">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>
            <?php if ($pager->hasNextPage()) : ?>
               <li class="page-item">
                <a href="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>" class="page-link">
                    <span aria-hidden="true">Next</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
</div>