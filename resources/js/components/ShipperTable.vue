<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h2 ref="editTitle" class="text-center text-danger">Editing</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">Shipper list</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button ref="registerBtn" class="btn btn-lg btn-danger p-1 pl-2 pr-2">Register</button>
                <button ref="editBtn" class="btn btn-lg btn-danger p-1 pl-3 pr-3">Edit</button>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="selectedShipper">Shipper</label>
                    </div>
                    <div class="form-group ml-3">
                        <select id="selectedShipper" v-model="filter.shipper" class="form-control">
                            <option value=""></option>
                            <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                {{ shipper.fullname }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="selectedCompany">Bill-to</label>
                    </div>
                    <div class="form-group ml-3">
                        <select name="selectedCompany" id="selectedCompany" v-model="filter.billTo" class="form-control">
                            <option value=""></option>
                            <option v-for="company in companies" :value="company">
                                {{ company }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    <div class="form-group ml-3">
                        <button type="reset" @click = "clear" class="btn btn-primary">Clear</button>
                    </div>
                </form>

            </div>

        </div>

        <ejs-grid ref="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270"
                  :frozenColumns="6"  >
            <e-columns>
                <e-column field='shipper_no' headerText='Shipper No' width="100"></e-column>
                <e-column headerText='Shipper' width="200" :columns="shipperNameCols"></e-column>
                <e-column headerText='Furigana' width="200" :columns="furiganaCols"></e-column>
                <e-column field='shipper_company_abbreviation' headerText='Abbreviation' width="150" ></e-column>
                <e-column field='postal_code' headerText='Postal Code' width="150" ></e-column>
                <e-column field='address1' headerText='Address 1' width="200" ></e-column>
                <e-column field='address2' headerText='Address 2' width="200" ></e-column>
                <e-column field='phone_number' headerText='Phone number' width="200"></e-column>
                <e-column field='fax_number' headerText='Fax number' width="200" ></e-column>
                <e-column field='closing_date' headerText='Closing date' type="number" min="0" step="1" editType= 'numericedit' :edit='numericParams' width="150"></e-column>
                <e-column field='payment_date' headerText='Payment date' type='date' format= 'y-M-d'
                          editType = 'datepickeredit' :editTemplate="editTemplate" width="200" ></e-column>
                <e-column field='shipper_id' headerText='Shipper id' :isPrimaryKey="true" :visible=false></e-column>
            </e-columns>
        </ejs-grid>

    </div>
</template>
<script>
    import Vue from "vue";
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';
    import { TableUtil } from '../utils/TableUtil.js';
    import Datepicker from "vuejs-datepicker";
    import { DatePickerPlugin } from "@syncfusion/ej2-vue-calendars";
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    Vue.use( GridPlugin );

    export default{
        components: {
            Datepicker
        },
        props: {
            backUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                companies: [],
                shippers: [],
                tableUtil : undefined,
                filter : {
                    shipper : '',
                    billTo : ''
                },
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy-MM-dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
                numericParams: { params: { decimals: 0, value: 1 } },
                shipperNameCols : [
                    {
                        field : 'shipper_name1',
                        headerText : 'Name1',
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, 'At most 60 letters']},
                    },
                    {
                        field : 'shipper_name2',
                        headerText : 'Name2',
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, 'At most 60 letters']},
                    }
                ],
                furiganaCols : [
                    {
                        field : 'shipper_kana_name1',
                        headerText : 'Name1',
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, 'At most 60 letters']},
                    },
                    {
                        field : 'shipper_kana_name2',
                        headerText : 'Name2',
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, 'At most 60 letters']},
                    }
                ]
            }
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.fetchShipperNames();
            this.fetchCompanies();
        },
        methods: {
            editTemplate(){
                return { template: Vue.component('picker',{
                    components: {
                        Datepicker
                    },
                    template : `<input id="payment_date" class="form-control" type="date" format="y-M-d" v-model="data.payment_date" />`,
                    data() {
                        return {
                            data : {}
                        }
                    }

                })}
            },
            actionBegin(args){
                if(args.requestType == 'save'){
                    if(!args.data.shipper_id){
                        this.insertData(args.data);
                    }else{
                        this.editData(args.data);
                    }
                }
                if(args.requestType == 'delete'){
                    if(args.data[0].shipper_id){
                        this.deleteData(args.data[0].shipper_id);
                    }
                }
            },
            insertData(shipper){
                axios.post(this.resourceUrl, shipper)
                    .then(response => {
                        this.tableUtil.endEditing();
                        this.createSuccessDialog();
                        this.refresh();
                    }).catch(error => {
                        this.errorDialog(error);
                    });
            },
            deleteData(id){
                axios.delete(this.resourceUrl+'/'+id)
                    .then(response => {
                        this.tableUtil.endEditing();
                        this.deleteSuccessDialog();
                        this.refresh();
                    }).catch(error => {
                        this.errorDialog(error);
                    });
            },
            editData(shipper){
                let id = shipper.shipper_id;
                axios.put(this.resourceUrl+'/'+id, shipper)
                    .then(response => {
                        this.tableUtil.endEditing();
                        this.updateSuccessDialog();
                        this.refresh();
                    })
                    .catch(error => {
                        this.errorDialog(error);
                    });
            },
            fetchShipperNames() {
                let url = this.resourceUrl+'/fullname';
                axios.get(url)
                    .then(response => {
                        this.shippers = response.data;
                    });
            },
            fetchCompanies() {
                let url = this.resourceUrl+'/distinct-company';
                axios.get(url)
                    .then(response => {
                        this.companies = response.data
                    });
            },
            search(){
                axios.post(this.resourceUrl+'/filter', this.filter)
                    .then(response => {
                        this.data = response.data;
                    })
            },
            clear(){
                this.filter = {
                    shipper : '',
                    billTo : '',
                };
            },
            refresh(){
                this.clear();
                this.fetchShipperNames();
                this.fetchCompanies();
                this.search();
            },
            paymentTemplate(){
                return
            }
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar]
        },
        name: 'ShipperTable'
    }
</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-base/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-popups/styles/bootstrap.css";

</style>
