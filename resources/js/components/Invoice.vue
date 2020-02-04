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
                        <td width="10%">
                            <label for="shipper">Shipper</label>
                        </td>
                        <td with="20%">
                            <div class="col-2">
                            <select name="shipper" id="shipper" v-model="formData.shipper_id" class="form-control">
                                <option value=""></option>
                                <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                    {{ shipper. shipper_name1 + " " + shipper. shipper_name2 }}
                                </option>
                            </select>
                            </div>
                        </td>
                        <td width="15%">
                            <label>Invoice month</label>
                        </td>
                        <td width="15%">
                            <datepicker v-model="formData.invoice_month" :minimumView="'month'" :maximumView="'month'"
                                            :format="options.monthFormat"></datepicker>
                        </td>
                        <td  width="20%">
                            <label>Invoice day</label>
                        </td>
                        <td  width="20%">
                            <select v-model="formData.invoice_day" class="form-control">
                                <option value=""></option>
                                <option value="20">20th</option>
                                <option value="30">30th</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Stack Date</label>
                        </td>
                        <td  with="15%">
                            <datepicker v-model="formData.stack_date" :minimumView="'day'" :format="options.stack_date"
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
                  :allowSorting="true" :height="270" :frozenColumns="4" :rowSelected='rowSelected'>
            <e-columns>
                <e-column field='stack_point' headerText='Loading port' width="150" textAlign="Center"></e-column>
                <e-column field='down_point' headerText='Drop off' width="150" textAlign="Center"></e-column>
                <e-column field='vehicle_payment' headerText='Amount' width="150" textAlign="Right"></e-column>
                <e-column field='down_date' headerText='Delivery Date' width="100" textAlign="Center"></e-column>
                <e-column field='shipper_name' headerText='Shipper' width="150" textAlign="Center"></e-column>
                <e-column field='vehicle_no3' headerText='Vehicle No' width="150" textAlign="Center"></e-column>
                <e-column field='weight' headerText='Weight' width="150"></e-column>
                <e-column field='item_price' headerText='Item price' textAlign="Right" editType='numericedit'
                          width="100"></e-column>
                <e-column field='status' headerText='Status' width="100" textAlign="Center"></e-column>
                <e-column field='item_vehicle' headerText='Item vehicle' width="100" textAlign="Center"></e-column>
                <e-column field='down_time' headerText='Delivery time' width="100" textAlign="Center"></e-column>
                <e-column field='item_completion_date' headerText='Invoice date' width="150"
                          textAlign="Center"></e-column>
                <e-column field='item_id' :visible="false" width="0"></e-column>
                <e-column field='shipper_id' :visible="false" width="0"></e-column>
                <e-column field='vehicle_id' :visible="false" width="0"></e-column>
            </e-columns>
        </ejs-grid>
        <div class="row">
            <div class="col-2 offset-md-10">
                <div class="form-group">
                    <label for="totalSales">Sales</label>
                    <input type="text" disabled="disabled" id="totalSales" v-model="sales">
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
                    <label for="totalSalesTotal">Total Sales</label>
                    <input type="text" id="totalSalesTotal" disabled="disabled" v-model="totalSales">
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
                                <label>Year and Month</label>
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
            paymentUrl: {type: String, required: true},
            depositUrl: {type: String, required: true},
        },
        components: {
            Datepicker
        },
        data(){
            return {
                data: [],
                formData: {
                    stack_date: '',
                    vehicle_id: '',
                    invoice_day: '',
                    invoice_month: '',
                    shipper_id: '',
                },
                billing_month: '',
                shippers: [],
                vehicles: [],
                mode: 'normal',
                sales: 0,
                totalConsumptionTax: 0,
                otherTotals: 0,
                totalSales: 0,
                options: {
                    monthFormat: "yyyy/MM",
                    stack_date: "yyyy/MM/dd",
                    language: "ja",
                },
                billing: {
                    shipper_data: {},
                    previous_month_billing: 0,
                    deposit: 0,
                    offset_discount: 0,
                    carry_over_amount: 0,
                    same_day_sales: 0,
                    consumption_tax: 0,
                    tax_free: 0,
                    invoice_amount: 0,
                    item_data: [],
                },
                invoiceData: {
                    item_id: '',
                    shipper_id: '',
                    vehicle_id: '',
                    billing_recording_date: '',
                    billing_deadline_date: '',
                    payment_record_date: '',
                    invoice_remark: '',
                },
                billingListData: {

                },
                paymentList: [],
                depositList: [],
            }
        },
        created(){
            this.fetchShippers();
            this.fetchVehicles();
        },
        methods: {
            actionBegin(args){
                if(args.requestType == 'delete'){
                    args.cancel = true;
                    if(args.data[0].item_id !== undefined){
                        this.deleteInvoice(args.data[0].item_id);
                    }
                }
            },
            rowSelected: function(args) {
                this.invoiceData.item_id = args.data.item_id;
                this.invoiceData.shipper_id = args.data.shipper_id;
                this.invoiceData.vehicle_id = args.data.vehicle_id;
                this.invoiceData.billing_recording_date = this.getDate();
                this.invoiceData.billing_deadline_date = args.data.item_completion_date;
            },
            register(){
                const invoiceTable = this;
                if (this.invoiceData.item_id !== '') {
                    axios.post(this.resourceUrl, this.invoiceData)
                        .then(function (response) {
                            invoiceTable.showSuccessDialog("Selected item is added to Invoice List.")
                        })
                        .catch(function (error) {
                            invoiceTable.showDialog(error.response.data);
                        });
                } else {
                    invoiceTable.showDialog("Please, select an item to add to invoice list.");
                }
            },
            deleteInvoice(item_id){
                const invoiceTable = this;
                axios.delete(this.resourceUrl+'/'+item_id)
                    .then(function(response){
                        invoiceTable.tableUtil.endEditing();
                        //invoiceTable.showSuccessDialog();
                        //invoiceTable.refresh();
                        invoiceTable.showWarningDialog("Selected item is removed from invoice list.")
                    })
                    .catch(function(error){
                        invoiceTable.showDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            billingPrint(){
                if (this.data.length>0) {
                    this.billing.shipper_data = this.shippers;
                    this.billing.item_data = this.data;
                    let itemList = this.data;
                    let previous_month_billing = 0;

                    let today = new Date();
                    let currentMonth = today.getMonth();
                    for (let i = 0; i < itemList.length; i++) {
                        let completionDate = itemList[i].item_completion_date;
                        let completionMonth = new Date(completionDate).getMonth();
                        if (currentMonth - completionMonth == 1) {
                            previous_month_billing = previous_month_billing + itemList[i].item_price;
                        }
                    }
                    this.billing.previous_month_billing = previous_month_billing;

                    this.fetchDepositList(this.depositUrl
                        + '?shipper_id='
                        + this.formData.shipper_id);
                    let deposit = 0;
                    let depositList = this.depositList;
                    for (let i = 0; i < depositList.length; i++) {
                        let deposit_day = depositList[i].deposit_day;
                        let depositMonth = new Date(deposit_day).getMonth();
                        if (currentMonth - depositMonth == 1) {
                            deposit = deposit + depositList[i].deposit_amount;
                        }
                    }
                    this.billing.deposit = deposit;

                    this.fetchPaymentList(this.paymentUrl
                        + '?shipper_id='
                        + this.formData.shipper_id);
                    let same_day_sales = 0;
                    let paymentList = this.paymentList;
                    for (let i = 0; i < paymentList.length; i++) {
                        let payment_day  = paymentList[i].payment_day;
                        let paymentMonth = new Date(payment_day).getMonth();
                        if (currentMonth - paymentMonth == 1) {
                            same_day_sales = same_day_sales + paymentList[i].payment_amount;
                        }
                    }
                    this.billing.same_day_sales = same_day_sales;
                    this.billing.consumption_tax = previous_month_billing*0.1;


                     // offset_discount: 0, ? don't where it comes from?
                    this.billing.carry_over_amount = deposit - same_day_sales;

                    this.billing.invoice_amount = previous_month_billing + deposit - this.billing.carry_over_amount;
                    this.billing.tax_free = this.billing.invoice_amount - same_day_sales - this.billing.consumption_tax;

                    axios.get("/invoice/billing-month-pdf",this.this.billing)
                        .then(function(response){
                            invoice.showSuccessDialog("Invoice generation is successful.");
                        })
                        .catch(function(error){
                            invoice.showDialog(error.response.data);
                        });
                    window.location = '/invoice/billing-month-pdf';
                }
            },
            listPrinting(){
                const invoiceTable = this;
                invoiceTable.showWarningDialog("This feature is under development.");
            },
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
            edit(){
                this.setEditMode('editing');
                this.$refs.grid.refresh();

            },
            fetchData(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data;
                    })
            },
            fetchPaymentList(url) {
                axios.get(url)
                    .then(response => {
                        this.paymentList = response.data;
                    })
            },
            fetchDepositList(url) {
                axios.get(url)
                    .then(response => {
                        this.depositList = response.data;
                    })
            },
            search: function(){
                this.data = this.fetchData(this.invoiceUrl
                    + '?stack_date=' + this.formData.stack_date,
                    + '&vehicle_id=' + this.formData.vehicle_id,
                    + '&invoice_day=' + this.formData.invoice_day,
                    + '&invoice_month=' + this.formData.invoice_month,
                    + '&shipper_id=' + this.formData.shipper_id);

                this.fetchPaymentList(this.paymentUrl
                    + '?shipper_id='
                    + this.formData.shipper_id);
                if (this.paymentList.length>0){
                    this.calculateTotals();
                }
            },
            calculateTotals: function() {
                /**
                 * calculate total sales
                 */
                let pl = this.paymentList;
                let sales = 0;
                let other = 0;
                let totalSales = 0;
                let today = new Date();
                let currentMonth = today.getMonth();
                for (let i = 0; i < pl.length; i++) {
                    let paymentDate = pl[i].payment_day;
                    let paymentMonth = new Date(paymentDate).getMonth();
                    if (currentMonth - paymentMonth == 1) {
                        sales = sales + pl[i].payment_amount;
                        other = other + pl[i].other;
                    }
                    totalSales = totalSales + pl[i].payment_amount;
                }
                this.sales = sales;
                this.totalConsumptionTax = sales*0.1;
                this.otherTotals = other;
                this.totalSales = totalSales;
            },
            clear(){
                this.formData.stack_date = '';
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
                    let toolbarBtns = ['Delete'];
                    this.$refs.grid.ej2Instances.setProperties({
                        toolbar: toolbarBtns,
                        editSettings: {
                            allowDeleting: true,
                            allowEditing: false,
                            allowAdding: false,
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
            showSuccessDialog(text) {
                this.$fire({
                    title: "Info Message",
                    text: text,
                    type: "success",
                    timer: 5000
                });
            },
            showWarningDialog(text) {
                this.$fire({
                    title: "Warning",
                    text: text,
                    type: "warning",
                    timer: 5000
                });
            },
        },
        provide: {
            grid: [Sort, Freeze, Edit, Toolbar]
        },
        /**computed: {
            calculateTotals(){
                this.totalSales = 10;
                this.totalConsumptionTax = 10;
                this.otherTotals = 20;
                this.totalSalesTotal = 40;
            }
        }*/
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
