<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author      InvoicePlane Developers & Contributors
 * @copyright   Copyright (c) 2012 - 2017 InvoicePlane.com
 * @license     https://invoiceplane.com/license.txt
 * @link        https://invoiceplane.com
 */

/**
 * Class Guest
 */
class Get extends Base_Controller
{
    public function attachment($filename)
    {
        $path = UPLOADS_FOLDER . 'customer_files/';
        $filePath = $path . $filename;

        if (strpos(realpath($filePath), $path) !== 0) {
            header("Status: 403 Forbidden");
            echo '<h1>Forbidden</h1>';
            exit;
        }

        $filePath = realpath($filePath);

        if (file_exists($filePath)) {
            $pathParts = pathinfo($filePath);
            $fileExt = $pathParts['extension'];
            $fileSize = filesize($filePath);

            $save_ctype = isset($this->content_types[$fileExt]);
            $ctype = $save_ctype ? $this->content_types[$fileExt] : $this->ctype_default;

            header("Expires: -1");
            header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: " . $ctype);
            header("Content-Length: " . $fileSize);

            echo file_get_contents($filePath);
            exit;
        }

        show_404();
        exit;
    }

}
