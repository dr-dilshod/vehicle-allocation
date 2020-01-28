<template>
    <div id="app">
        <div class="row mb-4">
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
                <button ref="registerBtn" class="btn btn-lg btn-danger p-1 pl-2 pr-2">Register</button>
                <button ref="editBtn" class="btn btn-lg btn-danger p-1 pl-3 pr-3">Edit</button>
            </div>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="300" :frozenColumns="3"  :enableHover='false' :allowSelection='true' :queryCellInfo='customiseCell'>
            <e-columns>
                <e-column field='vehicle_type' headerText='Type' :template='editTemplate' editType='dropdownedit'  width="150">Test</e-column>
                <e-column field='driver_name' headerText='Name'  width="150"></e-column>
                <e-column field='driver_mobile_number' headerText='Mobile number' width="150"></e-column>
                <e-column field='vehicle_no3' headerText='Vehicle No' width="150"></e-column>
                <e-column field='maximum_Loading' headerText="Max Load" width="100"></e-column>
                <e-column field='search_flg' headerText='Display'   editType= 'booleanedit' defaultValue="true"  :template='searchTemplate' width="150" ></e-column>
                <e-column field='admin_flg' headerText='Admin' editType= 'booleanedit' :template='adminTemplate' width="150" ></e-column>
                <e-column field='driver_remark' headerText='Remarks' width="200"></e-column>
                <e-column field='driver_pass' :validationRules='driverPassword' defaultValue='parol1234' headerText='Password' width="200"></e-column>
                <e-column field='driver_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>

<script>
    import Vue from "vue";
    import {GridPlugin, Sort, Freeze, Toolbar, Edit} from '@syncfusion/ej2-vue-grids';
    import {TableUtil} from '../utils/TableUtil.js'

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
                editTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{data.vehicle_type}}</label>',
                            data() { return { data: { data: {} } }; }
                        })
                    }
                },
                adminTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{(data.admin_flg==1)? "Administrator":"General"}}</label>',
                            data() { return { data: { data: {} } }; }
                        })
                    }
                },
                searchTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{(data.search_flg==1)? "Show":"Hide"}}</label>',
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
            customiseCell: function(args) {
                if (args.column.field === 'admin_flg') {
                    if (args.data['admin_flg'] == 1) {
                        console.log("hi!!!");
                        args.cell.classList.add('below-30');
                    } else {
                        console.log("elsehi!!!");
                        args.cell.classList.add('below-80');
                    }
                }
            },
            fetchData(url) {
                axios.get(url)
                    .then(data => {
                        this.data = data.data.data;
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
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            insertData(driver){
                let driverTable = this;
                axios.post(this.resourceUrl,driver)
                    .then(function(response){
                        driverTable.tableUtil.endEditing();
                        driverTable.refresh();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            editData(driver){
                let driverTable = this;
                let id = driver.driver_id;
                delete driver.driver_id;
                axios.put(this.resourceUrl+'/'+id, driver)
                    .then(function(response){
                        driverTable.tableUtil.endEditing();
                        driverTable.refresh();
                    })
                    .catch(function(error){
                        alert(error)
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
    .below-30 {
        background-color: orangered;
    }
    .below-80 {
        background-color: yellow;
    }
</style>
