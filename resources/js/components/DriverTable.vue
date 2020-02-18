<template>
    <div id="app">
        <div class="row mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 ref="editTitle" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <p class="text-right">
                    <button ref="registerBtn" class="btn btn-lg btn-danger">{{__('common.register')}}</button>
                    <button ref="editBtn" class="btn btn-lg btn-danger">{{__('common.edit')}}</button>
                </p>
            </div>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="300" :frozenColumns="3"  :enableHover='false' :allowSelection='true' rowHeight=35>
            <e-columns>
                <e-column field='driver_id' :headerText='__("driver.driver_id")' :isPrimaryKey="true" :allowEditing='false' width="120"></e-column>
                <e-column field='vehicle_type' :headerText= '__("driver.type")' editType='dropdownedit' :edit='vehicleTypeParams' width="150"></e-column>
                <e-column field='driver_name'  :headerText= '__("driver.name")' width="150"></e-column>
                <e-column field='driver_mobile_number' :headerText= '__("driver.mobile_number")'  width="150"></e-column>
                <e-column field='vehicle_no3' :headerText= '__("driver.vehicle_no")' width="150"></e-column>
                <e-column field='maximum_Loading' :headerText= '__("driver.max_load")' width="100"></e-column>
                <e-column field='search_flg' :headerText= '__("driver.display")'   editType= 'booleanedit' defaultValue="1" :template='searchTemplate' width="150" ></e-column>
                <e-column field='admin_flg' :headerText= '__("driver.admin")' editType='booleanedit' :template="adminTemplate" width="150" ></e-column>
                <e-column field='driver_remark' :headerText='__("driver.remarks")' width="200"></e-column>
                <e-column field='driver_pass' :headerText= '__("driver.password")' width="200"></e-column>
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
                            template: '<label>{{(data.admin_flg == false)? this.__("driver.user"):this.__("driver.administrator")}}</label>',
                            data() { return { data: { data: {} } }; }
                        })
                    }
                },
                searchTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{(data.search_flg == true)? this.__("driver.show"):this.__("driver.hide")}}</label>',
                            data() { return { data: { data: {} } }; }
                        })
                    }
                },
                mode: 'normal',
            };
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.fetchData(this.resourceUrl);
        },
        methods: {
            fetchData(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data;
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
                    args.cancel = true;
                    if(!args.data.driver_id){
                        this.insertData(args.data);
                    }else{
                        this.editData(args.data);
                    }
                }
                if (args.requestType == 'delete') {
                    args.cancel = true;
                    if(args.data[0].driver_id !== undefined){
                        this.deleteData(args.data[0].driver_id);
                    }
                }
            },
            deleteData(id){
                axios.delete(this.resourceUrl+'/'+id)
                    .then(response =>{
                        this.tableUtil.endEditing();
                        this.refresh();
                        this.deleteSuccessDialog();
                    })
                    .catch(error=>{
                        this.errorDialog(error);
                        return false;
                    });
            },
            insertData(driver){
                axios.post(this.resourceUrl,driver)
                    .then(response=>{
                        this.tableUtil.endEditing();
                        this.createSuccessDialog();
                        this.refresh();
                    })
                    .catch(error=>{
                        this.errorDialog(error);
                    });
            },
            editData(driver){
                let id = driver.driver_id;
                delete driver.driver_id;
                axios.put(this.resourceUrl+'/'+id, driver)
                    .then(response=>{
                        this.tableUtil.endEditing();
                        this.updateSuccessDialog();
                        this.refresh();
                    })
                    .catch(error =>{
                        this.errorDialog(error);
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
