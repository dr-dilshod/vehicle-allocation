<template>

    <div id="app">

        <div class="row mt-4 mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>

            <div class="col-6">
                <h2 class="text-center">Deposit list</h2>
            </div>
            <div class="col-4 text-right">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2">Register</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3">Edit</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3">Delete</button>
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
                                {{ shipper}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="year">Deposit year</label>
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
                        <label for="month">Deposit month</label>
                    </div>
                    <div class="form-group ml-1">
                        <select id="month" v-model="filter.month" v-on:change="changeDays" class="form-control">
                            <option v-for="(month, index) in months" :value="index+1">
                                {{ month }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="day">Deposit day</label>
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

        <table cellpadding="5" class="mt-4">

            <tbody>
            <tr>
                <td class="text-right">Shipper</td>
                <td>
                    <select class="form-control">
                        <option>Shipper 1</option>
                        <option>Shipper 2</option>
                        <option>Shipper 3</option>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="text-right">Payment</td>
                <td><input type="date" class="form-control" /></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-right">Transfer</td>
                <td><input type="text" class="form-control"/></td>
                <td>yen</td>
            </tr>
            <tr>
                <td class="text-right">Offset</td>
                <td><input type="text" class="form-control" /></td>
                <td>yen</td>
            </tr>
            <tr>
                <td class="text-right">Other</td>
                <td><input type="text" class="form-control"/></td>
                <td>yen</td>
            </tr>
            <tr>
                <td class="text-right">Transfer fee</td>
                <td><input type="text" class="form-control"></td>
                <td>yen</td>
            </tr>
            </tbody>

            <tfoot>
            <tr>
                <td class="text-right">Total credit amount</td>
                <td><input type="text" class="form-control" disabled/></td>
                <td>yen</td>
                <td> &nbsp;&nbsp;&nbsp; </td>
                <td class="text-right">Invoice balance</td>
                <td><input type="text" class="form-control" disabled/></td>
                <td>yen</td>
            </tr>
            </tfoot>
        </table>

    </div>

</template>

<script>

    import Vue from "vue";

    export default {
        props : {
            backUrl : {required : true},
            resourceUrl : {required : true},
            shipperUrl : {required : true},
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
                shippers : [],
                months : ['January', 'February','March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                dayCount : 0,
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
                axios.post(this.resourceUrl,this.filter)
                    .then(response =>
                        console.log(response)
                    ).catch (error =>
                        console.log(error)
                    )
            }
        },

        name : 'DepositList'

    }


</script>


<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";

</style>