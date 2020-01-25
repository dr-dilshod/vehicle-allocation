<template>

    <div id="app">

        <div class="row mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>

            <div class="col-8">
                <h2 class="text-center">Payment list</h2>
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="year">Payment year</label>
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
                        <label for="month">Payment month</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="month" v-model="filter.month" v-on:change="changeDays" class="form-control">
                            <option v-for="(month, index) in months" :value="index+1">
                                {{ month }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="day">Payment day</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="day" v-model="filter.day" class="form-control">
                            <option v-for="day in dayCount" :value="day">
                                {{ day }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    <div class="form-group ml-1">
                        <button type="reset" class="btn btn-primary">Clear</button>
                    </div>
                </form>

            </div>

        </div>

        <form class="form-inline">

            <div class="form-group mx-auto mt-4">
                <label for="tb">Total billed</label>
                <input id="tb" type="text" class="form-control ml-1 mr-1" disabled /> <span>yen</span>
                <label for="dt" class="ml-4">Deposit total</label>
                <input id="dt" type="text" class="form-control ml-1 mr-1" disabled /> <span>yen</span>
                <label for="to" class="ml-4">Offset</label>
                <input id="to" type="text" class="form-control ml-1 mr-1" disabled /> <span>yen</span>
                <label for="tc">Total commission</label>
                <input id="tc" type="text" class="form-control ml-1 mr-1" disabled/> <span>yen</span>
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
                months : ['January', 'February','March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
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