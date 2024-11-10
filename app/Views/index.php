 <div class="section-slider">
    <?php if (!empty($sliderItems) && $generalSettings->slider_status == 1):
        echo view('partials/_main_slider');
    endif; ?> 
</div>  
    <div class="container">
        <div class="row">   
        
<button type="button" data-toggle="modal" data-target="#locationModal" class="nav-link btn-modal-location button-link btn-modal-location-header display-flex align-items-center" aria-label="location-modal">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="#888888">
<path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
</svg>&nbsp;<?= !empty($baseVars->defaultLocationInput) ? $baseVars->defaultLocationInput : trans("location"); ?>
</button>      
        <div class="top-search-bar">
<form action="<?= generateUrl('products'); ?>" method="get" id="form_validate_search" class="form_search_main">
<input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search_main" class="form-control input-search" placeholder="<?= trans("search_products_categories_brands"); ?>" required autocomplete="off">
<button class="btn btn-default btn-search" aria-label="search"><i class="icon-search"></i></button>
<div id="response_search_results" class="search-results-ajax mds-scrollbar"></div>
</form>
</div> 
<br>
            <h1 class="index-title"><?= esc($baseSettings->site_title); ?></h1>
            <?php if (countItems($featuredCategories) > 0 && $generalSettings->featured_categories == 1):
               echo view('product/_index_banners', ['bannerLocation' => 'featured_categories']);
              echo view('partials/_featured_categories');
            endif;
           
            echo view('partials/_ad_spaces', ['adSpace' => 'index_1', 'class' => 'mb-3']);
            echo view('product/_special_offers', ['specialOffers' => $specialOffers]);
            echo view("product/_index_banners", ['bannerLocation' => 'special_offers']);
            if ($generalSettings->index_promoted_products == 1 && $generalSettings->promoted_products == 1 && !empty($promotedProducts)): ?>
                <div class="col-12 section section-promoted">
                    <?= view('product/_featured_products'); ?>
                </div>
            <?php endif;
            echo view('product/_index_banners', ['bannerLocation' => 'featured_products']);
            if ($generalSettings->index_latest_products == 1 && !empty($latestProducts)): ?>
                <div class="col-12 section section-latest-products">
                    <div class="section-header display-flex justify-content-between">
                        <h3 class="title"><a href="<?= generateUrl('products'); ?>"><?= trans("new_arrivals"); ?></a></h3>
                        <a href="<?= generateUrl('products'); ?>" class="font-600"><?= trans("view_all"); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="row row-product">
                        <?php foreach ($latestProducts as $item): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                <?= view('product/_product_item', ['product' => $item, 'promotedBadge' => false, 'isSlider' => 0, 'discountLabel' => 0]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;
            echo view('product/_index_banners', ['bannerLocation' => 'new_arrivals']);
            echo view('partials/_ad_spaces', ['adSpace' => 'index_2', 'class' => 'mb-3']);
            echo view('product/_index_category_products', ['indexCategories' => $indexCategories]);
            ?>

            <?php if ($productSettings->brand_status == 1 && !empty($brands)): ?>
                <div class="col-12 section section-blog m-0">
                    <div class="section-header section-header-slider">
                        <h3 class="title"><?= trans("shop_by_brand"); ?></h3>
                        <div class="section-slider-nav" id="brand-slider-nav">
                            <button class="prev" aria-label="btn-prev-brand"><i class="icon-arrow-left"></i></button>
                            <button class="next" aria-label="btn-next-brand"><i class="icon-arrow-right"></i></button>
                        </div>
                    </div>
                    <div class="brand-slider-container" <?= $baseVars->rtl == true ? 'dir="rtl"' : ''; ?>>
                        <div id="brand-slider" class="brand-slider">
                            <?php foreach ($brands as $item):
                                if (!empty($item->image_path)):?>
                                    <a href="<?= generateUrl('products'); ?>?brand=<?= $item->id; ?>">
                                        <div class="brand-item">
                                            <div class="item">
                                                <img src="<?= IMG_BASE64_1x1; ?>" data-lazy="<?= base_url($item->image_path); ?>" alt="<?= getBrandName($item->name_data, selectedLangId()); ?>" width="216" height="104"/>
                                            </div>
                                        </div>
                                    </a>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($generalSettings->index_blog_slider == 1 && !empty($blogSliderPosts)): ?>
                <div class="col-12 section section-blog m-0">
                    <div class="section-header section-header-slider">
                        <h3 class="title"><a href="<?= generateUrl('blog'); ?>"><?= trans("latest_blog_posts"); ?></a></h3>
                        <div class="section-slider-nav" id="blog-slider-nav">
                            <button class="prev" aria-label="btn-prev-blog"><i class="icon-arrow-left"></i></button>
                            <button class="next" aria-label="btn-next-blog"><i class="icon-arrow-right"></i></button>
                        </div>
                    </div>
                    <div class="row-custom">
                        <div class="blog-slider-container">
                            <div id="blog-slider" class="blog-slider">
                                <?php foreach ($blogSliderPosts as $item):
                                    echo view('blog/_blog_item', ['item' => $item]);
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= view('partials/_json_ld', ['jLDType' => 'index']); ?>
