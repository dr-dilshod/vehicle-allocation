/**
* Created by Muzaffar on 23.03.2020.
*/
<template>
    <div class="vehicle-grid" style="border: 1px groove;" >
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 ref= "editTitle" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-3">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-5">
                <p class="text-right">
                    <button class="btn btn-lg btn-danger btn-fixed-width">{{__('common.delete')}}
                    </button>
                    <button class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}
                    </button>
                    <button @click="toggleEditMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}</button>
                </p>
            </div>
        </div>
        <table class="sticky-table">
            <thead>
                <tr>
                    <th v-for="header in columns" :style="{minWidth: header.width}">
                        {{header.header}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tableRow in tableModel">
                    <td v-for="key in columns">
                        <m-column :name="key.name" :value="tableRow[key.name]" :type="key.type"></m-column>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import MColumn from "./MColumn";
    import Sticky from "../utils/sticky-table.min"
    export default{
        components: {MColumn},
        name: 'VehicleGrid',
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            companyUrl: {type: String, required: true},
            fixedCols: {type: String},
            processUrl: {type: String},
            fetchUrl: {type: String},
            height: {type: String},
        },
        data(){
            return {
                tableData: [],
                tableModel: [],
                columns: [],
                mode: 'normal'
            }
        },
        mounted(){
            this.columns =
                [
                    {name:'vehicle_no',type: "text",header:"Vehicle No",width: "150px"},
                    {name:'company_name',type: "text",header:"Company Name",width: "150px"},
                    {name:'company_kana_name', type: "text",header:"Company Kana Name",width: "150px"},
                    {name:'vehicle_company_abbreviation',type: "text",header:"Abbreviation",width: "150px"},
                    {name:'vehicle_postal_code',type: "text",header:"Postal Code",width: "150px"},
                    {name:'vehicle_address1',type: "text",header:"Address 1",width: "150px"},
                    {name:'vehicle_address2',type: "text",header:"Address 2",width: "150px"},
                    {name:'vehicle_phone_number',type: "text",header:"Phone Number",width: "150px"},
                    {name:'vehicle_fax_number',type: "text",header:"Fax Number",width: "150px"},
                    {name:'offset',type: "checkbox",header:"Offset",width: "150px"},
                    {name:'vehicle_remark',type: "text",header:"Remarks",width: "150px"},
                ];
            this.fetchData().then(res => {
                    this.initialize();
                }
            );

        },
        methods: {
            initialize(){
                $('.sticky-table').sticky({
                    'top':"thead tr",
                    'left':"tr td:nth-child(-n+"+this.fixedCols+"), tr th:nth-child(-n+"+this.fixedCols+")",
                });
                $('.wrapper-sticky').css('height',this.height);
                let margin = 0;
                $('table tr').each(function () {
                    margin = 0;
                    $(this).find('.skt-sticky-left').each(function () {
                        $(this).css({left: margin+'px'});
                        margin += $(this).width() + 1;
                    });
                });
            },
            async fetchData(){
                await axios.get(this.fetchUrl).then(response => {
                    this.tableData = response.data;
                });
                return 1;
            },
            toggleEditMode(){
                if(this.mode === 'normal')
                    this.setEditMode();
                else
                    this.unsetEditMode();
            },
            setEditMode(){
                this.mode = 'edit';
            },
            unsetEditMode(){
                this.mode = 'normal'
            },
            setTableModel(){
                let counter = 0;
                for(let row in this.tableData){
                    let current = this.tableData[row];
                    let entries = Object.values(this.columns);
                    let fixed = [];
                    for(let i = 0; i < entries.length; i++){
                        fixed[entries[i].name] = current[entries[i].name];
                    }
                    this.tableModel.push(fixed);
                }
            },
        },
        watch: {
            tableData: function () {
                this.setTableModel();
            }
        }
    }
</script>
<style>
    .vehicle-grid *{
        box-sizing: border-box;
    }
    .sticky-table{
        height: 300px;
    }
    .sticky-table td, .sticky-table th{
        height: 40px;
        background: #fff;
        text-align: center;
        border-bottom: 1px solid #dedede;
    }
    .wrapper-sticky table td.skt-sticky-left, .wrapper-sticky table td.skt-sticky-top th{
        outline: none;
        border: none;
    }
    .wrapper-sticky table tr.skt-sticky-top th{
        outline: none;
    }
    .sticky-table tr{
        border-bottom: 1px solid #dedede;
    }

</style>