<?php

use app\Settings\GeneralSettings;
$settings = app(GeneralSettings::class);

?>



<?php $__env->startSection('meta'); ?>

<?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo','data' => ['title' => $page->meta_title ?: $page->title ?: $settings->default_siteTitle[app()->getLocale()],'description' => $page->meta_description ?: $settings->default_siteDescription[app()->getLocale()],'titleog' => $page->og_title ?: $page->title ?: $settings->default_siteTitle[app()->getLocale()],'imageog' => $page->cover_og_url ?: $page->cover_url ?: asset('images/logo.png')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('seo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->meta_title ?: $page->title ?: $settings->default_siteTitle[app()->getLocale()]),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->meta_description ?: $settings->default_siteDescription[app()->getLocale()]),'titleog' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->og_title ?: $page->title ?: $settings->default_siteTitle[app()->getLocale()]),'imageog' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->cover_og_url ?: $page->cover_url ?: asset('images/logo.png'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
<?php if($page && $page->faqs->count() > 0): ?>
<?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.faq-schema','data' => ['faqs' => $page->faqs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('faq-schema'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['faqs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page->faqs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.artical-schema','data' => ['page' => $page]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('artical-schema'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section>
    <div class="bg-search-welcome bg-no-repeat  bg-cover w-full p-5"> <!-- Hero Section -->
        <div class="md:flex-row w-4/5 sm:w-full 2xl:w-3/5 mx-auto"> <!-- Container Box -->
        <h1 class="text-4xl text-white text-center"><?php echo e($page->title); ?></h1>
        
        <div class="flex justify-center items-center text-sm mt-2 text-white space-x-3">
            <span>By <a href="<?php echo e(route('showAuthor', ['slug' => $page->user->slug])); ?>" class="underline hover:no-underline"><?php echo e($page->user->name); ?></a></span>
            <span class="w-2 h-2 rounded-full bg-white"></span>
            <?php if(strtotime($page->updated_at) > strtotime($page->published_at)): ?>
                <span>Updated on <?php echo e(date('F Y, d', strtotime($page->updated_at))); ?></span>
                <?php else: ?>
                <span>Published on <?php echo e(date('F Y, d', strtotime($page->published_at))); ?></span>
                <?php endif; ?>
        </div>
        </div>
    </div>
</section>
<section class="antialiased bg-white  p-10">

    <div class="flex flex-col md:flex-row w-4/5 sm:w-full 2xl:w-3/5 mx-auto">
        <!-- Left Column (60% on larger screens, 100% on mobile) -->
        <div class="bodycontent w-full p-4">
            <?php echo $processedContent; ?>

        </div>
    </div>
</section>
<?php if($page && $page->tips->where('type', 'question')->count() > 0): ?>
<section class="antialiased bg-site-bg-gray p-10">
    <div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        <?php $__currentLoopData = $page->tips->where('type', 'question'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

    <?php if($page->media->first()): ?>
    <figure class="relative h-0 pb-[36.25%] overflow-hidden mb-8 rounded">
    <img class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" src="<?php echo e($page->media->first()->getUrl('bigThumb')); ?>" alt="<?php echo e($page->media->first()->custom_properties['alt'] ?? ''); ?>">

        </figure>
    <?php endif; ?>    


        <?php echo $page->text; ?>

    </div>
</section>

<!-- Snippet -->
<section class="bg-site-bg-gray">
    <div class="w-3/4 lg:w-1/2 mx-auto">
        <div class="text-4xl mb-5 text-site-blue-dark text-center pt-10"><?php echo e(__('Frequently Asked Questions (FAQ)')); ?></div>
        <div class="faq-box">
            <?php if($page && $page->faqs->count() > 0): ?>
            <?php $__currentLoopData = $page->faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8.1\htdocs\aicms.test\resources\views/pages/ChildOneColumns.blade.php ENDPATH**/ ?>