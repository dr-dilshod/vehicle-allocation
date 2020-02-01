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
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button ref="registerBtn" class="btn btn-lg btn-danger p-1 pl-2 pr-2"
                        >Register</button>
                <button ref="editBtn" class="btn btn-lg btn-danger p-1 pl-3 pr-3"
                >Edit</button>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="selectedShipper">Shipper</label>
                    </div>
                    <div class="form-group ml-3">
                        <select name="selectedShipper" id="selectedShipper" v-model="selectedShipper" class="form-control">
                            <option value=""></option>
                            <option v-for="name in shipperNames" :value="name">
                                {{ name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="selectedCompany">Bill-to</label>
                    </div>
                    <div class="form-group ml-3">
                        <select name="selectedCompany" id="selectedCompany" v-model="selectedCompany" class="form-control">
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
                        <button type="reset" class="btn btn-primary">Clear</button>
                    </div>
                </form>

            </div>

        </div>

        <ejs-grid ref="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270"
                  :frozenColumns="6"  >
            <e-columns>
                <e-column field='shipper_no' headerText='Shipper No' :validationRules='shipperNoRules' width="100"></e-column>
                <e-column headerText='Shipper' width="200" :columns="shipperNameCols"></e-column>
                <e-column headerText='Furigana' width="200" :columns="furiganaCols"></e-column>
                <e-column field='shipper_company_abbreviation' headerText='Abbreviation' width="150" :validationRules='max60'></e-column>
                <e-column field='postal_code' headerText='Postal Code' width="150" :validationRules='max8'></e-column>
                <e-column field='address1' headerText='Address 1' width="200" :validationRules='max120'></e-column>
                <e-column field='address2' headerText='Address 2' width="200" :validationRules='max120'></e-column>
                <e-column field='phone_number' headerText='Phone number' width="200" :validationRules='max12'></e-column>
                <e-column field='fax_number' headerText='Fax number' width="200" :validationRules='max12'></e-column>
                <e-column field='closing_date' headerText='Closing date' width="200"></e-column>
                <e-column field='payment_date' headerText='Payment date' width="200"></e-column>
                <e-column field='shipper_id' headerText='Shipper id' width="50" :isPrimaryKey="true" :visible=false></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>
<script>
    import Vue from "vue";
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';
    import { TableUtil } from '../utils/TableUtil.js';

    Vue.use( GridPlugin );

    export default{
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            shipperNameUrl: {type: String, required: true},
            companyUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                tableUtil : undefined,
                selectedCompany: '',
                selectedShipper: '',
                companies: [],
                shipperNames: [],
                shipperNoRules : {required : true, maxLength:[(args) => {return args['value'].length <= 4;}, 'At most 4 letters']},
                max8 : {maxLength:[(args) => {return args['value'].length <= 8;}, 'At most 8 letters']},
                max12 : {maxLength:[(args) => {return args['value'].length <= 12;}, 'At most 12 letters']},
                max60 : {maxLength:[(args) => {return args['value'].length <= 60;}, 'At most 60 letters']},
                max120 : {maxLength:[(args) => {return args['value'].length <= 120;}, 'At most 120 letters']},
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
            this.fetchData(this.resourceUrl);
            this.fetchShipperNames(this.shipperNameUrl);
            this.fetchCompanies(this.companyUrl);
        },
        methods: {
            actionBegin(args){
                if(args.requestType == 'save'){
                    if(args.data.shipper_id === undefined){
                        this.insertData(args.data);
                    }else{
                        this.editData(args.data);
                    }
                }
                if(args.requestType == 'delete'){
                    if(args.data[0].shipper_id !== undefined){
                        this.deleteData(args.data[0].shipper_id);
                    }
                }
            },
            insertData(shipper){
                let tableUtil = this.tableUtil;
                axios.post(this.resourceUrl, shipper)
                    .then(function(response){
                        tableUtil.endEditing();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            deleteData(id){
                let tableUtil = this.tableUtil;
                axios.delete(this.resourceUrl+'/'+id)
                    .then(function(response){
                        tableUtil.endEditing();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            editData(shipper){
                let tableUtil = this.tableUtil;
                let id = shipper.shipper_id;
                delete shipper.shipper_id;
                axios.put(this.resourceUrl+'/'+id, shipper)
                    .then(function(response){
                        tableUtil.endEditing();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            fetchData(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data.data
                    })
            },
            fetchShipperNames(url) {
                axios.get(url)
                    .then(response => {
                        this.shipperNames = response.data;
                    });
            },
            fetchCompanies(url) {
                axios.get(url)
                    .then(response => {
                        this.companies = response.data
                    });
            },
            search(){
                return this.fetchData(this.resourceUrl+'?name='+this.selectedShipper
                    +'&bill-to='+this.selectedCompany);
            },
            clear(){
                this.selectedShipper = '';
                this.selectedCompany = '';
                this.search();
            },
            refresh(){
                this.fetchShipperNames(this.shipperNameUrl);
                this.fetchCompanies(this.companyUrl);
                this.search();
            },
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
