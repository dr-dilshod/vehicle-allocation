<template>
    <div id="app">
        <div class="row mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" v-if="this.mode == 'editing'">Editing</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register" :disabled="this.mode != 'editing'">Register</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="edit" >Edit</button>
            </div>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :editSettings="editSettings" :height="300"
                  :frozenColumns="3" :toolbar="toolbarBtns">
            <e-columns>
                <e-column field='driver_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='vehicle_type' headerText='Type'  editType= 'dropdownedit' :edit='ddParams' width="100">Test</e-column>
                <e-column field='driver_name' headerText='Name'  width="150"></e-column>
                <e-column field='driver_mobile_number' headerText='Mobile number' width="150"></e-column>
                <e-column field='vehicle_no3' headerText='Vehicle No' width="150"></e-column>
                <e-column field='maximum_Loading' headerText="Max Load" width="100"></e-column>
                <e-column field='search_flg' headerText='Display'   editType= 'booleanedit' :edit='searchParams' width="50" ></e-column>
                <e-column field='admin_flg' headerText='Admin' editType= 'booleanedit' :edit='adminParams' width="100" ></e-column>
                <e-column field='driver_remark' headerText='Remarks' width="200"></e-column>
                <e-column field='driver_pass' :allowEditing='false' :validationRules='driverPassword' defaultValue='parol' headerText='Password' width="200"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>

<script>
    import Vue from "vue";
    import {GridPlugin, Sort, Freeze, Toolbar, Edit} from '@syncfusion/ej2-vue-grids';


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
                editSettings: {
                    allowEditing: true,
                    allowAdding: true,
                    allowDeleting: true,
                    showDeleteConfirmDialog: true,
                },
                toolbarBtns: [],
                ddParams: { params: { value: 'ascsa' } },
                searchParams: { params: {checked: true } },
                adminParams: { params: {checked: true } },
                mode: 'normal',
                driverPassword: { required: true, minLength: 5 }
            };
        },
        mounted() {
            console.log('Component mddfsdounted.');
            this.fetchData(this.resourceUrl);
        },
        methods: {
            fetchData(url) {
                axios.get(url)
                    .then(data => {
                        this.data = data.data.data
                        console.log(this.data);
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
                console.log(args);
            },
            deleteData(id){
                let DriverTable = this;
                axios.delete(this.resourceUrl+'/'+id)
                    .then(function(response){
                        console.log(response);
                        DriverTable.mode = 'normal';
                        DriverTable.refresh();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            insertData(driver){
                let driverTable = this;
                axios.post(this.resourceUrl,driver)
                    .then(function(response){
                        console.log(response);
                        driverTable.mode = 'normal';
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
                        console.log(response);
                        driverTable.mode = 'normal';
                        driverTable.refresh();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            edit() {
                this.toolbarBtns = ['Edit', 'Delete', 'Update', 'Cancel'];
                this.mode = 'editing';
                this.editSettings.allowEditing = true;
                this.editSettings.allowDeleting = true;
                this.$refs.grid.refresh();
            },
            refresh() {
                this.fetchData(this.resourceUrl);
            },
            register() {
                this.$refs.grid.addRecord();
            },
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
</style>
