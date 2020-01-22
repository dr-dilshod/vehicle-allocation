<template>

    <div id="app">

        <div class="row mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>

            <div class="col-8">
                <h2 class="text-center">Deposit list</h2>
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="shipper">Shipper</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="shipper" v-model="filter.shipper" class="form-control">
                            <option value=""></option>
                            <option v-for="shipper in shippers" :value="shipper">
                                {{ shipper }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="year">Deposit year</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="year" v-model="filter.year" class="form-control">
                            <option v-for="x in 30" :value="x">
                                {{ new Date().getFullYear() - x + 1}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="month">Deposit month</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="month" v-model="filter.month" class="form-control">
                            <option v-for="month in months" :value="month">
                                {{ month }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="day">Deposit day</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="day" v-model="filter.day" class="form-control">
                            <option v-for="day in days" :value="day">
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
                <label for="to" class="ml-4">Total offset</label>
                <input id="to" type="text" class="form-control ml-1 mr-1" disabled /> <span>yen</span>
            </div>
            <div class="form-group mx-auto mt-3">
                <label for="tc">Total commission</label>
                <input id="tc" type="text" class="form-control ml-1 mr-1" disabled/> <span>yen</span>
                <label for="ot" class="ml-4">Others</label>
                <input id="ot" type="text" class="form-control ml-1 mr-1" disabled /> <span>yen</span>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col-2 text-right">Transfer</div>
            <div class="col-3"><input type="text" class="form-control" disabled/></div>
            <div class="col-1">yen</div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Other</div>
            <div class="col-3"><input type="text" class="form-control" disabled/></div>
            <div class="col-1">yen</div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Transfer fee</div>
            <div class="col-3"><input type="text" class="form-control" disabled/></div>
            <div class="col-1">yen</div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Total deposit amount</div>
            <div class="col-3 "><input type="text" class="form-control" disabled/></div>
            <div class="col-1">yen</div>
            <div class="col-2 text-right">Invoice</div>
            <div class="col-3"><input type="text" class="form-control" disabled/></div>
            <div class="col-1">yen</div>
        </div>



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
                    shipper : '',
                    year : '',
                    month : '',
                    day : ''
                },
            }

        },

        mounted() {

        },

        props : {

        },

        methods : {

        },

        name : 'DepositList'

    }


</script>


<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";

</style>