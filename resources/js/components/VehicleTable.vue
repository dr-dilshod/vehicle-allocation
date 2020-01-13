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

    </div>
</template>
<script>
    import Vue from "vue";
    import { VueSimpleAlert } from "vue-simple-alert";
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';
    Vue.use( GridPlugin );
    Vue.use(VueSimpleAlert);


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
            showDialog(response) {
                let message = response.message + ': ';
                let errors = response.errors;
                $.each( errors, function( key, value ) {
                    message += value[0]; //showing only the first error.
                });
                this.$alert(message);
            },
            showSuccessDialog() {
                this.$alert('Operation successfully done!');
            },
            actionBegin(args){
                if(args.requestType == 'save'){
                    args.cancel = true;
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
                        vehicleTable.$refs.grid.closeEdit();
                        vehicleTable.setEditMode('normal');
                        vehicleTable.showSuccessDialog();
                        vehicleTable.fetchCompanies();
                    })
                    .catch(function(error){
                        vehicleTable.showDialog(error.response.data);
                    });
            },
            deleteVehicle(vehicle_id){
                const vehicleTable = this;
                axios.delete(this.resourceUrl+'/'+vehicle_id)
                    .then(function(response){
                        vehicleTable.showSuccessDialog();
                        vehicleTable.setEditMode('normal');
                        vehicleTable.refresh();
                    })
                    .catch(function(error){
                        alert(error);
                        vehicleTable.showDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            editVehicle(vehicle){
                const vehicleTable = this;
                let id = vehicle.vehicle_id;
                axios.put(this.resourceUrl+'/'+id, vehicle)
                    .then(function(response){
                        vehicleTable.$refs.grid.closeEdit();
                        vehicleTable.setEditMode('normal');
                        vehicleTable.showSuccessDialog();
                        vehicleTable.fetchCompanies();
                    })
                    .catch(function(error){
                        vehicleTable.showDialog(error.response.data);
                    });
            },
            fetchData(url) {
                let grid = this.$refs.grid.ej2Instances;
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
            fetchCompanies() {
                axios.get(this.companyUrl)
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
                }
                this.$refs.grid.refresh();
                this.mode = editMode;
            },
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar]
        },
        name: 'VehicleTable'
    }
</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";

</style>