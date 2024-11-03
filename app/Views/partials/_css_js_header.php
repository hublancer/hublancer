<?php $clr = $generalSettings->site_color; ?>
<style>:root {--vr-color-main: <?= $generalSettings->site_color; ?>;} <?php if(!empty($indexBannersArray)):foreach ($indexBannersArray as $bannerSet):foreach ($bannerSet as $banner):?>.index_bn_<?= $banner->id;?> {-ms-flex: 0 0 <?= $banner->banner_width;?>%;flex: 0 0 <?= $banner->banner_width;?>%;max-width: <?= $banner->banner_width;?>%;}<?php endforeach; endforeach; endif; ?>
    <?php if (!empty($adSpaces)):foreach ($adSpaces as $item):if (!empty($item->desktop_width) && !empty($item->desktop_height)): echo '.bn-ds-'.$item->id. '{width: ' . $item->desktop_width . 'px; height: ' . $item->desktop_height . 'px;}'; echo '.bn-mb-'.$item->id. '{width: ' . $item->mobile_width . 'px; height: ' . $item->mobile_height . 'px;}';endif;endforeach;endif; ?> .nav-mobile-header .flex-item-left, .nav-mobile-header .flex-item-right{ width: 100px;}.nav-mobile-header .flex-item-mid{width: calc(100% - 200px);}
</style>
<script>var MdsConfig = {baseURL: '<?= base_url(); ?>', langBaseURL: "<?= langBaseUrl(); ?>", isloggedIn: "<?= authCheck(); ?>", sysLangId: "<?= $activeLang->id; ?>", langShort: "<?= $activeLang->short_form; ?>", thousandsSeparator: "<?= $baseVars->thousandsSeparator; ?>", csrfTokenName: '<?= csrf_token() ?>', chatUpdateTime: '<?= CHAT_UPDATE_TIME; ?>', reviewsLoadLimit: '<?= REVIEWS_LOAD_LIMIT; ?>', commentsLoadLimit: '<?= COMMENTS_LOAD_LIMIT; ?>', textAll: "<?= clrQuotes(trans("all")); ?>", textNoResultsFound: "<?= clrQuotes(trans("no_results_found")); ?>", textOk: "<?= clrQuotes(trans("ok")); ?>", textCancel: "<?= clrQuotes(trans("cancel")); ?>", textAcceptTerms: "<?= clrQuotes(trans("msg_accept_terms")); ?>", cartRoute: "<?= !empty($this->routes) && !empty($this->routes->cart) ? $this->routes->cart : ''; ?>", sliderFadeEffect: "<?= $generalSettings->slider_effect == 'fade' ? '1' : '0'; ?>", isRecaptchaEnabled: "<?= !empty($baseVars->recaptchaStatus) ? '1' : '0'; ?>", rtl: <?= $baseVars->rtl ? 'true' : 'false'; ?>, textAddtoCart: "<?= clrQuotes(trans("add_to_cart")); ?>", textAddedtoCart: "<?= clrQuotes(trans("added_to_cart")); ?>", textCopyLink: "<?= clrQuotes(trans("copy_link")); ?>", textCopied: "<?= clrQuotes(trans("copied")); ?>", textAddtoWishlist: "<?= clrQuotes(trans("add_to_wishlist")); ?>", textRemoveFromWishlist: "<?= clrQuotes(trans("remove_from_wishlist")); ?>"};</script>