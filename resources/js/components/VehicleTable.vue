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
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-4">
                <p class="text-right">
                    <button ref="registerBtn" class="btn btn-lg btn-danger btn-fixed-width" >{{__('common.register')}}</button>
                    <button ref="editBtn" class="btn btn-lg btn-danger btn-fixed-width" >{{__('common.edit')}}</button>
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
                  :allowSorting="true" :height="270">
            <e-columns>
                <e-column field='vehicle_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='vehicle_no' :headerText='__("vehicle.vehicle_no")' width="100"></e-column>
                <e-column field='company_name' :headerText='__("vehicle.company_name")' width="150"></e-column>
                <e-column field='company_kana_name' :headerText='__("vehicle.kana_name")' width="150"></e-column>
                <e-column field='vehicle_company_abbreviation' :headerText='__("vehicle.company_abbr")'  width="150"></e-column>
                <e-column field='vehicle_postal_code' textAlign="Center" :headerText='__("vehicle.postal_code")' width="150"></e-column>
                <e-column field='vehicle_address1' :headerText='__("vehicle.address")' width="200"></e-column>
                <e-column field='vehicle_address2' :headerText='__("vehicle.address1")' width="200"></e-column>
                <e-column field='vehicle_phone_number' :headerText='__("vehicle.phone")' width="200"></e-column>
                <e-column field='vehicle_fax_number' :headerText='__("vehicle.fax")' width="200"></e-column>
                <e-column field='offset' :headerText='__("vehicle.offset")' textAlign="Center" editType='booleanedit' :template='offsetTemplate' width="100"></e-column>
                <e-column field='vehicle_remark' :headerText='__("vehicle.remark")' width="250"></e-column>
            </e-columns>
        </ejs-grid>

    </div>
</template>
<script>
    import Vue from "vue";
    import { VueSimpleAlert } from "vue-simple-alert";
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';
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
            insertVehicle(vehicle){
                const vehicleTable = this;
                axios.post(this.resourceUrl,vehicle)
                    .then(function(response){
                        vehicleTable.tableUtil.endEditing();
                        vehicleTable.createSuccessDialog();
                        vehicleTable.refresh();
                    })
                    .catch(function(error){
                        vehicleTable.errorDialog(error);
                    });
            },
            deleteVehicle(vehicle_id){
                const vehicleTable = this;
                axios.delete(this.resourceUrl+'/'+vehicle_id)
                    .then(function(response){
                        vehicleTable.tableUtil.endEditing();
                        vehicleTable.deleteSuccessDialog();
                        vehicleTable.refresh();
                    })
                    .catch(function(error){
                        vehicleTable.errorDialog(error);
                        return false;
                    });
                return true;
            },
            editVehicle(vehicle){
                const vehicleTable = this;
                let id = vehicle.vehicle_id;
                axios.put(this.resourceUrl+'/'+id, vehicle)
                    .then(function(response){
                        vehicleTable.tableUtil.endEditing();
                        vehicleTable.updateSuccessDialog();
                        vehicleTable.refresh();
                    })
                    .catch(function(error){
                        vehicleTable.errorDialog(error);
                    });
            },
            fetchData() {
                let grid = this.$refs.grid.ej2Instances;
                axios.get(this.resourceUrl+'?company_name='+this.company_name)
                    .then(response => {
                        this.data = response.data;
                        if(this.data.length > 0)
                            grid.setProperties({
                                frozenColumns: 4
                            });
                        else
                            grid.setProperties({
                                frozenColumns: 0
                            });
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
            grid: [Sort,Freeze,Edit,Toolbar]
        },
        name: 'VehicleTable'
    }
</script>
