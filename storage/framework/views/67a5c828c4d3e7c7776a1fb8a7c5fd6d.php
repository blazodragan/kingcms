

<?php $__env->startSection('title', $page->title ?? 'Default Title'); ?>

<?php $__env->startSection('content'); ?>

<section>
    <div class="bg-search-welcome bg-no-repeat  bg-cover w-full p-5"> <!-- Hero Section -->
        <div class="w-full xl:w-1/2 mx-auto m-auto text-center flex"> <!-- Container Box -->
          <h1 class="text-2xl w-full text-white"><?php echo e(__('Location Review')); ?></h1>         
        </div>
      </div>
</section>
<section class="antialiased bg-gray-50 p-12">
<h1 class="text-4xl mb-10 text-site-blue-dark text-center"><?php echo e($page->title); ?></h1>

    <div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto bodycontent divtable">

    <?php if($page->media->first()): ?>
    <figure class="relative h-0 pb-[36.25%] overflow-hidden mb-8 rounded">
    <img class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" src="<?php echo e($page->media->first()->getUrl('bigThumb')); ?>" alt="<?php echo e($page->media->first()->custom_properties['name'] ?? ''); ?>">

        </figure>
    <?php endif; ?>    

    <?php echo $processedContent; ?>  
    </div>
</section>



<?php if($page && $page->faqs->count() > 0): ?>
  <!-- Snippet -->
  <section class="bg-site-bg-gray">
    <div class="w-3/4 lg:w-1/2 mx-auto">
      <div class="text-4xl mb-5 text-site-blue-dark text-center pt-10"><?php echo e(__('Frequently Asked Questions (FAQ)')); ?></div>
      <div class="faq-box">
      
    <?php $__currentLoopData = $page->faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="faq-item mb-4 rounded-xl border-2 border-site-border-faq bg-white">
          <div class="faq-question cursor-pointer flex justify-between items-center p-4">
            <span class="text-site-blue-ligter font-medium text-xl"><?php echo e($loop->iteration); ?>. <?php echo e($faq->question); ?></span>
            <svg class="faq-arrow stroke-site-blue-ligter" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32"><path d="M6 9L12 15L18 9" stroke="#0D87C6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
          </div>
          <div class="faq-answer-wrapper overflow-hidden max-h-0 transition-all duration-300">
            <div class="faq-answer p-4 text-gray-500">
            <?php echo e($faq->answer); ?>

            </div>
          </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



      </div>
  
      <div class="text-2xl mt-8 mb-4 text-gray-500 text-center"><?php echo e(__('Still have a question?')); ?></div>
      <div class="text-base text-gray-500 text-center pb-10"><?php echo e(__('If you can not find answer to your question in our FAQ, you can always contact us. We Will answer to you shortly.')); ?></div>
  
  
    </div>
  </section>
  <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\aicms.test\resources\views/pages/showParent.blade.php ENDPATH**/ ?>