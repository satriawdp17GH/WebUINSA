<?php /** @var \CodeIgniter\Pager\PagerRenderer $pager */ ?>
<?php $pager->setSurroundCount(2); ?>
<?php if ($pager->getPageCount() > 1): ?>
<nav class="pg" aria-label="Navigasi halaman">
    <?php if ($pager->hasPrevious()): ?>
    <a class="pgb" href="<?= esc($pager->getPrevious(), 'attr') ?>" aria-label="Sebelumnya"><i
            class="bi bi-chevron-left"></i></a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
    <a class="pgb <?= $link['active'] ? 'on' : '' ?>" href="<?= esc($link['uri'], 'attr') ?>"
        <?= $link['active'] ? 'aria-current="page"' : '' ?>><?= esc($link['title']) ?></a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()): ?>
    <a class="pgb" href="<?= esc($pager->getNext(), 'attr') ?>" aria-label="Berikutnya"><i
            class="bi bi-chevron-right"></i></a>
    <?php endif ?>
</nav>
<?php endif ?>