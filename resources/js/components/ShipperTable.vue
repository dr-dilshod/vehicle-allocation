<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 ref="editTitle" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{__('shipper.shipper_list')}}</h2>
            </div>
            <div class="col-4">
                <p class="text-right">
                    <button ref="registerBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}</button>
                    <button ref="editBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}</button>
                </p>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="selectedShipper">{{__('shipper.shipper')}}</label>
                    </div>
                    <div class="form-group ml-3">
                        <select id="selectedShipper" v-model="filter.shipper" class="form-control" style="width: 280px;">
                            <option value=""></option>
                            <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                {{ shipper.fullname }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="selectedCompany">{{__('shipper.bill_to')}}</label>
                    </div>
                    <div class="form-group ml-3">
                        <select name="selectedCompany" id="selectedCompany" v-model="filter.billTo" class="form-control" style="width: 280px;">
                            <option value=""></option>
                            <option v-for="company in companies" :value="company">
                                {{ company }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary btn-fixed-width">{{__('common.search')}}</button>
                    </div>
                    <div class="form-group ml-3">
                        <button type="reset" @click = "clear" class="btn btn-primary btn-fixed-width">{{__('common.clear')}}</button>
                    </div>
                </form>

            </div>

        </div>

        <ejs-grid ref="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270"
                  :frozenColumns="4"  >
            <e-columns>
                <e-column field='shipper_no' :headerText='__("shipper.shipper_no")' width="100"></e-column>
                <e-column :headerText='__("shipper.shipper")' width="150" :template="nameTemplate" :editTemplate="nameEditTemplate"></e-column>
                <e-column :headerText='__("shipper.furigana")' width="150" :template="furiganaTemplate" :editTemplate="furiganaEditTemplate"></e-column>
                <e-column field='shipper_company_abbreviation' :headerText='__("shipper.abbreviation")' width="150" ></e-column>
                <e-column field='postal_code' :headerText='__("shipper.postal_code")' width="150" ></e-column>
                <e-column field='address1' :headerText='__("shipper.address1")' width="200" ></e-column>
                <e-column field='address2' :headerText='__("shipper.address2")' width="200" ></e-column>
                <e-column field='phone_number' :headerText='__("shipper.phone_number")' width="200"></e-column>
                <e-column field='fax_number' :headerText='__("shipper.fax_number")' width="200" ></e-column>
                <e-column field='closing_date' :headerText='__("shipper.closing_date")' type="number" min="0" step="1" editType= 'numericedit' :edit='numericParams' width="150"></e-column>
                <e-column field='payment_date' :headerText='__("shipper.payment_date")' type='date' format= 'dd/MM/yyyy'
                          editType = 'datepickeredit' :editTemplate="editTemplate" width="200" ></e-column>
                <e-column field='shipper_id' :headerText='__("shipper.shipper_id")' :isPrimaryKey="true" :visible=false></e-column>
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

    Vue.prototype.$eventHub = new Vue();

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
                updatedShipper : {},
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
                        headerText : this.__('shipper.name1'),
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, this.__('shipper.at_most_60_letters')]},
                    },
                    {
                        field : 'shipper_name2',
                        headerText : this.__('shipper.name2'),
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, this.__('shipper.at_most_60_letters')]},
                    }
                ],
                furiganaCols : [
                    {
                        field : 'shipper_kana_name1',
                        headerText : this.__('shipper.name1'),
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, this.__('shipper.at_most_60_letters')]},
                    },
                    {
                        field : 'shipper_kana_name2',
                        headerText : this.__('shipper.name2'),
                        width : 100,
                        validationRules : {maxLength:[(args) => {return args['value'].length <= 60;}, this.__('shipper.at_most_60_letters')]},
                    }
                ]
            }
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.fetchShipperNames();
            this.fetchCompanies();
            this.search();
        },
        methods: {
            editTemplate(){
                return { template: Vue.component('picker',{
                    components: {
                        Datepicker
                    },
                    template : `<input id="payment_date" class="form-control" type="date" format="dd/MM/yyyy" v-model="data.payment_date" />`,
                    data() {
                        return {
                            data : {}
                        }
                    }

                })}
            },
            nameTemplate(){
                return { template: Vue.component('shipperName',{
                    template : `<span>{{data.shipper_name1}}&nbsp;<br/>{{data.shipper_name2}}&nbsp;</span>`,
                    data() {
                        return {
                            data : {}
                        }
                    }
                })}
            },
            nameEditTemplate(){
                return { template: Vue.component('shipperNameEdit',{
                    template : `<span class="e-control-wrapper">
                                <input class="e-field e-input" @change='nameUpdate' v-on:keyup="nameUpdate" type="text" v-model="data.shipper_name1" />
                           <br/><input class="e-field e-input" @change='nameUpdate' v-on:keyup="nameUpdate" type="text" v-model="data.shipper_name2" /></span>`,
                    data() {
                        return {
                            data : {}
                        }
                    },
                    mounted(){
                        this.nameUpdate();
                    },
                    methods : {
                        nameUpdate(args){
                            this.$eventHub.$emit("nameUpdate", this.data);
                        }
                    }

                })}
            },
            furiganaTemplate(){
                return { template: Vue.component('furiganaName',{
                    template : `<span>{{data.shipper_kana_name1}}<br/>{{data.shipper_kana_name2}}</span>`,
                    data() {
                        return {
                            data : {}
                        }
                    }
                })}
            },
            furiganaEditTemplate(){
                return { template: Vue.component('furiganaNameEdit',{
                    template : `<span class="e-control-wrapper">
                                <input class="e-field e-input" @change='furiganaUpdate' v-on:keyup="furiganaUpdate" type="text" v-model="data.shipper_kana_name1" />
                           <br/><input class="e-field e-input" @change='furiganaUpdate' v-on:keyup="furiganaUpdate" type="text" v-model="data.shipper_kana_name2" /></span>`,
                    data() {
                        return {
                            data : {}
                        }
                    },
                    mounted(){
                        this.furiganaUpdate();
                    },
                    methods : {
                        furiganaUpdate(){
                            this.$eventHub.$emit("furiganaUpdate", this.data);
                        }
                    }

                })}
            },


            shipperNameUpdate(updatedShipper){
                if(!updatedShipper.shipper_id){
                    this.updatedShipper.shipper_name1 = updatedShipper.shipper_name1;
                    this.updatedShipper.shipper_name2 = updatedShipper.shipper_name2;
                    return;
                }
                for (let i=0; i<this.data.length; i++){
                    if (this.data[i].shipper_id == updatedShipper.shipper_id){
                        this.data[i].shipper_name1 = updatedShipper.shipper_name1;
                        this.data[i].shipper_name2 = updatedShipper.shipper_name2;
                        this.updatedShipper = this.data[i];
                    }
                }
            },
            shipperFuriganaUpdate(updatedShipper){
                if (!updatedShipper.shipper_id){
                    this.updatedShipper.shipper_kana_name1 = updatedShipper.shipper_kana_name1;
                    this.updatedShipper.shipper_kana_name2 = updatedShipper.shipper_kana_name2;
                    return;
                }
                for (let i=0; i<this.data.length; i++){
                    if (this.data[i].shipper_id == updatedShipper.shipper_id){
                        this.data[i].shipper_kana_name1 = updatedShipper.shipper_kana_name1;
                        this.data[i].shipper_kana_name2 = updatedShipper.shipper_kana_name2;
                        this.updatedShipper = this.data[i];
                    }
                }
            },

            actionBegin(args){
                if (args.requestType === "beginEdit") {
                    this.$eventHub.$on("nameUpdate", this.shipperNameUpdate);
                    this.$eventHub.$on("furiganaUpdate", this.shipperFuriganaUpdate);
                }
                if(args.requestType == 'save'){
                    args.data.shipper_name1 = this.updatedShipper.shipper_name1;
                    args.data.shipper_name2 = this.updatedShipper.shipper_name2;
                    args.data.shipper_kana_name1 = this.updatedShipper.shipper_kana_name1;
                    args.data.shipper_kana_name2 = this.updatedShipper.shipper_kana_name2;
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
