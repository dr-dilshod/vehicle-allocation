<template>
    <div id="invoice">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block">Back</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" v-if="this.mode == 'editing'">Editing</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-4">
                        <button class="btn btn-lg btn-danger" @click="register" :disabled="this.mode != 'editing'">
                            Register
                        </button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-lg btn-danger" @click="edit">Edit</button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#billingModal">
                            Billing month
                        </button>
                        <br>
                        <button class="btn btn-lg btn-success mt-1" @click="listPrinting">List printing</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline" method="post" @submit.prevent="search">
                <table class="table">
                    <tr>
                        <td>
                            <label for="shipper">Shipper</label>
                        </td>
                        <td>
                            <select name="shipper" id="shipper" v-model="formData.shipper_id" class="form-control">
                                <option value=""></option>
                                <option v-for="shipperItem in shippers" :value="shipperItem.shipper_id">
                                    {{ shipperItem }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <label for="invoice_month">Invoice month</label>
                        </td>
                        <td>
                            <datepicker v-model="formData.invoice_month" :minimumView="'month'" :maximumView="'month'"
                                            :format="options.monthFormat"></datepicker>
                        </td>
                        <td>
                            <label for="invoice_day">Invoice day</label>
                        </td>
                        <td>
                            <select v-model="formData.invoice_day" class="form-control">
                                <option value=""></option>
                                <option value="20">20th</option>
                                <option value="30">30th</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="weekday">Weekday</label>
                        </td>
                        <td>
                            <datepicker v-model="formData.weekday" :minimumView="'day'" :format="options.weekday"
                                            :maximumView="'day'"></datepicker>
                        </td>
                        <td>
                            <label for="vehicle_no">Vehicle No</label>
                        </td>
                        <td>
                            <select name="vehicle_no" id="vehicle_no" v-model="formData.vehicle_no" class="form-control">
                                <option value=""></option>
                                <option v-for="vehicle in vehicles" :value="vehicle.vehicle_id">
                                    {{ vehicle.vehicle_no3 }}
                                </option>
                            </select>
                        </td>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary mr-2">Search</button>
                            <button type="reset" class="btn btn-primary" @click.prevent="clear">Clear</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270" :frozenColumns="4">
            <e-columns>
                <e-column field='stack_point' headerText='Loading port' width="150" textAlign="Center"></e-column>
                <e-column field='down_point' headerText='Drop off' width="150" textAlign="Center"></e-column>
                <e-column field='item_price' headerText='Amount' width="150" textAlign="Right"></e-column>
                <e-column field='down_date' headerText='Delivery Date' width="100" textAlign="Center"></e-column>
                <e-column field='shipper_name' headerText='Shipper' width="150" textAlign="Center"></e-column>
                <e-column field='vehicle_no' headerText='Vehicle No' width="150" textAlign="Center"></e-column>
                <e-column field='weight' headerText='Weight' width="150"></e-column>
                <e-column field='unit_price' headerText='Unit price' textAlign="Right" editType='numericedit'
                          width="100"></e-column>
                <e-column field='status' headerText='Status' width="100" textAlign="Center"></e-column>
                <e-column field='item_id' headerText='Matter No' width="100" textAlign="Center"></e-column>
                <e-column field='down_time' headerText='Delivery time' width="100" textAlign="Center"></e-column>
                <e-column field='item_completion_date' headerText='Invoice date' width="150"
                          textAlign="Center"></e-column>
                <e-column field='item_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
            </e-columns>
        </ejs-grid>
        <div class="row">
            <div class="col-2 offset-md-10">
                <div class="form-group">
                    <label for="totalSales">Total Sales</label>
                    <input type="text" disabled="disabled" id="totalSales" v-model="totalSales">
                </div>
                <div class="form-group">
                    <label for="totalConsumptionTax">Total Consumption Tax</label>
                    <input type="text" id="totalConsumptionTax" disabled="disabled" v-model="totalConsumptionTax">
                </div>
                <div class="form-group">
                    <label for="otherTotals">Other Totals</label>
                    <input type="text" id="otherTotals" disabled="disabled" v-model="otherTotals">
                </div>
                <div class="form-group">
                    <label for="totalSalesTotal">Sales Total</label>
                    <input type="text" id="totalSalesTotal" disabled="disabled" v-model="totalSalesTotal">
                </div>
            </div>
        </div>
        <div class="modal" id="billingModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Print billing date</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <p class="text-center">Select the billing date you want to print</p>
                            <div class="form-group text-center" style="margin: 20px calc(32.5%)">
                                <label for="yearMonth">Year and Month</label>
                                <datepicker v-model="billing.month" :minimumView="'month'" :maximumView="'month'"
                                            :format="options.monthFormat"></datepicker>
                            </div>
                            <div class="form-group d-flex justify-content-around">
                                <span>
                                    <input type="radio" name="billing_day" v-model="billing.day" value="20" id="twenty"/>
                                    <label for="twenty">20th</label>
                                </span>
                                <span>
                                    <input type="radio" name="billing_day" value="30" v-model="billing.day" id="thirty"/>
                                    <label for="thirty">30th</label>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <button type="button" class="btn btn-success" @click="billingPrint">Print</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {VueSimpleAlert} from "vue-simple-alert";
    import {GridPlugin, Sort, Freeze, Toolbar, Edit} from '@syncfusion/ej2-vue-grids';
    import Datepicker from "vuejs-datepicker";
    import * as lang from "vuejs-datepicker/src/locale";

    Vue.use(GridPlugin);
    Vue.use(VueSimpleAlert);
    Vue.use(Datepicker);

    export default{
        props: {
            invoiceUrl: {type: String, required: true},
            backUrl: {type: String, required: true},
            shippersUrl: {type: String, required: true},
            vehiclesUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true},
        },
        components: {
            Datepicker
        },
        data(){
            return {
                data: [],
                formData: {
                    weekday: '',
                    vehicle_id: '',
                    invoice_day: '',
                    invoice_month: '',
                    shipper_id: '',
                },
                billing_month: '',
                shippers: [],
                vehicles: [],
                mode: 'normal',
                totalSales: 0,
                totalConsumptionTax: 0,
                otherTotals: 0,
                totalSalesTotal: 0,
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy/MM/dd",
                    language: "ja",
                },
                billing: {
                    day: 20,
                    month: ''
                }
            }
        },
        created(){
            this.fetchShippers();
            this.fetchVehicles();
        },
        methods: {
            actionBegin(){

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
            billingPrint(){
                let invoice = this;
                window.location = '/invoice/billing-month-pdf';
//                axios.get("/invoice/billing-month-pdf",this.formData)
//                    .then(function(response){
//                        invoice.showSuccessDialog();
//                    })
//                    .catch(function(error){
//                        invoice.showDialog(error.response.data);
//                    });
            },
            listPrinting(){
                alert('list printing');
            },
            fetchShippers() {
                axios.get(this.shippersUrl)
                    .then(shippers => {
//                        console.log(shippers);
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
                        console.log(data);
                        this.data = data.data;
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
                this.fetchData(this.invoiceUrl
                    +'?weekday=' + this.formData.weekday,
                    + '&vehicle_id=' + this.formData.vehicle_id,
                    + '&invoice_day=' + this.formData.invoice_day,
                    + '&invoice_month=' + this.formData.invoice_month,
                    + '&shipper_id=' + this.formData.shipper_id);
                //this.calculateTotals();
            },
            clear(){
                this.formData.weekday = '';
                this.formData.invoice_day = '';
                this.formData.invoice_month = '';
                this.formData.vehicle_id = '';
                this.formData.shipper_id = '';
            },
            refresh(){
                this.search();
            },
            setEditMode(editMode){
                if (editMode === 'normal') {
                    this.$refs.grid.ej2Instances.setProperties({
                        toolbar: null,
                        editSettings: {
                            allowDeleting: false,
                            allowEditing: false,
                            allowAdding: false,
                        },
                    });
                }
                if (editMode === 'editing') {
                    let toolbarBtns = ['Edit', 'Delete', 'Update', 'Cancel'];
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
                $.each(errors, function (key, value) {
                    message += value[0]; //showing only the first error.
                });
                this.$alert(message);
            },
            showSuccessDialog() {
                this.$alert('Operation successfully done!');
            },
        },
        provide: {
            grid: [Sort, Freeze, Edit, Toolbar]
        },
        computed: {
            calculateTotals(){
                this.totalSales = 10;
                this.totalConsumptionTax = 10;
                this.otherTotals = 20;
                this.totalSalesTotal = 40;
            }
        }
    }
</script>
<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";

    #invoice label {
        width: 150px;
        float: right;
    }
    #invoice .btn {
        width: 100px;
        padding: 10px 5px;
        font-size: 12px;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
    }
    .vdp-datepicker input{
        padding: 5px !important;
    }
</style>
