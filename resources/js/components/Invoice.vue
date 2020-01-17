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
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register" :disabled="this.mode != 'editing'">Register</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="edit">Edit</button>
            </div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="billingMonth">Billing month</button>
                <br>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="listPrinting">List printing</button>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline" @submit.prevent="search">
                <div class="col-12">
                    <div class="row">
                        <div class="form-group ml-3">
                            <label for="shipper">Shipper</label>
                        </div>
                        <div class="form-group ml-1">
                            <select name="shipper" id="shipper" v-model="shipper" class="form-control">
                                <option value=""></option>
                                <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                    {{ shipper.shipper_name1 }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <label for="invoice_month">Invoice month</label>
                        </div>
                        <div class="form-group ml-1">
                            <input type="text" class="form-control" id="invoice_month" name="invoice_month" v-model="invoice_month">
                        </div>
                        <div class="form-group ml-3">
                            <label for="invoice_day">Invoice day</label>
                        </div>
                        <div class="form-group ml-1">
                            <input type="text" class="form-control" id="invoice_day" name="invoice_day" v-model="invoice_day">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group ml-3">
                            <label for="weekday">Weekday</label>
                        </div>
                        <div class="form-group ml-1">
                            <input type="text" class="form-control" id="weekday" name="weekday" v-model="weekday">
                        </div>
                        <div class="form-group ml-3">
                            <label for="vehicle_no">Vehicle No</label>
                        </div>
                        <div class="form-group ml-1">
                            <select name="vehicle_no" id="vehicle_no" v-model="vehicle_no" class="form-control">
                                <option value=""></option>
                                <option v-for="vehicle in vehicles" :value="vehicle.vehicle_no">
                                    {{ vehicle.vehicle_no }}
                                </option>
                            </select>                        </div>
                        <div class="form-group ml-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <div class="form-group ml-3">
                            <button type="reset" class="btn btn-primary" @click.prevent="clear">Clear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270">
            <e-columns>
                <e-column field='vehicle_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='status' headerText='Status' width="100" textAlign="Center" ></e-column>
                <e-column field='case_id' headerText='Matter No' width="100" textAlign="Center" ></e-column>
                <e-column field='down_date' headerText='Delivery Date' width="100" textAlign="Center" ></e-column>
                <e-column field='down_time' headerText='Deivery time'  width="100" textAlign="Center" ></e-column>
                <e-column field='shipper_name' headerText='Shipper' width="150" textAlign="Center" ></e-column>
                <e-column field='stack_point' headerText='Stacked point' width="150" textAlign="Center" ></e-column>
                <e-column field='item_price' headerText='Amount' width="150" textAlign="Right"></e-column>
                <e-column field='item_completion_date' headerText='Invoice date' width="200" textAlign="Center"></e-column>
                <e-column field='weight' headerText='Fax' width="200"></e-column>
                <e-column field='offset' headerText='Offset' textAlign="Center"  editType= 'numericedit' width="100"></e-column>
                <e-column field='vehicle_remark' headerText='Remark' width="250"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>
<script>
    import { VueSimpleAlert } from "vue-simple-alert";
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';

    Vue.use( GridPlugin );
    Vue.use( VueSimpleAlert );

    export default{
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            shippersUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data(){
            return {
                data: [],
                weekday: '',
                invoice_day: '',
                invoice_month: '',
                shippers: [],
                vehicles: [],
                mode: 'normal',
            }
        },
        mounted(){

        },
        methods: {
            fetchShippers() {
                axios.get(this.shippersUrl)
                    .then(shippers => {
                        this.shippers = shippers.data
                    });
            },
            fetchVehicles() {
                axios.get(this.vehiclesUrl)
                    .then(vehicles => {
                        this.vehicles = vehicles.data
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
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar]
        },
    }
</script>
<style>

</style>