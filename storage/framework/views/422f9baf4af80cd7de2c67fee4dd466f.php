

<?php $__env->startSection('title', $review->title ?? 'Default Title'); ?>

<?php $__env->startSection('content'); ?>

<section>
    <div class="bg-search-welcome bg-no-repeat bg-cover w-full p-5"> <!-- Hero Section -->
        <div class="w-full xl:w-1/2 mx-auto m-auto text-center flex"> <!-- Container Box -->
            <h1 class="text-2xl w-full text-white"><?php echo e(__('Location Review')); ?></h1>
        </div>
    </div>
</section>
<section class="antialiased bg-white  p-10">
    <h1 class="text-4xl mb-10 text-site-blue-dark text-center"><?php echo e($review->title); ?></h1>

    <div class="flex flex-col md:flex-row w-4/5 sm:w-full 2xl:w-3/5 mx-auto">
        <!-- Left Column (60% on larger screens, 100% on mobile) -->
        <div class="bodycontent w-full lg:w-4/6 p-4">
            <?php echo $processedContent; ?>

        </div>


        <!-- Right Column (40% on larger screens, 100% on mobile) -->
        <div class="w-full lg:w-2/6 p-4 ">
            <div class="rounded-lg overflow-hidden shadow">
                <!-- Blue Header -->
                <div class="bg-cyan-500 text-white text-center p-6">
                    <?php echo e($review->why); ?>

                </div>
                <!-- Body with padding of 1.5rem -->
                <div class="p-12 flex-col">
                    <?php if($review && $review->tips->count() > 0): ?>
                    <?php $__currentLoopData = $review->tips->where('type', 'why'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <!-- Header with SVG and h3 -->
                        <header class="flex flex-row mb-2">
                            <div>
                                <img src="<?php echo e($tip->icon); ?>" alt="<?php echo e($tip->title); ?>" class="align-top w-4 h-4 mr-2">
                            </div>
                            <!-- Title with a slight negative margin on top -->
                            <h3 class="text-md font-semibold leading-snug pl-1 -mt-1"><?php echo e($tip->title); ?></h3>
                        </header>

                        <!-- Content -->
                        <div class="mb-8 pl-7 text-xs"><!-- Added padding-left -->
                            <p><?php echo e($tip->body); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>




    </div>


</section>
<?php if($review && $review->tips->where('type', 'usefultip')->count() > 0): ?>
<section class="antialiased bg-site-bg-gray p-10">
    <div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        <?php $__currentLoopData = $review->tips->where('type', 'usefultip'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
            <a href="#" class="hover-group">
                <div class="p-6">
                    <!-- Card body -->
                    <div>
                        <header class="relative flex items-center mb-2"> <!-- Added relative positioning for header -->
                            <div style="margin-left: -0.5rem; position: absolute; left: 0;"> <!-- SVG container with negative margin and absolute positioning -->
                            <img src="<?php echo e($tip->icon); ?>" alt="<?php echo e($tip->title); ?>" class="align-top w-5 h-5 mr-2">
                            </div>
                            <!-- Title -->
                            <?php if($tip->title): ?><h3 class="text-[22px] text-cyan-500 font-semibold leading-snug pl-4"><?php echo e($tip->title); ?></h3><?php endif; ?>
                        </header>
                        <!-- Content -->
                        <div class="mb-8 pl-4 text-sm"> <!-- Added padding-left -->
                            <p><?php echo e($tip->body); ?></p>
                        </div>
                    </div>
                    <!-- Card footer -->
                </div>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php endif; ?>


<section class="antialiased bg-gray-50  p-12">
    <div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto bodycontent">

    <?php if($review->media->first()): ?>
    <figure class="relative h-0 pb-[36.25%] overflow-hidden mb-8 rounded">
    <img class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" src="<?php echo e($review->media->first()->getUrl()); ?>" alt="<?php echo e($review->media->first()->custom_properties['name'] ?? ''); ?>">

        </figure>
    <?php endif; ?>    


        <?php echo $review->text; ?>

    </div>
</section>

<!-- Snippet -->
<section class="bg-site-bg-gray">
    <div class="w-3/4 lg:w-1/2 mx-auto">
        <div class="text-4xl mb-5 text-site-blue-dark text-center pt-10"><?php echo e(__('Frequently Asked Questions (FAQ)')); ?></div>
        <div class="faq-box">
            <?php if($review && $review->faqs->count() > 0): ?>
            <?php $__currentLoopData = $review->faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="faq-item mb-4 rounded-xl border-2 border-site-border-faq bg-white">
                <div class="faq-question cursor-pointer flex justify-between items-center p-4">
                    <span class="text-site-blue-ligter font-medium text-xl"><?php echo e($loop->iteration); ?>. <?php echo e($faq->question); ?></span>
                    <svg class="faq-arrow stroke-site-blue-ligter" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                        <path d="M6 9L12 15L18 9" stroke="#0D87C6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div class="faq-answer-wrapper overflow-hidden max-h-0 transition-all duration-300">
                    <div class="faq-answer p-4 text-gray-500">
                        <?php echo e($faq->answer); ?>

                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>


        </div>

        <div class="text-2xl mt-8 mb-4 text-gray-500 text-center"><?php echo e(__('Still have a question?')); ?></div>
        <div class="text-base text-gray-500 text-center pb-10"><?php echo e(__('If you can not find answer to your question in our FAQ, you can always contact us. We Will answer to you shortly.')); ?></div>


    </div>
</section>





<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\aicms.test\resources\views\review\twoColumns.blade.php ENDPATH**/ ?>