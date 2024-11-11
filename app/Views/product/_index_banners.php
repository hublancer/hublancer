<?php if (!empty($indexBannersArray) && !empty($bannerLocation) && !empty($indexBannersArray[$bannerLocation])): ?>
    <!-- Laptop View: Visible on screens larger than 768px -->
    <div class="col-12 section section-index-bn laptop-view">
        <div class="row">
            <?php foreach ($indexBannersArray[$bannerLocation] as $banner):
                $width = 1000;
                $height = 400;
                if ($banner->banner_width < 100 && $banner->banner_width >= 50) {
                    $width = 635;
                    $height = 332;
                } elseif ($banner->banner_width < 50) {
                    $width = 417;
                    $height = 218;
                }
                if ($banner->banner_location == $bannerLocation): ?>
                    <div class="col-6 col-index-bn index_bn_<?= $banner->id; ?>">
                        <a href="<?= $banner->banner_url; ?>">
                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= base_url($banner->banner_image_path); ?>" alt="banner" width="<?= $width; ?>" height="<?= $height; ?>" class="lazyload img-fluid" style="border-radius: 20px;">
                        </a>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
    </div>

    <!-- Mobile View: Visible on screens smaller than 768px, displaying only one banner -->
    <div class="col-12 section section-index-bn mobile-view">
        <div class="row">
            <?php if (isset($indexBannersArray[$bannerLocation][0])): // Display only the first banner ?>
                <?php $banner = $indexBannersArray[$bannerLocation][0];
                $width = 417;
                $height = 218; ?>
                <div class="col-12 col-index-bn index_bn_<?= $banner->id; ?>">
                    <a href="<?= $banner->banner_url; ?>">
                        <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= base_url($banner->banner_image_path); ?>" alt="banner" width="<?= $width; ?>" height="<?= $height; ?>" class="lazyload img-fluid" style="border-radius: 20px;">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<style>
    /* CSS for Responsive Visibility */
    .laptop-view {
        display: block;
    }
    .mobile-view {
        display: none;
    }

    @media (max-width: 768px) {
        .laptop-view {
            display: none;
        }
        .mobile-view {
            display: block;
        }
    }
</style>
