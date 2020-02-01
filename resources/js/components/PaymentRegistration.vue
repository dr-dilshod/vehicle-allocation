<template>

    <div id="app">

        <div class="row mb-4">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h2 ref="editTitle" class="text-center text-danger">Editing</h2>
            </div>

            <div class="col-4 align-items-end">
                <h2 class="text-center">Payment registration</h2>
            </div>
            <div class="col-4 ">
                <div class="form-group text-right">
                    <button ref="" class="btn btn-lg btn-danger p-1 pl-2 pr-2">Register</button>
                    <button ref="" class="btn btn-lg btn-danger p-1 pl-3 pr-3">Edit</button>
                    <button ref="" class="btn btn-lg btn-danger p-1 pl-3 pr-3">Delete</button>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="">
                <form action="#" class="form-inline float-sm-right col-12" @submit.prevent="search"  @reset.prevent="">
                        <div class="form-group ml-3">
                            <label for="shipper">Shipper</label>
                        </div>
                        <div class="form-group ml-1">
                            <select id="shipper" v-model="filter.shipper" class="form-control">
                                <option value=""></option>
                                <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                    {{ shipper.shipper_name1+" "+shipper.shipper_name2}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <label for="year">Payment <br>year</label>
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
                            <label for="month">Payment <br>month</label>
                        </div>
                        <div class="form-group ml-1">
                            <select id="month" v-model="filter.month" v-on:change="changeDays" class="form-control">
                                <option v-for="(month, index) in months" :value="index+1">
                                    {{ month }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <label for="day">Payment <br>day</label>
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
        <div class="row mt-5">
            <div class="col-2 text-right">Shipper</div>
            <div class="col-3">
                <select name="" id="" class="form-control">
                    <option value="">Shipper name1 </option>
                    <option value="">Shipper name2 </option>
                    <option value="">Shipper name3 </option>
                    <option value="">Shipper name4 </option>
                </select>
            </div>
            <div class="col-1"></div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Payment date</div>
            <div class="col-3"><input type="date" class="form-control"/></div>
            <div class="col-1"></div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Transfer</div>
            <div class="col-3"><input type="text" class="form-control" /></div>
            <div class="col-1">yen</div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Offset</div>
            <div class="col-3"><input type="text" class="form-control" /></div>
            <div class="col-1">yen</div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Other</div>
            <div class="col-3"><input type="text" class="form-control" /></div>
            <div class="col-1">yen</div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Transfer fee</div>
            <div class="col-3"><input type="text" class="form-control" /></div>
            <div class="col-1">yen</div>
        </div>
        <div class="row mt-3">
            <div class="col-2 text-right">Total payment</div>
            <div class="col-3 "><input type="text" class="form-control" disabled/></div>
            <div class="col-1">yen</div>
            <div class="col-2 text-right">Outgoing balance</div>
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
            searchUrl : {required : true},
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
            this.fetchShippers(this.shipperUrl);
        },

        methods : {
            fetchShippers(url){
                axios.get(url)
                    .then(response =>
                        this.shippers = response.data
                    ).catch (
                        error => alert(error)
                    );

                console.log('this.shippers=');
                console.log(this.shippers);
            },
            changeDays(){
                if (this.filter.year != '' && this.filter.month != ''){
                    this.dayCount = new Date(this.filter.year, this.filter.month, 0).getDate();
                }
            },
            search(){
                console.log(this.filter.shipper);
                // console.log(this.filter.year);
                // console.log(this.filter.month);
                // console.log(this.filter.day);
                let result;
                axios.get(this.searchUrl)
                    .then(response =>
                        result = response.data
                    ).catch (
                    error => alert(error)
                );
                console.log('this.shippers=');
                console.log(this.searchUrl);
                console.log(result);
            }
        },

        name : 'PaymentRegistration'

    }


</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
</style>
