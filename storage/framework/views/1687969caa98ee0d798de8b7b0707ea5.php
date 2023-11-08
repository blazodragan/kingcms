
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Article",
  "author": [
    {
      "@type": "Person",
      "name": "<?php echo e($page->user->name); ?>",
      "url": "<?php echo e(route('showAuthor', ['slug' => $page->user->slug])); ?>"
      <?php if($page->user->avatar_url): ?>,
      "image": {
            "@type": "ImageObject",
            "url": "<?php echo e($page->user->avatar_url); ?>"
        }
        <?php endif; ?>
    }
  ],
  "headline": "<?php echo e($page->title); ?>",
  <?php if($page->media->first()): ?>
  
  "image": {
    "@type": "ImageObject",
    "url": "<?php echo e($page->media->first()->getUrl('bigThumb')); ?>"
  },

  <?php endif; ?>
  
  "datePublished": "<?php echo e(date('c', strtotime($page->published_at . ' UTC'))); ?>",
  "publisher": {
    "@type": "Organization",
    "name": "<?php echo e(config('app.name')); ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo e(asset('images/logo.png')); ?>"
    }
  },
  "dateModified": "<?php echo e(date('c', strtotime($page->updated_at . ' UTC'))); ?>",
  "mainEntityOfPage": " <?php echo e(url()->current()); ?>"<?php if($page->perex): ?>,"description": "<?php echo e($page->perex); ?>"<?php endif; ?>
}
</script><?php /**PATH C:\xampp8.1\htdocs\aicms.test\resources\views/components/artical-schema.blade.php ENDPATH**/ ?>