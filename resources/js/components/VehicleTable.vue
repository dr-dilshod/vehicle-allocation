<template>
    <div>
        <div class="row">
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
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="edit">Edit</button>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline" @submit.prevent="search">
                <div class="form-group ml-3">
                    <label for="company_name">Company name</label>
                </div>
                <div class="form-group ml-3">
                    <select name="company_name" id="company_name" v-model="company_name" class="form-control">
                        <option value=""></option>
                        <option v-for="company in companies" :value="company.company_name">
                            {{ company.company_name }}
                        </option>
                    </select>
                </div>
                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <div class="form-group ml-3">
                    <button type="reset" class="btn btn-primary" @click.prevent="clear">Clear</button>
                </div>
            </form>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270">
            <e-columns>
                <e-column field='vehicle_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='vehicle_no' headerText='Vehicle No' width="100"></e-column>
                <e-column field='company_name' headerText='Company Name' width="150"></e-column>
                <e-column field='company_kana_name' headerText='Kana Name' width="150"></e-column>
                <e-column field='vehicle_company_abbreviation' headerText='Company Abbr'  width="150"></e-column>
                <e-column field='vehicle_postal_code' textAlign="Center" headerText='Postal Code'  editType= 'numericedit' width="150"></e-column>
                <e-column field='vehicle_address1' headerText='Address' width="200"></e-column>
                <e-column field='vehicle_address2' headerText='Address 2' width="200"></e-column>
                <e-column field='vehicle_phone_number' headerText='Phone' width="200"></e-column>
                <e-column field='vehicle_fax_number' headerText='Fax' width="200"></e-column>
                <e-column field='offset' headerText='Offset' textAlign="Center"  editType= 'numericedit' width="100"></e-column>
                <e-column field='vehicle_remark' headerText='Remark' width="250"></e-column>
            </e-columns>
        </ejs-grid>
        <ejs-dialog ref="infoDialog" id="infoDialog" :header='dialog.header' :target='dialog.target' :width='dialog.width'
                    :buttons='dialog.buttons' :isModal="true" :visible="false">
        </ejs-dialog>
    </div>
</template>
<script>
    import Vue from "vue";
    import { DialogPlugin } from '@syncfusion/ej2-vue-popups';
    import { ButtonPlugin } from '@syncfusion/ej2-vue-buttons';
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';
    Vue.use( GridPlugin );
    Vue.use( DialogPlugin );
    Vue.use( ButtonPlugin );

    export default{
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            companyUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                company_name: '',
                companies: [],
                mode: 'normal',
                dialog:{
                    target: '#grid',
                    width: '300px',
                    header: 'Information',
                    buttons: [
                        { click: this.dlgButtonClick, buttonModel: { content: 'OK', isPrimary: true } },
                        { click: this.dlgButtonClick, buttonModel: { content: 'Cancel' }}
                    ]
                },
                validation: {
                    vehicle_no: {required:true,'maxLength':4},
                    company_name: {required:true,'maxLength':60},
                    company_kana_name: {required:true,'maxLength':60},
                    vehicle_company_abbreviation: {'maxLength':60},
                    vehicle_postal_code: {'maxLength':60},
                    vehicle_address1: {'maxLength':60},
                    vehicle_address2: {'maxLength':60},
                    vehicle_phone_number: {'maxLength':15},
                    vehicle_fax_number: {'maxLength':15},
                    offset: {'max':1,'min':0},
                    vehicle_remark: {'maxLength':120},
                }
            }
        },
        mounted() {
            this.fetchCompanies(this.companyUrl);
        },
        methods: {
            showInfoDialog(response) {
                let message = response.message + "<ul>";
                for(let error in response.errors) {
                    message += "<li>" + error + "</li>";
                }
                message += "</ul>";
                $("#infoDialog .e-dlg-content").html(message);
                this.$refs.infoDialog.show();
            },
            dlgButtonClick: function() {
                this.$refs.infoDialog.hide();
            },
            actionBegin(args){
//                alert(args.requestType);
                if(args.requestType == 'save'){
                    if(args.data.vehicle_id === undefined){
                        if(!this.insertData(args)) args.cancel = true;
                    }else{
                        if(!this.editData(args)) args.cancel = true;
                    }
                }
                if(args.requestType == 'delete'){
                    if(args.data[0].vehicle_id !== undefined){
                        if(!this.deleteData(args)) args.cancel = true;
                    }
                }
                console.log(args);
            },
            insertData(args){
                let vehicleTable = this;
                axios.post(this.resourceUrl,args.data)
                    .then(function(response){
                        console.log("Insert data success");
                        console.log(response);
                        vehicleTable.setEditMode('normal');
                        vehicleTable.refresh();
                    })
                    .catch(function(error){
                        console.log("Insert data error");
                        console.log(error.response);
                        vehicleTable.showInfoDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            deleteData(args){
                let vehicleTable = this;
                let id = args.data[0].vehicle_id;
                axios.delete(this.resourceUrl+'/'+id)
                    .then(function(response){
                        console.log("Delete data success");
                        console.log(response);
                        vehicleTable.showInfoDialog();
                        vehicleTable.setEditMode('normal');
                        vehicleTable.refresh();
                    })
                    .catch(function(error){
                        console.log("Delete data error");
                        alert(error);
                        vehicleTable.showInfoDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            editData(args){
                let vehicleTable = this;
                let id = args.data.vehicle_id;
//                delete args.data.vehicle_id;
                axios.put(this.resourceUrl+'/'+id, args.data)
                    .then(function(response){
                        console.log('Edit Data success');
                        console.log(response);
                        vehicleTable.showInfoDialog('Success');
                        vehicleTable.setEditMode('normal');
                        vehicleTable.refresh();
                    })
                    .catch(function(error){
                        console.log('Edit Data error');
                        alert(error);
                        vehicleTable.showInfoDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            fetchData(url) {
                var grid = this.$refs.grid.ej2Instances;
                axios.get(url)
                    .then(data => {
                        this.data = data.data.data;
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
            fetchCompanies(url) {
                axios.get(url)
                    .then(companies => {
                        this.companies = companies.data
                    });
            },
            register(){
                this.$refs.grid.addRecord();
            },
            edit(){
                this.setEditMode('editing');
                this.$refs.grid.refresh();
            },
            search(){
                return this.fetchData(this.fetchUrl+'?company_name='+this.company_name)
            },
            clear(){
                this.company_name = '';
                this.search();
            },
            refresh(){
                this.fetchCompanies(this.companyUrl);
                this.search();
            },
            setEditMode(editMode){
                if(editMode === 'normal'){
                    this.$refs.grid.ej2Instances.setProperties({
                        toolbar: null,
                        editSettings: {
                            allowDeleting: false,
                            allowEditing: false,
                            allowAdding: false,
                        },
                    });
                    this.$refs.grid.refresh();
                    this.mode = editMode;
                }
                if(editMode === 'editing'){
                    let toolbarBtns = ['Edit','Delete','Update','Cancel'];
                    this.$refs.grid.ej2Instances.setProperties({
                        toolbar: toolbarBtns,
                        editSettings: {
                            allowDeleting: true,
                            allowEditing: true,
                            allowAdding: true,
                            showDeleteConfirmDialog: true,
                        },
                    });
                    this.$refs.grid.refresh();
                    this.mode = editMode;
                }
            },
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar]
        },
        name: 'VehicleTable'
    }
</script>

<style scoped>
    /*@import "../../../node_modules/@syncfusion/ej2-base/styles/bootstrap.css";*/
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-vue-popups/styles/bootstrap.css";

</style>