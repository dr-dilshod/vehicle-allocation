<template>
    <div id="invoice">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-2">
                        <h2 class="text-center text-danger" :hidden="!editMode">{{__('common.editing')}}</h2>
                    </div>
                    <div class="col-2"><h2 class="text-center mt-1">{{title}}</h2></div>
                    <div class="col-8">
                        <p class="text-right">
                            <button class="btn btn-lg btn-danger btn-fixed-width" @click="saveConfirmModal"
                                    :disabled="!editMode">{{__('common.register')}}
                            </button>
                            <button class="btn btn-lg btn-danger btn-fixed-width" @click="toEditMode" :disabled="editMode">
                                {{__('common.edit')}}
                            </button>
                            <button class="btn btn-lg btn-danger btn-fixed-width" @click="deleteConfirmModal"
                                    :disabled="!editMode">{{__('common.delete')}}
                            </button>
                            <button class="btn btn-lg btn-success btn-fixed-width" data-toggle="modal" data-target="#billingModal">
                                {{__('invoice.billing_month')}}
                            </button>
                            <br>
                            <button class="btn btn-lg btn-success mt-1 btn-fixed-width" @click="listPrinting">
                                {{__('invoice.list_printing')}}
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: -30px">
            <div class="col-12">
                <form @submit.prevent="search">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group row">
                                <label for="shipper" class="col-4 text-right">{{__('invoice.shipper')}}</label>
                                <select name="shipper" id="shipper" v-model="formData.shipper_id"
                                        class="form-control col-8">
                                    <option value=""></option>
                                    <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                        {{ shipper.shipper_name1 + " " + shipper.shipper_name2 }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group row">
                                <label class="col-4 text-right">{{__('invoice.invoice_month')}}</label>
                                <datepicker v-model="formData.invoice_month" :minimumView="'month'"
                                            :maximumView="'month'" :bootstrap-styling="true"
                                            :format="options.monthFormat" :clear-button="true"
                                            :language="options.language.ja" class="col-8"
                                ></datepicker>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group row">
                                <label class="col-4 text-right">{{__('invoice.invoice_day')}}</label>
                                <select v-model="formData.invoice_day" class="form-control col-8">
                                    <option value=""></option>
                                    <option value="20">{{__('invoice.20th')}}</option>
                                    <option value="30">{{__('invoice.30th')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group row">
                                <label class="col-4 text-right">{{__('invoice.stack_date')}}</label>
                                <datepicker v-model="formData.stack_date" :bootstrap-styling="true"
                                            :format="options.weekday" :clear-button="true" :language="options.language.ja" class="col-8"
                                ></datepicker>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group row">
                                <label for="vehicle_no" class="col-4 text-right">{{__('invoice.vehicle_no')}}</label>
                                <select name="vehicle_id" id="vehicle_no" v-model="formData.vehicle_id"
                                        class="form-control col-8">
                                    <option value=""></option>
                                    <option v-for="vehicle in vehicles" :value="vehicle.vehicle_id">
                                        {{ vehicle.vehicle_no }}
                                    </option>
                                </select>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <button type="submit" class="btn btn-fixed-width btn-primary" :disabled="editMode">{{__('common.search')}}
                            </button>
                            <button type="reset" class="btn btn-fixed-width btn-primary" @click.prevent="clear" :disabled="editMode">
                                {{__('common.clear')}}
                            </button>
                            <button type="button" @click="getAggregate" data-toggle="modal" data-target="#aggr"
                                    class="btn btn-fixed-width btn-primary" :disabled="editMode">
                                {{__('invoice.aggregate')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="table-scroll" class="table-scroll table-scroll2">
            <table class="table table-custom-inputs">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sticky-col first-sticky-col" style="text-align: center;">荷主</th>
                    <th scope="col" class="sticky-col second-sticky-col" style="text-align: center;">積地</th>
                    <th scope="col" class="sticky-col third-sticky-col last-sticky-col" style="text-align: center;">車輌No</th>
                    <th scope="col" style="text-align: center;">積日</th>
                    <th scope="col" style="text-align: center;">降日</th>
                    <th scope="col" style="text-align: center;">降地</th>
                    <th scope="col" style="text-align: center;">t数</th>
                    <th scope="col" style="text-align: center;">単価</th>
                    <th scope="col" style="text-align: center;">金額</th>
                    <th scope="col" style="text-align: center;">高速代</th>
                    <th scope="col" style="text-align: center;">庸車先社名</th>
                    <th scope="col" style="text-align: center;">庸車先車輌No</th>
                    <th scope="col" style="text-align: center;">庸車先支払金額</th>
                    <th scope="col" style="text-align: center;">支払高速代</th>
                    <th scope="col" class="primary-key">Item Id</th>
                    <th scope="col" class="primary-key">Shipper Id</th>
                    <th scope="col" class="primary-key">Vehicle Id</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(invoice, index) in data" :data-key="invoice.invoice_id" :index="index"
                    :hidden="invoice.delete_flg === 1" v-on:click="clickRow($event, index)">
                    <td class="sticky-col first-sticky-col" width="200">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="invoice.shipper_id"
                                :disabled="!editMode" width="200">
                            <option v-for="shipper in shippers" :value="shipper.shipper_id"
                                    :selected="invoice.shipper_id === shipper.shipper_id" >{{shipper.shipper_name1}}
                            </option>
                        </select>
                    </td>
                    <td class="sticky-col dp second-sticky-col">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="invoice.stack_point"
                                :disabled="!editMode" width="200">
                            <option v-for="sp in stack_points" :value="sp.stack_point"
                                    :selected="invoice.stack_point === sp.stack_point">{{sp.stack_point}}
                            </option>
                        </select>

                    </td>
                    <td class="sticky-col third-sticky-col last-sticky-col">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="invoice.vehicle_no3"
                                :disabled="!editMode" width="200" v-on:focusout="setVehicleCompany">
                            <option v-for="v in vehicles" :value="v.vehicle_no"
                                    :selected="invoice.vehicle_no3 === v.vehicle_no">{{invoice.vehicle_no3}}
                            </option>
                        </select>
                    </td>
                    <td width="160">
                        <datepicker v-on:change="addRowOnChange" v-model="invoice.stack_date" :value="new Date(invoice.stack_date)" :bootstrap-styling="true"
                                    :format="options.weekday" :clear-button="false"
                                    :language="options.language.ja"
                                    class="form-control" :disabled="!editMode"
                        ></datepicker>
                    </td>
                    <td width="160">
                        <datepicker v-on:change="addRowOnChange" v-model="invoice.down_date" :value="new Date(invoice.down_date)" :bootstrap-styling="true"
                                    :format="options.weekday" :clear-button="false"
                                    :language="options.language.ja"
                                    class="form-control" :disabled="!editMode"
                        ></datepicker>
                    </td>
                    <td width="200" class="date">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="invoice.down_point"
                                :disabled="!editMode" width="200">
                            <option v-for="dp in down_points" :value="dp.down_point"
                                    :selected="invoice.down_point === dp.down_point">{{dp.down_point}}
                            </option>
                        </select>
                    </td>
                    <td width="100">
                        <input v-on:change="addRowOnChange" type="text" v-model="invoice.weight"
                               class="form-control" :disabled="!editMode"/>
                    </td>
                    <td>
                        <money v-on:change="addRowOnChange" type="text" class="form-control"
                               v-model="invoice.item_price" v-bind="money" :disabled="!editMode"/>
                    </td>
                    <td>
                        <money v-on:change="addRowOnChange" type="text" class="form-control"
                               v-model="invoice.vehicle_payment" v-bind="money" :disabled="!editMode"/>
                    </td>
                    <td>
                        <money v-on:change="addRowOnChange" type="text" class="form-control"
                               v-model="invoice.highway_cost" v-bind="money" :disabled="!editMode"/>
                    </td>
                    <td width="200">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="invoice.vehicle_company_name"
                                :disabled="!editMode" width="200" v-on:focusout="setVehicleNo">
                            <option v-for="v in vehicles" :value="v.company_name"
                                    :selected="invoice.vehicle_company_name === v.company_name">{{v.company_name}}
                            </option>
                        </select>
                    </td>
                    <td width="120">
                        <input v-on:change="addRowOnChange" type="text" v-model="invoice.vehicle_no3"
                               class="form-control" :disabled="!editMode"/>
                    </td>
                    <td width="200">
                        <money v-on:change="addRowOnChange" type="text" class="form-control"
                               v-model="invoice.vehicle_payment" v-bind="money" :disabled="!editMode"/>
                    </td>
                    <td width="100">
                        <money v-on:change="addRowOnChange" type="text" class="form-control"
                               v-model="invoice.pay_highway_cost" v-bind="money" :disabled="!editMode"/>
                    </td>
                    <td class="primary-key">
                        <input type="text" class="form-control" v-model="invoice.invoice_id" :disabled="true"/>
                        <input type="text" class="form-control" v-model="invoice.item_id" :disabled="true"/>
                        <input type="text" class="form-control" v-model="invoice.shipper_id" :disabled="true"/>
                        <input type="text" class="form-control" v-model="invoice.vehicle_id" :disabled="true"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
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
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title">{{__('invoice.print_billing_date')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-5">
                            <p class="text-center">{{__('invoice.select_the_billing_date_you_want_to_print')}}</p>
                            <div class="form-group row text-center" style="margin: 20px calc(25%)">
                                <label class="col-4 mt-2">{{__('invoice.year_and_month')}}</label>
                                <datepicker v-model="billing_month" :minimumView="'month'" :maximumView="'month'" :bootstrap-styling="true"
                                            :format="options.monthFormat" :clear-button="true" :language="options.language.ja" class="col-8"
                                ></datepicker>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <input type="radio" name="billing_day" v-model="billing_day" value="20"
                                       id="twenty"/>
                                <label for="twenty" class="ml-3">{{__('invoice.20th')}}</label>
                                <input type="radio" name="billing_day" value="30" v-model="billing_day"
                                       id="thirty" class="ml-3"/>
                                <label for="thirty" class="ml-3">{{__('invoice.30th')}}</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-fixed-width btn-success" @click="billingPrint">
                                {{__('invoice.print')}}
                            </button>
                            <button type="button" class="btn btn-fixed-width btn-warning ml-2" data-dismiss="modal">
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
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title">{{__('invoice.aggregate')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-custom-inputs">
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
    import {en, ja} from 'vuejs-datepicker/dist/locale'
    import StickTableMixin from '../utils/StickyTableMixin'
    import VueTheMask from 'vue-the-mask'
    import Vue from "vue";
    import Datepicker from "vuejs-datepicker";
    import {Money} from 'v-money'

    Vue.use(Datepicker);
    Vue.use(VueSimpleAlert);
    Vue.use(VueTheMask);

    export default {
        props: {
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
            stackPointsUrl: {type: String, required: true},
            downPointsUrl: {type: String, required: true},
        },
        mixins : [
            StickTableMixin
        ],
        components: {
            Datepicker,
            Money
        },
        data() {
            return {
                formData: {
                    stack_date: '',
                    vehicle_id: '',
                    invoice_day: '',
                    invoice_month: '',
                    shipper_id: '',
                },
                money: {
                    thousands: ',',
                    prefix: '¥',
                    precision: 0,
                    masked: false
                },
                billing_month: '',
                billing_day: '',
                shippers: [],
                stack_points: [],
                down_points: [],
                vehicles: [],
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
                data: [],
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
                },
                emptyRow : {
                    invoice_id: null,
                    item_id: null,
                    shipper_id: null,
                    vehicle_id: null,
                    shipper_name: '',
                    stack_date: new Date(),
                    vehicle_no: '',
                    stack_point: '',
                    down_point: '',
                    weight: '',
                    item_price: 0,
                    vehicle_payment: 0,
                    highway_cost: 0,
                    vehicle_company_name: '',
                    vehicle_no3: '',
                    per_vehicle: 0,
                    pay_highway_cost: 0,
                }
            }
        },
        mounted() {
            this.fetchShippers();
            this.fetchStackPoints();
            this.fetchDownPoints();
            this.fetchVehicles();
            this.fetchInvoiceData(this.resourceUrl);
            this.setVehicleCompany();
        },
        methods: {
            setVehicleCompany() {
                for (let i = 0; i < this.vehicles.length; i++) {
                    if (this.data.vehicle_no3 === this.vehicles[i].vehicle_no) {
                        this.data.vehicle_company_name = this.vehicles[i].company_name;
                    }
                }
            },
            setVehicleNo() {
                for (let i = 0; i < this.vehicles.length; i++) {
                    if (this.data.vehicle_company_name === this.vehicles[i].company_name) {
                        this.data.vehicle_no3 = this.vehicles[i].vehicle_no;
                    }
                }
            },
            billingPrint() {
                if (this.formData.shipper_id === '') {
                    this.showWarningDialog(this.__('invoice.please_select_a_shipper'));
                } else {
                    let billingMonth = '';
                    if(typeof this.billing_month === 'object'){
                        billingMonth = this.billing_month.toISOString();
                        billingMonth = billingMonth.substr(0,4)+'/'+billingMonth.substr(5,2);
                    }
                    window.location.href = this.billingMonthUrl
                        + '?shipper_id=' + this.formData.shipper_id
                        + '&billing_month=' + billingMonth
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
            fetchStackPoints() {
                axios.get(this.stackPointsUrl)
                    .then(stack => {
                        this.stack_points = stack.data
                    });
            },
            fetchDownPoints() {
                axios.get(this.downPointsUrl)
                    .then(down => {
                        this.down_points = down.data
                    });
            },

            fetchVehicles() {
                axios.get(this.vehiclesUrl)
                    .then(vehicles => {
                        this.vehicles = vehicles.data
                    });
            },
            back() {
                if (this.isDataChanged()) {
                    this.confirmBack();
                } else {
                    window.location.href = this.backUrl;
                }
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
                if(date === '') return '';
                let normalDate = new Date(date);
                if(typeof normalDate === 'object'){
                    if (!onlyMonth) {
                        return normalDate.toISOString().slice(0,10);
                    } else {
                        return normalDate.toISOString().slice(0,7);
                    }
                }
                return '';
            },
            search() {
                let stack_date = this.getNormalDate(this.formData.stack_date);
                let invoice_month = this.getNormalDate(this.formData.invoice_month, true);
                axios.get(this.resourceUrl + '/filter' + '?stack_date=' + stack_date
                    + '&vehicle_id=' + this.formData.vehicle_id
                    + '&invoice_day=' + this.formData.invoice_day
                    + '&invoice_month=' + invoice_month
                    + '&shipper_id=' + this.formData.shipper_id)
                        .then(response => {
                            this.data = response.data.map(el => {
                                return {
                                    invoice_id : el.invoice_id,
                                    item_id: el.item_id,
                                    shipper_id: el.shipper_id,
                                    vehicle_id: el.vehicle_id,
                                    stack_point: el.stack_point,
                                    down_point: el.down_point,
                                    stack_date: el.stack_date,
                                    vehicle_payment: el.vehicle_payment,
                                    down_date: el.down_date,
                                    shipper_name: el.shipper_name,
                                    vehicle_no3: el.vehicle_no3,
                                    weight: el.weight,
                                    item_price: el.item_price,
                                    status: el.status,
                                    item_vehicle: el.item_vehicle,
                                    down_time: el.down_time,
                                    highway_cost: el.highway_cost,
                                    pay_highway_cost: el.pay_highway_cost
                                };
                            });
                            this.resetTable({data: this.data});
                    });
                this.fetchPaymentList(this.paymentUrl
                    + '?shipper_id='
                    + this.formData.shipper_id);
                if (this.paymentList.length > 0) {
                    this.calculateTotals();
                }
            },
            fetchInvoiceData(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data.map(el => {
                            return {
                                invoice_id : el.invoice_id,
                                item_id: el.item_id,
                                shipper_id: el.shipper_id,
                                vehicle_id: el.vehicle_id,
                                stack_point: el.stack_point,
                                down_point: el.down_point,
                                vehicle_payment: el.vehicle_payment ?? 0,
                                down_date: el.down_date,
                                shipper_name: el.shipper_name,
                                stack_date: el.stack_date,
                                vehicle_no3: el.vehicle_no3,
                                weight: el.weight,
                                item_price: el.item_price ?? 0,
                                status: el.status,
                                item_vehicle: el.item_vehicle,
                                down_time: el.down_time,
                                highway_cost: el.highway_cost ?? 0,
                                pay_highway_cost: el.pay_highway_cost ?? 0
                            };
                        });
                        this.resetTable({data: this.data});
                    });
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
                this.formData.vehicle_id = '';
                this.formData.shipper_id = '';
                this.fetchInvoiceData(this.resourceUrl);
            },
            getDate() {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                let today = new Date();
                let year = today.getFullYear();
                let month = toTwoDigits(today.getMonth() + 1);
                let day = toTwoDigits(today.getDate());
                return `${year}-${month}-${day}`;
            },
            refresh() {
                this.editMode = false;
                this.clear();
                this.fetchInvoiceData(this.resourceUrl);
            }
        },
        name: 'Invoice',
    }
</script>
<style scoped>
    .rbtns button{
        width: 130px;
    }
    .vdp-datepicker{
        padding: 0;
        border: none;
    }
</style>
