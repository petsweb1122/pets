<?php

namespace App\Helpers;

use Form;

class ProductSizeHelper
{

    public function getSizeHtml($find_size, $v_pro = null)
    {

        $size_id = $find_size->size_id;

        $html = '<div class="row parent-size-data">';

        $html .= '<div class="col-md-12"><b>Size - ' . $find_size->size_id . ' : ' . $find_size->value . '</b> <span data-delete_id="' . $find_size->size_id . '" class="delete_this_size pull-right" style="font-size:18px;cursor:pointer;" ><i class="fa fa-trash text-danger"></i></span> <hr></div>';

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_sku', 'Sku:', !empty($v_pro->variation_sku) ? $v_pro->variation_sku : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_upc', 'UPC: ', !empty($v_pro->variation_upc) ? $v_pro->variation_upc : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getNumberField('size_' . $size_id . '_qty', 'Quantity: ', !empty($v_pro->variation_quantity) ? $v_pro->variation_quantity : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_mfn', 'Manufacturer No: ', !empty($v_pro->manufacturer_no) ? $v_pro->manufacturer_no : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getNumberField('size_' . $size_id . '_vprice', 'Vendor Price:', !empty($v_pro->v_price) ? $v_pro->v_price : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getNumberField('size_' . $size_id . '_sprice', 'Sale Price:', !empty($v_pro->s_price) ? $v_pro->s_price : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getNumberField('size_' . $size_id . '_rprice', 'Regular Price: ', !empty($v_pro->r_price) ? $v_pro->r_price : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getSelectField('size_' . $size_id . '_sale', 'Is Sale: ', ['' => 'Select Value', 'no' => 'No', 'yes' => 'Yes'], !empty($v_pro->sale) ? $v_pro->sale : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_length', 'Length: ', !empty($v_pro->length) ? $v_pro->length : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_width', 'Width: ', !empty($v_pro->width) ? $v_pro->width : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_height', 'Height: ', !empty($v_pro->height) ? $v_pro->height : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_product_size', 'Product Size Detail: ', !empty($v_pro->product_size) ? $v_pro->product_size : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_discount_percent', 'Discount %age: ', !empty($v_pro->discount_percent) ? $v_pro->discount_percent : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getTextField('size_' . $size_id . '_discount_price', 'Discount Price: ', !empty($v_pro->discount_price) ? $v_pro->discount_price : '');
        $html .= "</div>";

        $html .= '<div class="form-group col-md-3 input-group-sm">';
        $html .= $this->getSelectField('size_' . $size_id . '_discount_apply_on', 'Discount Apply On: ', ['percent' => 'Percent', 'price' => 'Price'], !empty($v_pro->discount_apply) ? $v_pro->discount_apply : '');
        $html .= "</div>";

        $html .= "</div>";

        return $html;
    }

    private function getTextField($name, $title, $selected = '')
    {
        $html = Form::label($name, $title, ['class' => 'col-form-label']);
        $html .= Form::text(
            $name,
            !empty($selected) ? $selected : '',
            [
                'class' => "form-control form-control-sm ",
                'id' => $name
            ]
        );
        return $html;
    }
    private function getNumberField($name, $title, $selected = '')
    {
        $html = Form::label($name, $title, ['class' => 'col-form-label']);
        $html .= Form::number(
            $name,
            !empty($selected) ? $selected : '',
            [
                'class' => "form-control form-control-sm ",
                'id' => $name
            ]
        );
        return $html;
    }

    private function getSelectField($name, $title, $data, $selected = '')
    {

        $html = Form::label($name, $title, ['class' => 'col-form-label']);
        $html .= Form::select(
            $name,
            $data,
            !empty($selected) ? $selected : '',
            [
                'class' => "form-control form-control-sm ",
                'id' => $name
            ]
        );
        return $html;
    }
}
