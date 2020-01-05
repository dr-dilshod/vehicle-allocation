<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'vehicle_id' => $this->vehicle_id,
            'vehicle_no' => $this->vehicle_no,
            'company_name' => $this->company_name,
            'company_kana_name' => $this->company_kana_name,
            'vehicle_company_abbreviation' => $this->vehicle_company_abbreviation,
            'vehicle_postal_code' => $this->vehicle_postal_code,
            'vehicle_address1' => $this->vehicle_address1,
            'vehicle_address2' => $this->vehicle_address2,
            'vehicle_phone_number' => $this->vehicle_phone_number,
            'vehicle_fax_number' => $this->vehicle_fax_number,
            'offset' => $this->offset,
            'vehicle_remark' => $this->vehicle_remark,
        ];
    }
}
