<div class="pagination-container margin-top-30 margin-bottom-10" aria-label="<?= lang('Pager.pageNavigation') ?>">
    <nav class="pagination">
        <ul>
            <?php if ($pager->hasPreviousPage()) : ?>
                <li class="pagination-arrow">
                    <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="ripple-effect">
                        <span aria-hidden="true"><i class="icon-material-outline-keyboard-arrow-left"></i></span>
                    </a>
                </li>
            <?php endif ?>
            <?php foreach ($pager->links() as $link) : ?>
                <li>
                    <a href="<?= $link['uri'] ?>" class="ripple-effect <?= $link['active'] ? 'current-page' : '' ?> ">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>
            <?php if ($pager->hasNextPage()) : ?>
               <li class="pagination-arrow">
                <a href="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>" class="ripple-effect">
                    <span aria-hidden="true"><i class="icon-material-outline-keyboard-arrow-right"></i></span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
</div>