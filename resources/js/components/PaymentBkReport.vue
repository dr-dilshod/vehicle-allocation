<template>

    <div id="app">

        <div class="row mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">{{__('common.back')}}</a>
            </div>

            <div class="col-8">
                <h2 class="text-center">{{__('payment.payment_list')}}</h2>
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="year">{{__('payment.payment_year')}}</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="year" v-model="filter.year"
                                v-on:change="changeDays" class="form-control">
                            <option v-for="x in 30" :value="new Date().getFullYear() - x + 1">
                                {{ new Date().getFullYear() - x + 1}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="month">{{__('payment.payment_month')}}</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="month" v-model="filter.month" v-on:change="changeDays" class="form-control">
                            <option v-for="(month, index) in months" :value="index+1">
                                {{ month }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="day">{{__('payment.payment_day')}}</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="day" v-model="filter.day" class="form-control">
                            <option v-for="day in dayCount" :value="day">
                                {{ day }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary">{{__('common.search')}}</button>
                    </div>
                    <div class="form-group ml-1">
                        <button type="reset" class="btn btn-primary">{{__('common.clear')}}</button>
                    </div>
                </form>

            </div>

        </div>

        <form class="form-inline">

            <div class="form-group mx-auto mt-4">
                <label for="tb">{{__('payment.total_billed')}}</label>
                <input id="tb" type="text" class="form-control ml-1 mr-1" disabled /> <span>{{__('payment.yen')}}</span>
                <label for="dt" class="ml-4">{{__('payment.deposit_total')}}</label>
                <input id="dt" type="text" class="form-control ml-1 mr-1" disabled /> <span>{{__('payment.yen')}}</span>
                <label for="to" class="ml-4">{{__('payment.offset')}}</label>
                <input id="to" type="text" class="form-control ml-1 mr-1" disabled /> <span>{{__('payment.yen')}}</span>
                <label for="tc">{{__('payment.total_commission')}}</label>
                <input id="tc" type="text" class="form-control ml-1 mr-1" disabled/> <span>{{__('payment.yen')}}</span>
            </div>
        </form>

    </div>

</template>

<script>

    import Vue from "vue";

    export default {
        props : {
            backUrl : {required : true},
            resourceUrl : {required : true},
        },
        data(){
            return {
                data : {},
                filter : {
                    year : '',
                    month : '',
                    day : ''
                },
                months : [this.__('payment.january'), this.__('payment.february'),this.__('payment.march'),this.__('payment.april'), this.__('payment.may'), this.__('payment.june'), this.__('payment.july'), this.__('payment.august'), this.__('payment.september'), this.__('payment.october'), this.__('payment.november'), this.__('payment.december')],
                dayCount : 0,
            }
        },

        mounted() {

        },

        methods : {
            changeDays(){
                if (this.filter.year != '' && this.filter.month != ''){
                    this.dayCount = new Date(this.filter.year, this.filter.month, 0).getDate();
                }
            },
            search(){

            }
        },

        name : 'PaymentBkReport'

    }


</script>


<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";

</style>