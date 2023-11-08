<nav <?php echo e($attributes->merge(['class' => 'flex items-center gap-2'])); ?>>
    <a wire:navigate.hover href="<?php echo e(route('home')); ?>" class="font-medium text-indigo-400 underline">
        Home
    </a>

    <span class="opacity-30">/</span>

    <?php if(! empty($middle)): ?>
        <?php if($middle->attributes->has('href')): ?>
                <?php echo e($middle); ?>

        <?php else: ?>
            <span <?php echo e($middle->attributes->merge(['class' => 'font-medium opacity-30'])); ?>>
                <?php echo e($middle); ?>

            </span>
        <?php endif; ?>

        <span class="opacity-30">/</span>
    <?php endif; ?>

    <span class="opacity-50 line-clamp-1">
        <?php echo e($slot); ?>

    </span>
</nav>
<?php /**PATH C:\xampp8.1\htdocs\aicms.test\resources\views\components\breadcrumb.blade.php ENDPATH**/ ?>