<?php

namespace App\Mappers;

class PhillipsPetApi
{


    public function getApiToDatabaseMapperKeys($item)
    {

        $map_key = [
            'CaseQty' => 'quantity',
            'Cat1',
            'Cat2',
            'Cat3',
            'InStock',
            'PartNumber',
            'Price1',
            'Price2',
            'PrimaryAnimal',
            'PromoEndDate',
            'PromoPrice1',
            'PromoPrice2',
            'ShortDesc',
            'UOM1',
            'UOM2',
            'UPC1',
            'UPC2',
            'VendorName',
            'Weight1',
            'Weight2'
        ];

    }
}
