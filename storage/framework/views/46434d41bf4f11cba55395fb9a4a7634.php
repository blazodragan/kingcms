<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        {
            "@type": "Question",
            "name": "<?php echo e($item->question ?? ''); ?>",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "<?php echo e($item->answer ?? ''); ?>"
            }
        }
        <?php if(!$loop->last): ?>, <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]
}
</script>
<?php /**PATH C:\xampp8.1\htdocs\aicms.test\resources\views/components/faq-schema.blade.php ENDPATH**/ ?>