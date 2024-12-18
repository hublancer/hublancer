<?php

namespace App\Controllers;

use App\Models\FileModel;
use App\Models\OrderAdminModel;
use App\Models\OrderModel;
use App\Models\ProductAdminModel;
use App\Models\ProductModel;
use Config\Globals;

class FileController extends BaseController
{
    protected $fileModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->fileModel = new FileModel();
        if (!authCheck()) {
            exit();
        }
    }

    /**
     * Upload Image
     */
    public function uploadImage()
    {
        $this->fileModel->uploadImage();
    }

    /**
     * Upload Image Session
     */
    public function uploadImageSession()
    {
        $this->fileModel->uploadImageSession();
    }

    /**
     * Get Uploaded Image Session
     */
    public function getSessUploadedImage()
    {
        $fileId = inputPost('file_id');
        $images = $this->fileModel->getSessProductImagesArray();
        $data = array();
        if (!empty($images)) {
            foreach ($images as $image) {
                if ($image->file_id == $fileId) {
                    $data['imageHtml'] = '<img src="' . base_url() . "/uploads/temp/" . $image->img_small . '" alt="">' .
                        '<a href="javascript:void(0)" class="btn-img-delete btn-delete-product-img-session" data-file-id="' . $image->file_id . '"><i class="icon-close"></i></a>' .
                        '<a href="javascript:void(0)" class="btn btn-xs btn-secondary btn-is-image-main btn-set-image-main-session" data-file-id="' . $image->file_id . '">' . trans("main") . '</a>';
                    break;
                }
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Get Uploaded Image
     */
    public function getUploadedImage()
    {
        $imageId = inputPost('image_id');
        $image = $this->fileModel->getImage($imageId);
        if (!empty($image)) {
            echo '<img src="' . getProductImageURL($image, 'image_small') . '" alt="">' .
                '<a href="javascript:void(0)" class="btn-img-delete btn-delete-product-img" data-file-id="' . $image->id . '"><i class="icon-close"></i></a>' .
                '<a href="javascript:void(0)" class="btn btn-xs btn-secondary btn-is-image-main btn-set-image-main" data-image-id="' . $image->id . '" data-product-id="' . $image->product_id . '">' . trans("main") . '</a>';
        }
    }

    /**
     * Set Main Image Session
     */
    public function setImageMainSession()
    {
        $imageId = inputPost('file_id');
        $this->fileModel->setSessImageMain($imageId);
    }

    /**
     * Set Main Image
     */
    public function setImageMain()
    {
        $imageId = inputPost('image_id');
        $productId = inputPost('product_id');
        $this->fileModel->setImageMain($imageId, $productId);
    }

    /**
     * Delete Image Session
     */
    public function deleteImageSession()
    {
        $fileId = inputPost('file_id');
        $this->fileModel->deleteImageSession($fileId);
    }

    /**
     * Delete Image
     */
    public function deleteImage()
    {
        $imageId = inputPost('file_id');
        $image = $this->fileModel->getImage($imageId);
        if (!empty($image)) {
            if ($this->productSettings->is_product_image_required == 1 && countItems(getProductImages($image->product_id)) <= 1) {
                setErrorMessage(trans("error_product_image_delete"));
                exit();
            }
            $this->fileModel->deleteProductImage($image->id);
        }
        return false;
    }

    /**
     * --------------------------------------------------------------------------
     * File Manager Image Upload
     * --------------------------------------------------------------------------
     */

    //upload file manager image
    public function uploadFileManagerImagePost()
    {
        $this->fileModel->uploadFileManagerImage();
        exit();
    }

    //get file manager images
    public function getFileManagerImages()
    {
        $data = [
            'result' => 0,
            'content' => ''
        ];
        $images = $this->fileModel->getUserFileManagerImages(user()->id);
        if (!empty($images)) {
            foreach ($images as $image) {
                $data['content'] .= '<div class="col-file-manager" id="fm_img_col_id_' . $image->id . '">';
                $data['content'] .= '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . getFileManagerImageUrl($image) . '">';
                $data['content'] .= '<div class="image-container">';
                $data['content'] .= '<img src="' . getFileManagerImageUrl($image) . '" alt="" class="img-responsive">';
                $data['content'] .= '</div></div> </div>';
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    //delete file manager image
    public function deleteFileManagerImage()
    {
        $fileId = inputPost('file_id');
        $this->fileModel->deleteFileManagerImage($fileId, user()->id);
    }

    /**
     * --------------------------------------------------------------------------
     * Blog Image Upload
     * --------------------------------------------------------------------------
     */

    //upload blog image
    public function uploadBlogImage()
    {
        $this->fileModel->uploadBlogImage();
    }

    //get blog images
    public function getBlogImages()
    {
        $data = [
            'result' => 0,
            'content' => ''
        ];
        $images = $this->fileModel->getBlogImages(60);
        if (!empty($images)) {
            foreach ($images as $image) {
                $data['content'] .= '<div class="col-file-manager" id="file_manager_col_id_' . $image->id . '">';
                $data['content'] .= '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . getBlogFileManagerImage($image) . '">';
                $data['content'] .= '<div class="image-container">';
                $data['content'] .= '<img src="' . getBlogFileManagerImage($image) . '" alt="" class="img-responsive">';
                $data['content'] .= '</div></div> </div>';
                helperSetSession('fm_last_ckimg_id', $image->id);
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    //load more blog images
    public function loadMoreBlogImages()
    {
        $min = inputPost('min');
        $data = [
            'result' => 0,
            'content' => ''
        ];
        $images = $this->fileModel->loadMoreBlogImages($min, 60);
        if (!empty($images)) {
            foreach ($images as $image) {
                $data['content'] .= '<div class="col-file-manager" id="file_manager_col_id_' . $image->id . '">';
                $data['content'] .= '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . getBlogFileManagerImage($image) . '">';
                $data['content'] .= '<div class="image-container">';
                $data['content'] .= '<img src="' . getBlogFileManagerImage($image) . '" alt="" class="img-responsive">';
                $data['content'] .= '</div></div> </div>';
                helperSetSession('fm_last_ckimg_id', $image->id);
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    //delete blog image
    public function deleteBlogImage()
    {
        $id = inputPost('file_id');
        $this->fileModel->deleteBlogImage($id);
    }

    /**
     * --------------------------------------------------------------------------
     * Digital Files Upload
     * --------------------------------------------------------------------------
     */

    //upload digital files
    public function uploadDigitalFile()
    {
        $productId = inputPost('product_id');
        $this->fileModel->uploadDigitalFile($productId);
        $vars = ['product' => getProduct($productId)];
        $htmlContent = view('dashboard/product/_digital_files_upload_response', $vars);
        $data = [
            'result' => 1,
            'htmlContent' => $htmlContent,
        ];
        echo json_encode($data);
        exit();
    }

    //delete digital file
    public function deleteDigitalFile()
    {
        $fileId = inputPost('file_id');
        $file = $this->fileModel->getDigitalFile($fileId);
        if (!empty($file)) {
            if ($this->fileModel->deleteDigitalFile($file->id)) {
                $htmlContent = view('dashboard/product/_digital_files_upload_response', ['product' => getProduct($file->product_id)]);
                echo json_encode(['result' => 1, 'htmlContent' => $htmlContent]);
            }
        }
    }

    //download purchased digital file
    public function downloadPurchasedDigitalFile()
    {
        if (!authCheck()) {
            return redirect()->to()->back();
        }
        $saleId = inputPost('sale_id');
        $sale = $this->productModel->getDigitalSale($saleId);
        if (!empty($sale)) {
            if ($sale->buyer_id == user()->id) {
                $submit = inputPost('submit', true);
                if ($submit == 'license_certificate') {
                    $this->fileModel->createLicenseKeyFile($sale);
                } else {
                    $file = $this->fileModel->getProductDigitalFile($sale->product_id);
                    if (!empty($file)) {
                        $path = FCPATH . 'uploads/digital-files/' . $file->file_name;
                        if (file_exists($path)) {
                            return $this->response->download($path, null);
                        }
                    }
                }
            }
        }
        return redirect()->back();
    }

    //download digital file
    public function downloadDigitalFile()
    {
        $fileId = inputPost('file_id');
        $file = $this->fileModel->getDigitalFile($fileId);
        if (!empty($file) && ($file->user_id == user()->id || hasPermission('products'))) {
            $path = FCPATH . 'uploads/digital-files/' . $file->file_name;
            if (file_exists($path)) {
                return $this->response->download($path, null);
            }
        }
        redirectToBackUrl();
    }

    //download free digital file
    public function downloadFreeDigitalFile()
    {
        $productId = inputPost('product_id');
        $product = getProduct($productId);
        if (!empty($product) && $product->is_free_product == 1) {
            $file = $this->fileModel->getProductDigitalFile($productId);
            if (!empty($file)) {
                $path = FCPATH . 'uploads/digital-files/' . $file->file_name;
                if (file_exists($path)) {
                    return $this->response->download($path, null);
                }
            }
        }
        redirectToBackUrl();
    }

    /**
     * --------------------------------------------------------------------------
     * Video Upload
     * --------------------------------------------------------------------------
     */

    //upload video
    public function uploadVideo()
    {
        $productId = inputPost('product_id');
        $this->fileModel->uploadVideo($productId);
        echo $productId;
    }

    //load video preview
    public function loadVideoPreview()
    {
        $productId = inputPost('product_id');
        $data['product'] = getProduct($productId);
        $data['productVideo'] = $this->fileModel->getProductVideo($productId);
        echo view('dashboard/product/_video_upload_response', $data);
    }

    //delete video
    public function deleteVideo()
    {
        $productId = inputPost('product_id');
        $this->fileModel->deleteVideo($productId);
        $data['product'] = getProduct($productId);
        echo view('dashboard/product/_video_upload_response', $data);
    }

    /**
     * --------------------------------------------------------------------------
     * Audio Upload
     * --------------------------------------------------------------------------
     */

    //upload audio
    public function uploadAudio()
    {
        $productId = inputPost('product_id');
        $this->fileModel->uploadAudio($productId);
        echo $productId;
    }

    //load audio preview
    public function loadAudioPreview()
    {
        $productId = inputPost('product_id');
        $data['product'] = getProduct($productId);
        $data['audio'] = $this->fileModel->getProductAudio($productId);
        $data['productAudio'] = $this->fileModel->getProductAudio($productId);
        echo view('dashboard/product/_audio_upload_response', $data);
    }

    //delete audio
    public function deleteAudio()
    {
        $productId = inputPost('product_id');
        $this->fileModel->deleteAudio($productId);
        $data['product'] = getProduct($productId);
        echo view('dashboard/product/_audio_upload_response', $data);
    }

    /**
     * Export Table Data Post
     */
    public function exportTableDataPost()
    {
        loadLibrary('Export');
        $langId = inputPost('lang_id');
        $language = getLanguage($langId);
        $isRTL = false;
        if (!empty($language)) {
            Globals::setActiveLanguage($language->id);
            if ($language->text_direction == 'rtl') {
                $isRTL = true;
            }
        }
        $dataExportType = inputPost('data_export_type');
        $dataExportFileType = inputPost('data_export_file_type');
        if ($dataExportFileType != 'excel' && $dataExportFileType != 'csv' && $dataExportFileType != 'xml') {
            $dataExportFileType = 'excel';
        }
        $fileName = '';
        $fields = array();
        $rows = array();
        if ($dataExportType == 'products') {
            $list = inputPost('list');
            if ($list == 'edited') {
                $list = 'edited_products';
            } elseif ($list == 'special') {
                $list = 'special_offers';
            } elseif ($list == 'pending') {
                $list = 'pending_products';
            } elseif ($list == 'hidden') {
                $list = 'hidden_products';
            } elseif ($list == 'expired') {
                $list = 'expired_products';
            } elseif ($list == 'sold') {
                $list = 'sold_products';
            } elseif ($list == 'deleted') {
                $list = 'deleted_products';
            } elseif (empty($list)) {
                $list = 'featured_products';
            }
            if (!empty($list)) {
                $fileName = trans($list);
            } else {
                $fileName = 'products';
            }
            $model = new ProductAdminModel();
            $fields = ['id', 'title', 'slug', 'listing_type', 'product_type', 'sku', 'category_id', 'category_name', 'price', 'price_discounted', 'discount_rate', 'currency', 'vat_rate', 'user_id', 'username', 'stock', 'is_promoted', 'promote_start_date', 'promote_end_date', 'purchased_plan', 'is_special_offer', 'demo_url', 'external_link', 'pageviews', 'rating', 'visibility', 'status', 'location', 'short_description', 'description', 'tags', 'images', 'date'];
            $rows = $model->getFilteredProductsExport($list);
        } elseif ($dataExportType == 'orders') {
            $model = new OrderAdminModel();
            $fileName = 'orders';
            $fields = ['order', 'buyer_id', 'buyer_name', 'buyer_type', 'subtotal', 'vat', 'shipping_cost', 'total', 'currency', 'coupon_code', 'coupon_discount', 'transaction_fee', 'payment_method', 'payment_status', 'status', 'products', 'updated', 'date'];
            $rows = $model->getFilteredOrdersExport();
        } elseif ($dataExportType == 'transactions') {
            $model = new OrderAdminModel();
            $fileName = 'transactions';
            $fields = ['id', 'order', 'payment_method', 'payment_id', 'user_id', 'username', 'user_type', 'payment_amount', 'currency', 'payment_status', 'ip_address', 'date'];
            $rows = $model->getTransactionsExport();
        } elseif ($dataExportType == 'digital_sales') {
            $model = new OrderAdminModel();
            $fileName = 'Digital Sales';
            $fields = ['id', 'order', 'purchase_code', 'seller_id', 'seller_name', 'buyer_id', 'buyer_name', 'total', 'currency', 'date'];
            $rows = $model->getDigitalSalesExport();
        }

        $export = new \Export($fields, $rows, $fileName, $dataExportType, $isRTL);
        if ($dataExportFileType == 'excel') {
            $export->exportAsExcel();
        } elseif ($dataExportFileType == 'csv') {
            $export->exportAsCsv();
        } elseif ($dataExportFileType == 'xml') {
            $export->exportAsXml();
        }
        redirectToBackUrl();
    }
}
