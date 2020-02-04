<template>

    <div id="app">

        <div class="row mt-4 mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">{{__('payment.back')}}</a>
            </div>

            <div class="col-6">
                <h2 class="text-center">{{__('payment.payment_registration')}}</h2>
            </div>
            <div class="col-4 text-right">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click = "create" :disabled="!registerMode">{{__('payment.register')}}</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click = "update" :disabled="!editable">{{__('payment.edit')}}</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click = "remove" :disabled="!editable">{{__('payment.delete')}}</button>
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="shipper">{{__('payment.shipper')}}</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="shipper" v-model="filter.shipper" class="form-control" style="max-width:200px;" required>
                            <option value=""></option>
                            <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                {{shipper.fullname}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="year">{{__('payment.payment_year')}}</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="year" v-model="filter.year"
                                v-on:change="changeDays" class="form-control" required>
                            <option value=""></option>
                            <option v-for="x in 30" :value="new Date().getFullYear() - x + 1">
                                {{ new Date().getFullYear() - x + 1}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="month">{{__('payment.payment_month')}}</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="month" v-model="filter.month" v-on:change="changeDays" class="form-control" required>
                            <option value=""></option>
                            <option v-for="(month, index) in months" :value="index+1">
                                {{ month }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="day">{{__('payment.payment_date')}}</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="day" v-model="filter.day" class="form-control" required>
                            <option value=""></option>
                            <option v-for="day in dayCount" :value="day">
                                {{ day }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary">{{__('payment.search')}}</button>
                    </div>
                    <div class="form-group ml-1">
                        <button type="reset" @click='clear' class="btn btn-primary">{{__('payment.clear')}}</button>
                    </div>
                </form>

            </div>

        </div>

        <form>
            <table cellpadding="5" class="mt-4">

                <tbody>
                <tr>
                    <td class="text-right">{{__('payment.shipper')}}</td>
                    <td>
                        <select class="form-control" v-model="payment.shipper_id" :disabled="!registerMode" required>
                            <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                {{shipper.fullname}}
                            </option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <input type="hidden" v-model="payment.payment_id"/>
                    <td class="text-right">{{__('payment.payment_date')}}</td>
                    <td>
                        <datepicker v-model="payment.payment_day" :disabled="!registerMode" required
                                    :bootstrap-styling="true" :typeable="true" :format="options.weekday"
                                    :clear-button="true" :language="options.language.ja"></datepicker>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right">{{__('payment.transfer')}}</td>
                    <td><input type="text" class="form-control" v-model="payment.payment_amount" required/></td>
                    <td>{{__('payment.yen')}}</td>
                </tr>
                <tr>
                    <td class="text-right">{{__('payment.offset')}}</td>
                    <td><input type="text" class="form-control" v-model="offset" disabled/></td>
                    <td>{{__('payment.yen')}}</td>
                </tr>
                <tr>
                    <td class="text-right">{{__('payment.other')}}</td>
                    <td><input type="text" class="form-control" v-model="payment.other"/></td>
                    <td>{{__('payment.yen')}}</td>
                </tr>
                <tr>
                    <td class="text-right">{{__('payment.transfer_fee')}}</td>
                    <td><input type="text" class="form-control" v-model="payment.fee"/></td>
                    <td>{{__('payment.yen')}}</td>
                </tr>
                </tbody>

                <tfoot>
                <tr>
                    <td class="text-right">{{__('payment.total_credit_amount')}}</td>
                    <td><input type="text" class="form-control" v-model="total" disabled/></td>
                    <td>{{__('payment.yen')}}</td>
                    <td> &nbsp;&nbsp;&nbsp; </td>
                    <td class="text-right">{{__('payment.outgoing_balance')}}</td>
                    <td><input type="text" class="form-control" v-model="invoice" disabled/></td>
                    <td>{{__('payment.yen')}}</td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>

</template>

<script>

    import Vue from "vue";
    import Datepicker from "vuejs-datepicker";
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    export default {
        components: {
            Datepicker
        },
        props : {
            backUrl : {required : true},
            resourceUrl : {required : true},
            shipperUrl : {required : true},
        },
        data(){
            return {
                payment : {
                    payment_id : null,
                    shipper_id : null,
                    payment_day : null,
                    payment_amount : null,
                    other : null,
                    fee : null,
                },
                offset : null,
                total : null,
                invoice : null,
                editable : false,
                registerMode : true,
                filter : {
                    shipper : '',
                    year : '',
                    month : '',
                    day : ''
                },
                shippers : [],
                months : [this.__('payment.january'), this.__('payment.february'),this.__('payment.march'),this.__('payment.april'), this.__('payment.may'), this.__('payment.june'), this.__('payment.july'), this.__('payment.august'), this.__('payment.september'), this.__('payment.october'), this.__('payment.november'), this.__('payment.december')],
                dayCount : 0,
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy-MM-dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
            }
        },

        mounted() {
            this.fetchShippers();
        },

        methods : {
            fetchShippers(){
                let self = this;
                axios.get(this.shipperUrl)
                    .then(response =>
                        self.shippers = response.data
                    ).catch (error =>
                    alert(error)
                )
            },
            changeDays(){
                if (this.filter.year != '' && this.filter.month != ''){
                    this.dayCount = new Date(this.filter.year, this.filter.month, 0).getDate();
                }
            },
            search(){
                let self = this;
                axios.post(this.resourceUrl+'/filter',this.filter)
                    .then(response => {
                        self.payment = response.data.payment;
                        self.offset = response.data.offset;
                        self.total = response.data.total;
                        self.invoice = response.data.invoice;
                        self.editable = response.data.unique;
                        self.registerMode = false;
                    }).catch (error => {
                    alert(error);
                    self.clear();
                })
            },
            create(){
                let self = this;
                this.payment.payment_day = this.payment.payment_day.toISOString().slice(0,10);
                axios.post(this.resourceUrl, this.payment)
                    .then(response => {
                        alert('Payment created successfully');
                        self.clear();
                    }).catch(error => {
                    alert("Error while creating payment")
                })
            },
            update(){
                let self = this;
                axios.put(this.resourceUrl+'/'+this.payment.payment_id, this.payment)
                    .then(response => {
                        alert('Payment updated successfully');
                    }).catch(error => {
                    alert("Error while updating payment")
                })
            },
            remove(){
                let self = this;
                axios.delete(this.resourceUrl+'/'+this.payment.payment_id)
                    .then(response => {
                        alert('Payment deleted successfully');
                        self.clear();
                    }).catch(error => {
                    alert('Error on deleting payment');
                })
            },
            clear(){
                this.payment = {
                    payment_id : null,
                    shipper_id : null,
                    payment_day : null,
                    payment_amount : null,
                    other : null,
                    fee : null,
                };
                this.offset = null;
                this.total = null;
                this.invoice = null;
                this.editable = false;
                this.registerMode = true;
                this.filter = {
                    shipper : '',
                    year : '',
                    month : '',
                    day : ''
                };
            }
        },

        name : 'PaymentRegistration'

    }


</script>


<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";

</style>