<template>
    <div id="invoice">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block">{{__('common.back')}}</a>
            </div>
            <div class="col-1">
                <h2 class="text-center text-danger" v-if="this.mode === 'editing'">{{__('common.editing')}}</h2>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5"><h2 class="text-center">{{title}}</h2></div>
                </div>
            </div>
            <div class="col-5">
                <p class="text-right rbtns">
                    <button class="btn btn-lg btn-danger" @click="register" :disabled="this.mode !== 'editing'">
                        {{__('common.register')}}
                    </button>
                    <button class="btn btn-lg btn-danger" @click="edit">{{__('common.edit')}}</button>
                    <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#billingModal">
                        {{__('invoice.billing_month')}}
                    </button>
                    <br>
                    <button class="btn btn-lg btn-success mt-1" @click="listPrinting">
                        {{__('invoice.list_printing')}}
                    </button>
                </p>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col-9">
                <form action="#" class="form-inline" method="post" @submit.prevent="search">
                    <table class="table" border="0">
                        <tr>
                            <td>
                                <label for="shipper">{{__('invoice.shipper')}}</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select name="shipper" id="shipper" v-model="formData.shipper_id" class="form-control">
                                        <option value=""></option>
                                        <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                            {{ shipper. shipper_name1 + " " + shipper. shipper_name2 }}
                                        </option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <label>{{__('invoice.invoice_month')}}</label>
                            </td>
                            <td>
                                <datepicker v-model="formData.invoice_month" :minimumView="'month'" :maximumView="'month'" :bootstrap-styling="true"
                                            :typeable="true" :format="options.monthFormat" :clear-button="true" :language="options.language.ja"
                                ></datepicker>
                            </td>
                            <td>
                                <label>{{__('invoice.invoice_day')}}</label>
                            </td>
                            <td>
                                <select v-model="formData.invoice_day" class="form-control">
                                    <option value=""></option>
                                    <option value="20">{{__('invoice.20th')}}</option>
                                    <option value="30">{{__('invoice.30th')}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>{{__('invoice.stack_date')}}</label>
                            </td>
                            <td align="center">
                                <datepicker v-model="formData.stack_date" :bootstrap-styling="true"
                                        :typeable="true" :format="options.weekday" :clear-button="true" :language="options.language.ja"
                                ></datepicker>
                            </td>
                            <td>
                                <label for="vehicle_no">{{__('invoice.vehicle_no')}}</label>
                            </td>
                            <td class="srch">
                                <select name="vehicle_id" id="vehicle_no" v-model="formData.vehicle_id"
                                        class="form-control">
                                    <option value=""></option>
                                    <option v-for="vehicle in vehicles" :value="vehicle.vehicle_id">
                                        {{ vehicle.vehicle_no }}
                                    </option>
                                </select>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td colspan="2">
                                <button type="submit" class="btn btn-primary">{{__('common.search')}}</button>

                                <button type="reset" class="btn btn-primary" @click.prevent="clear">{{__('common.clear')}}
                                </button>

                                <button type="button" @click="getAggregate" data-toggle="modal" data-target="#aggr"
                                        class="btn btn-primary">
                                    {{__('invoice.aggregate')}}
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270" :frozenColumns="4" :rowSelected='rowSelected'>
            <e-columns>
                <e-column field='stack_point' :headerText='__("invoice.loading_port")' width="150"
                          textAlign="Center"></e-column>
                <e-column field='down_point' :headerText='__("invoice.drop_off")' width="150"
                          textAlign="Center"></e-column>
                <e-column field='vehicle_payment' :headerText='__("invoice.amount")' width="150"
                          textAlign="Right"></e-column>
                <e-column field='down_date' :headerText='__("invoice.delivery_date")' width="100"
                          textAlign="Center"></e-column>
                <e-column field='shipper_name' :headerText='__("invoice.shipper")' width="150"
                          textAlign="Center"></e-column>
                <e-column field='vehicle_no3' :headerText='__("invoice.vehicle_no")' width="150"
                          textAlign="Center"></e-column>
                <e-column field='weight' :headerText='__("invoice.weight")' width="150"></e-column>
                <e-column field='item_price' :headerText='__("invoice.item_price")' textAlign="Right"
                          editType='numericedit'
                          width="100"></e-column>
                <e-column field='status' :headerText='__("invoice.status")' width="100" textAlign="Center"></e-column>
                <e-column field='item_vehicle' :headerText='__("invoice.item_vehicle")' width="100"
                          textAlign="Center"></e-column>
                <e-column field='down_time' :headerText='__("invoice.delivery_time")' width="100"
                          textAlign="Center"></e-column>
                <e-column field='item_completion_date' :headerText='__("invoice.invoice_date")' width="150"
                          textAlign="Center"></e-column>
                <e-column field='item_id' :visible="false" width="0"></e-column>
                <e-column field='shipper_id' :visible="false" width="0"></e-column>
                <e-column field='vehicle_id' :visible="false" width="0"></e-column>
            </e-columns>
        </ejs-grid>
        <div class="row">
            <div class="col-4 offset-md-8">
                <br>
                <table>
                    <tr>
                        <td>
                        </td>
                        <td align="right">
                            <label for="totalSales">{{__('invoice.total_sales')}}</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" disabled="disabled" id="totalSales" v-model="sales">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td align="right">
                            <label for="totalConsumptionTax">{{__('invoice.total_consumption_tax')}}</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" id="totalConsumptionTax" disabled="disabled"
                                       v-model="totalConsumptionTax">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td align="right">
                            <label for="otherTotals">{{__('invoice.other_totals')}}</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" id="otherTotals" disabled="disabled" v-model="otherTotals">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td align="right">
                            <label for="totalSalesTotal">{{__('invoice.sales_total')}}</label>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="text" id="totalSalesTotal" disabled="disabled" v-model="totalSales">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal" id="billingModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">{{__('invoice.print_billing_date')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <p class="text-center">{{__('invoice.select_the_billing_date_you_want_to_print')}}</p>
                            <div class="form-group text-center" style="margin: 20px calc(32.5%)">
                                <label>{{__('invoice.year_and_month')}}</label>
                                <datepicker v-model="billing_month" :minimumView="'month'" :maximumView="'month'"
                                            :format="options.monthFormat"></datepicker>
                            </div>
                            <div class="form-group d-flex justify-content-around">
                                <span>
                                    <input type="radio" name="billing_day" v-model="billing_day" value="20"
                                           id="twenty"/>
                                    <label for="twenty">{{__('invoice.20th')}}</label>
                                </span>
                                <span>
                                    <input type="radio" name="billing_day" value="30" v-model="billing_day"
                                           id="thirty"/>
                                    <label for="thirty">{{__('invoice.30th')}}</label>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <button type="button" class="btn btn-success" @click="billingPrint">
                                {{__('invoice.print')}}
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                {{__('invoice.cancel')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="aggr" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">{{__('invoice.aggregate')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{__('invoice.previous_month_sales')}}</th>
                                    <th>{{__('invoice.payment_last_month')}}</th>
                                    <th>{{__('invoice.carryover')}}</th>
                                    <th>{{__('invoice.sales_completion_date')}}</th>
                                    <th>{{__('invoice.consumption_tax')}}</th>
                                    <th>{{__('invoice.tax_fee')}}</th>
                                    <th>{{__('invoice.total_up_to_last_month')}}</th>
                                    <th>{{__('invoice.total_for_this_month')}}</th>
                                    <th>{{__('invoice.total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{aggregate.lastMonthSales}}</td>
                                    <td>{{aggregate.lastMonthDeposits}}</td>
                                    <td>{{aggregate.carryover}}</td>
                                    <td>{{aggregate.salesCompilationDate}}</td>
                                    <td>{{aggregate.consumptionTax}}</td>
                                    <td>{{aggregate.taxFee}}</td>
                                    <td>{{aggregate.totalLastMonth}}</td>
                                    <td>{{aggregate.totalThisMonth}}</td>
                                    <td>{{aggregate.total}}</td>
                                </tr>
                                </tbody>
                            </table>
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
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    Vue.use(GridPlugin);
    Vue.use(VueSimpleAlert);
    Vue.use(Datepicker);

    export default {
        props: {
            invoiceUrl: {type: String, required: true},
            aggrUrl: {type: String, required: true},
            backUrl: {type: String, required: true},
            shippersUrl: {type: String, required: true},
            vehiclesUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true},
            paymentUrl: {type: String, required: true},
            depositUrl: {type: String, required: true},
            billingMonthUrl: {type: String, required: true},
            billingListUrl: {type: String, required: true},
        },
        components: {
            Datepicker
        },
        data() {
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
                billing_day: '',
                shippers: [],
                vehicles: [],
                mode: 'normal',
                sales: 0,
                totalConsumptionTax: 0,
                otherTotals: 0,
                totalSales: 0,
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy/MM/dd",
                    language: {
                        en: en,
                        ja: ja
                    },
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
                billingListData: {},
                paymentList: [],
                depositList: [],
                aggregate: {
                    lastMonthSales: 0,
                    lastMonthDeposits: 0,
                    carryover: 0,
                    salesCompilationDate: 0,
                    consumptionTax: 0,
                    taxFee: 0,
                    totalLastMonth: 0,
                    totalThisMonth: 0,
                    total: 0
                }
            }
        },
        created() {
            this.fetchShippers();
            this.fetchVehicles();
        },
        methods: {
            actionBegin(args) {
                if (args.requestType == 'delete') {
                    args.cancel = true;
                    if (args.data[0].item_id !== undefined) {
                        this.deleteInvoice(args.data[0].item_id);
                    }
                }
            },
            rowSelected: function (args) {
                this.invoiceData.item_id = args.data.item_id;
                this.invoiceData.shipper_id = args.data.shipper_id;
                this.invoiceData.vehicle_id = args.data.vehicle_id;
                this.invoiceData.billing_recording_date = this.getDate();
                this.invoiceData.billing_deadline_date = args.data.item_completion_date;
            },
            register() {
                const invoiceTable = this;
                if (this.invoiceData.item_id !== '') {
                    axios.post(this.resourceUrl, this.invoiceData)
                        .then(function (response) {
                            invoiceTable.showSuccessDialog(this.__('invoice.selected_item_is_added_to_invoice_list'))
                        })
                        .catch(function (error) {
                            invoiceTable.showDialog(error.response.data);
                        });
                } else {
                    invoiceTable.showWarningDialog(this.__('invoice.please_select_an_item_to_add_to_invoice_list'));
                }
            },
            deleteInvoice(item_id) {
                const invoiceTable = this;
                axios.delete(this.resourceUrl + '/' + item_id)
                    .then(function (response) {
                        invoiceTable.tableUtil.endEditing();
                        invoiceTable.showWarningDialog(this.__('invoice.selected_item_is_removed_from_invoice_list'))
                    })
                    .catch(function (error) {
                        invoiceTable.showDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            billingPrint() {
                if (this.formData.shipper_id === '') {
                    this.showWarningDialog(this.__('invoice.please_select_a_shipper'));
                } else {
                    window.location.href = this.billingMonthUrl
                        + '?shipper_id=' + this.formData.shipper_id
                        + '&billing_month=' + this.billing_month
                        + '&billing_day=' + this.billing_day;
                }
            },
            listPrinting() {
                if (this.data.length > 0) {
                    window.location.href = this.billingListUrl
                        + '?shipper_id=' + this.formData.shipper_id
                        + '&billing_month=' + this.formData.invoice_month
                        + '&billing_day=' + this.formData.invoice_day
                        + '&stack_date=' + this.formData.stack_date
                        + '&vehicle_id=' + this.formData.vehicle_id;
                } else {
                    this.showWarningDialog(this.__('invoice.there_is_no_item_for_your_selection'), {warningTitle: "safdas"});
                }
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
            edit() {
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
            getNormalDate(date, onlyMonth = false) {
                let normalDate = new Date(date);
                let dd = normalDate.getDate();
                let mm = normalDate.getMonth() + 1;

                let yyyy = normalDate.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd;
                }
                if (mm < 10) {
                    mm = '0' + mm;
                }
                if (!onlyMonth) {
                    return yyyy + '-' + mm + '-' + dd;
                } else {
                    return yyyy + '-' + mm;
                }
            },
            search: function () {
                this.formData.stack_date = this.getNormalDate(this.formData.stack_date);
                this.formData.invoice_month = this.getNormalDate(this.formData.stack_date, true);
                console.log(this.formData);
                this.data = this.fetchData(this.invoiceUrl
                    + '?stack_date=' + this.formData.stack_date
                    + '&vehicle_id=' + this.formData.vehicle_id
                    + '&invoice_day=' + this.formData.invoice_day
                    + '&invoice_month=' + this.formData.invoice_month
                    + '&shipper_id=' + this.formData.shipper_id);

                this.fetchPaymentList(this.paymentUrl
                    + '?shipper_id='
                    + this.formData.shipper_id);
                if (this.paymentList.length > 0) {
                    this.calculateTotals();
                }
            },
            getAggregate() {
                axios.get(this.aggrUrl)
                    .then(resp => {
                        this.aggregate = resp.data;
                    });
            },
            calculateTotals: function () {
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
                    if (currentMonth - paymentMonth === 1) {
                        sales = sales + pl[i].payment_amount;
                        other = other + pl[i].other;
                    }
                    totalSales = totalSales + pl[i].payment_amount;
                }
                this.sales = sales;
                this.totalConsumptionTax = sales * 0.1;
                this.otherTotals = other;
                this.totalSales = totalSales;
            },
            clear() {
                this.formData.stack_date = '';
                this.formData.invoice_day = '';
                this.formData.invoice_month = '';
                this.formData.vehicle_no = '';
                this.formData.shipper_id = '';
            },
            refresh() {
                this.search();
            },
            setEditMode(editMode) {
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
                    title: this.__('messages.info_message'),
                    text: text,
                    type: "success",
                    timer: 5000
                });
            },
            showWarningDialog(text) {
                this.$fire({
                    title: this.__('messages.warning'),
                    text: text,
                    type: "warning",
                    timer: 5000
                });
            },
            getDate() {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                let today = new Date();
                let year = today.getFullYear();
                let month = toTwoDigits(today.getMonth() + 1);
                let day = toTwoDigits(today.getDate());
                return `${year}-${month}-${day}`;
            },
        },
        provide: {
            grid: [Sort, Freeze, Edit, Toolbar]
        },

    }
</script>
<style scoped>

    #invoice label {
        width: 100px;
        float: right;
    }

    .rbtns button{
        width: 130px;
    }

    .srch > button {
        width: 55px !important;
    }
</style>
