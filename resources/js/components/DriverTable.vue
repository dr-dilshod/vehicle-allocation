<template>
    <div id="app">
        <div class="row mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 ref="editTitle" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button ref="registerBtn" class="btn btn-lg btn-danger p-1 pl-2 pr-2">{{__('common.register')}}</button>
                <button ref="editBtn" class="btn btn-lg btn-danger p-1 pl-3 pr-3">{{__('common.edit')}}</button>
            </div>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="300" :frozenColumns="2"  :enableHover='false' :allowSelection='true'>
            <e-columns>
                <e-column field='vehicle_type' :headerText= '__("driver.type")' :validationRules='vehicltTypeRules'  editType='dropdownedit' :edit='vehicleTypeParams' width="150"></e-column>
                <e-column field='driver_name' :headerText= '__("driver.name")' :validationRules='driverNameRules' width="150"></e-column>
                <e-column field='driver_mobile_number' :headerText= '__("driver.mobile_number")'  width="150"></e-column>
                <e-column field='vehicle_no3' :headerText= '__("driver.vehicle_no")' width="150"></e-column>
                <e-column field='maximum_Loading' :headerText= '__("driver.max_load")' width="100"></e-column>
                <e-column field='search_flg' :headerText= '__("driver.display")'   editType= 'booleanedit' defaultValue="1" :template='searchTemplate' width="150" ></e-column>
                <e-column field='admin_flg' :headerText= '__("driver.admin")' editType='booleanedit' :template="adminTemplate" width="150" ></e-column>
                <e-column field='driver_remark' :headerText='__("driver.remarks")' width="200"></e-column>
                <e-column field='driver_pass' defaultValue='parol1234' :headerText= '__("driver.password")' width="200"></e-column>
                <e-column field='driver_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>

<script>
    import Vue from "vue";
    import { createElement } from '@syncfusion/ej2-base';
    import { DropDownList } from "@syncfusion/ej2-dropdowns";
    import { Query } from '@syncfusion/ej2-data';
    import {GridPlugin, Sort, Freeze, Toolbar, Edit} from '@syncfusion/ej2-vue-grids';
    import {TableUtil} from '../utils/TableUtil.js'

    let vehicleTypes= [
        { vehicleType: __('driver.bulk')},
        { vehicleType: __('driver.10tw')},
        { vehicleType: __('driver.10t_flat')},
        { vehicleType: __('driver.4tw')},
        { vehicleType: __('driver.4t_flat')},
        { vehicleType: __('driver.controller')},
    ];
    Vue.use(GridPlugin);
    export default {
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                tableUtil : undefined,
                vehicleTypeParams: {
                    params:   {
                        dataSource: vehicleTypes,
                        fields: {text:"vehicleType",value:"vehicleType"},
                        query: new Query(),
                    }
                },
                adminTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{(data.admin_flg == false)? "General":"Administrator"}}</label>',
                            data() { return { data: { data: {} } }; }
                        })
                    }
                },
                searchTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{(data.search_flg == true)? "Show":"Hide"}}</label>',
                            data() { return { data: { data: {} } }; }
                        })
                    }
                },
                vehicltTypeRules: {required: true},
                driverNameRules: {required: true, minLength: 5},
                driverPasswordRules: {required: true, minLength: 5},
                mode: 'normal',
            };
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.fetchData(this.resourceUrl);
        },
        methods: {
            showDialog(response) {
                let message = response.message + ': ';
                let errors = response.errors;
                $.each( errors, function( key, value ) {
                    message += value[0]; //showing only the first error.
                });
                this.$fire({
                    title: "Message",
                    text: message,
                    type: "error",
//                    timer: 5000
                });
            },
            showSuccessDialog() {
                this.$fire({
                    title: "Message",
                    text: (this.__('driver.operation_successfully_done')),
                    type: "success",
//                    timer: 5000
                });
            },
            fetchData(url) {
                axios.get(url)
                    .then(data => {
                        this.data = data.data.data;
                        for (let i = 0; i <this.data.length ; i++) {
                            if (this.data[i].search_flg==0){
                                this.data[i].search_flg = false;
                            } else {
                                this.data[i].search_flg = true;
                            }
                            if (this.data[i].admin_flg==1){
                                this.data[i].admin_flg = true;
                            } else {
                                this.data[i].admin_flg = false;
                            }
                        }
                    })
            },
            actionBegin(args) {
                if (args.requestType == 'save') {
                    if(args.data.driver_id === undefined){
                        this.insertData(args.data);
                    }else{
                        this.editData(args.data);
                    }
                }
                if (args.requestType == 'delete') {
                    if(args.data[0].driver_id !== undefined){
                        this.deleteData(args.data[0].driver_id);
                    }
                }
            },
            deleteData(id){
                let driverTable = this;
                axios.delete(this.resourceUrl+'/'+id)
                    .then(function(response){
                        driverTable.tableUtil.endEditing();
                        driverTable.refresh();
                        driverTable.deleteSuccessDialog();
                    })
                    .catch(function(error){
                        driverTable.errorDialog(error);
                        return false;
                    });
            },
            insertData(driver){
                let driverTable = this;
                axios.post(this.resourceUrl,driver)
                    .then(function(response){
                        driverTable.tableUtil.endEditing();
                        driverTable.createSuccessDialog();
                        driverTable.fetchCompanies();
                        driverTable.refresh();
                    })
                    .catch(function(error){
                        driverTable.errorDialog(error);
                    });
            },
            editData(driver){
                let driverTable = this;
                let id = driver.driver_id;
                delete driver.driver_id;
                axios.put(this.resourceUrl+'/'+id, driver)
                    .then(function(response){
                        driverTable.tableUtil.endEditing();
                        driverTable.updateSuccessDialog();
                        driverTable.fetchCompanies();
                        driverTable.refresh();
                    })
                    .catch(function(error){
                        driverTable.errorDialog(error);
                    });
            },
            refresh() {
                this.fetchData(this.resourceUrl);
            }
        },
        provide: {
            grid: [Sort, Freeze, Edit, Toolbar]
        },
        name: 'DriverTable'
    }

</script>
<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-base/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-popups/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-dropdowns/styles/bootstrap.css";
</style>
