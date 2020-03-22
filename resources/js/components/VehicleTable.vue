<template>
    <div>
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
                    <button ref="deleteBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.delete')}}
                    </button>
                    <button ref="registerBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}
                    </button>
                    <button ref="editBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}</button>
                </p>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline" @submit.prevent="search">
                <div class="form-group ml-3">
                    <label for="company_name">{{__('vehicle.company_name')}}</label>
                </div>
                <div class="form-group ml-3">
                    <select name="company_name" id="company_name" v-model="company_name" class="form-control" style="min-width: 200px">
                        <option value=""></option>
                        <option v-for="company in companies" :value="company.company_name">
                            {{ company.company_name }}
                        </option>
                    </select>
                </div>
                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary btn-fixed-width">{{__('common.search')}}</button>
                </div>
                <div class="form-group ml-3">
                    <button type="reset" class="btn btn-primary btn-fixed-width" @click.prevent="clear">{{__('common.clear')}}</button>
                </div>
            </form>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270" :allowScrolling="true" :frozenColumns="3">
            <e-columns>
                <e-column field='vehicle_no' :headerText='__("vehicle.vehicle_no")' width="100" defaultValue="" type="string"></e-column>
                <e-column field='company_name' :headerText='__("vehicle.company_name")' width="150" defaultValue="" type="string"></e-column>
                <e-column field='company_kana_name' :headerText='__("vehicle.kana_name")' width="150" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_company_abbreviation' :headerText='__("vehicle.company_abbr")' width="150" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_postal_code' textAlign="Center" :headerText='__("vehicle.postal_code")' width="150" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_address1' :headerText='__("vehicle.address")' width="200" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_address2' :headerText='__("vehicle.address1")' width="200" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_phone_number' :headerText='__("vehicle.phone")' width="200" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_fax_number' :headerText='__("vehicle.fax")' width="200" defaultValue="" type="string"></e-column>
                <e-column field='offset' :headerText='__("vehicle.offset")' textAlign="Center" editType='booleanedit' :template='offsetTemplate' width="100" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_remark' :headerText='__("vehicle.remark")' width="250" defaultValue="" type="string"></e-column>
                <e-column field='vehicle_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
            </e-columns>
        </ejs-grid>

    </div>
</template>
<script>
    import Vue from "vue";
    import { VueSimpleAlert } from "vue-simple-alert";
    import { GridPlugin, Sort, Freeze, Edit } from '@syncfusion/ej2-vue-grids';
    import {TableUtil} from '../utils/TableUtil.js';

    Vue.use( GridPlugin );
    Vue.use( VueSimpleAlert );

    export default{
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            companyUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                tableUtil : undefined,
                company_name: '',
                companies: [],
            }
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.fetchCompanies(this.companyUrl);
            this.fetchData();
        },
        methods: {
            offsetTemplate: function () {
                return {
                    template: Vue.component('editOption', {
                        template: '<label>{{(data.offset == true)? this.__("vehicle.yes"):this.__("vehicle.no")}}</label>',
                        data() { return { data: { data: {} } }; }
                    })
                }
            },
            actionBegin(args){
                if(args.requestType == 'save'){
                    args.cancel = true;
                    args.data['offset'] = $('#gridoffset:checked').length;
                    if(args.data.vehicle_id === undefined){
                        this.insertVehicle(args.data);
                    }else{
                        this.editVehicle(args.data);
                    }
                }
                if(args.requestType == 'delete'){
                    args.cancel = true;
                    if(args.data[0].vehicle_id !== undefined){
                        this.deleteVehicle(args.data[0].vehicle_id);
                    }
                }
            },
            async insertVehicle(insertData){
                const vehicleComponent = this;
                let result = false;
                await axios.post(this.resourceUrl,insertData)
                    .then(function(response){
                        result = true;
                    })
                    .catch(function(error){
                        vehicleComponent.errorDialog(error);
                    });
                return result;
            },
            async deleteVehicle(deletedData){
                const vehicleComponent = this;
                let result = false;
                await axios.post(this.resourceUrl+'/destroy',deletedData)
                    .then(function(response){
                        result = true;
                    })
                    .catch(function(error){
                        vehicleComponent.errorDialog(error);
                    });
                return result;
            },
            async editVehicle(editData){
                const vehicleComponent = this;
                let result = false;
                await axios.post(this.resourceUrl+'/update', editData)
                    .then(function(response){
                        result = true;
                    })
                    .catch(function(error){
                        vehicleComponent.errorDialog(error);
                    });
                return result;
            },
            async saveChanges(changedData) {
                this.$modal.show({
                    template: this.saveChangesTemplate,
                    props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
                }, {
                    title: window.__('alert.message'),
                    text: this.__('common.save_changes'),
                    triggerOnConfirm: () => {
                        let addSuccess    = true;
                        let changeSuccess = true;
                        let deleteSuccess = true;
                        if (changedData.deletedRecords.length > 0) {
                            this.deleteVehicle(changedData.deletedRecords).then(result => deleteSuccess = result);
                        }
                        if (changedData.changedRecords.length > 0) {
                            this.editVehicle(changedData.changedRecords).then(result => changeSuccess = result);
                        }
                        if (changedData.addedRecords.length > 0) {
                            this.insertVehicle(changedData.addedRecords).then(result => addSuccess = result);
                        }
                        if (addSuccess && changeSuccess && deleteSuccess) {
                            this.showOperationSuccessDialog();
                            this.fetchData(this.resourceUrl);
                            this.refresh();
                            this.tableUtil.endEditing();
                        }else{
                            this.generalErrorDialog();
                        }
                        this.$modal.hide('confirmDialog');
                    },
                    triggerDiscard: () => {
                        // discard changes e.g. refresh
                        this.fetchData(this.resourceUrl);
                        this.$refs.grid.ej2Instances.refresh();
                        this.$modal.hide('confirmDialog');
                        this.tableUtil.endEditing();
                    }
                }, {
                    height: 'auto',
                    width: 400,
                    name: 'confirmDialog'
                });

            },
            fetchData() {
                let grid = this.$refs.grid.ej2Instances;
                axios.get(this.resourceUrl+'?company_name='+this.company_name)
                    .then(response => {
                        this.data = response.data;
                    })
            },
            fetchCompanies() {
                axios.get(this.companyUrl)
                    .then(companies => {
                        this.companies = companies.data
                    });
            },
            search(){
                this.fetchData();
            },
            clear(){
                this.company_name = '';
                this.search();
            },
            refresh(){
                this.fetchCompanies();
                this.search();
            },
        },
        provide: {
            grid: [Sort,Freeze,Edit]
        },
        name: 'VehicleTable'
    }
</script>
