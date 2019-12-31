/**
 * Created by Muzaffar on 26.12.2019.
 */
$(document).ready(function(){
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/vehicle-fetch',
        columns: [
            { data: 'subcontract_id', name: 'subcontract_id' },
            { data: 'subcontract_no', name: 'subcontract_no' },
            { data: 'company_name', name: 'company_name' },
            { data: 'company_kana_name', name: 'company_kana_name' },
            { data: 'subcontract_company_abbreviation', name: 'subcontract_company_abbreviation' },
            { data: 'subcontract_postal_code', name: 'subcontract_postal_code' },
            { data: 'subcontract_address1', name: 'subcontract_address1' },
            { data: 'subcontract_address2', name: 'subcontract_address2' },
            { data: 'subcontract_phone_number', name: 'subcontract_phone_number' },
            { data: 'subcontract_fax_number', name: 'subcontract_fax_number' },
            { data: 'offset', name: 'offset' },
            { data: 'subcontract_remark', name: 'subcontract_remark' },
            { data: 'delete_flg', name: 'delete_flg' }
        ]
    });
});