<div class="news-block">
    <?php $__currentLoopData = $newsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article>
            <h2><?php echo e($news->title); ?></h2>
            <p><?php echo e($news->perex); ?></p>
            <a href="<?php echo e(route('home', $news->id)); ?>">Read More</a>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php /**PATH C:\xampp8.1\htdocs\aicms.test\resources\views\components\news-block.blade.php ENDPATH**/ ?>