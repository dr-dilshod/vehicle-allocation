<template>
    <div id="top">
        <div class="row p-4">
            <div class="col-4">
                <form action="#" role="form">
                    <div class="form-group row">
                        <label for="year" class="col-2 offset-2">{{__('top.Year')}}</label>
                        <select class="form-control col-7" name="year" id="year" v-model="selectedYear">
                            <option v-for="year in years">{{year}}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="month" class="col-2 offset-2">{{__('top.Month')}}</label>
                        <select class="form-control col-7" name="month" id="month" v-model="selectedMonth">
                            <option value="01">{{__('top.january')}}</option>
                            <option value="02">{{__('top.february')}}</option>
                            <option value="03">{{__('top.march')}}</option>
                            <option value="04">{{__('top.april')}}</option>
                            <option value="05">{{__('top.may')}}</option>
                            <option value="06">{{__('top.june')}}</option>
                            <option value="07">{{__('top.july')}}</option>
                            <option value="08">{{__('top.august')}}</option>
                            <option value="09">{{__('top.september')}}</option>
                            <option value="10">{{__('top.october')}}</option>
                            <option value="11">{{__('top.november')}}</option>
                            <option value="12">{{__('top.december')}}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-9 offset-2 pr-0">
                            <button type="submit" id="display" class="btn btn-lg btn-block btn-primary" @click.prevent="fetchByMonth">{{__('top.display')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <table class="table fixed-header">
                    <thead>
                    <tr>
                        <th class="text-center">{{__('top.driver_name')}}</th>
                        <th class="text-center">{{__('top.amount')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in tableData">
                        <td class="text-center">{{ item.driver_name }}</td>
                        <td class="text-center">{{ item.amount }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        name: 'Top',
        props: {
            fetchUrl: {type: String, required: true},
            monthUrl: {type: String, required: true},
        },
        data(){
            return {
                tableData: [],
                years: [],
                selectedYear: new Date().getFullYear(),
                selectedMonth: String('0'+(new Date().getMonth()+1)).slice(-2),
            };
        },
        methods: {
            fetchData(){
                let component = this;
                axios.get(this.fetchUrl)
                    .then(data => {
                        component.tableData = data.data;
                    })
                    .catch(function (error) {
                        this.loadErrorDialog();
                    })
            },
            fetchByMonth(){
                let component = this;
                axios.get(this.monthUrl+'?year='+this.selectedYear+'&month='+this.selectedMonth)
                    .then(data => {
                        component.tableData = data.data;
                    })
                    .catch(error => {
                        this.loadErrorDialog();
                    });
            }
        },
        mounted(){
            let currentYear = new Date().getFullYear();
            this.years = [currentYear-2,currentYear-1,currentYear];
            this.fetchData();
        }
    }
</script>
<style scoped>
    .table {
        background: #fff;
    }
    .fixed-header{
        width: 503px;
        table-layout: fixed;
    }
    .fixed-header tbody{
        display: block;
        overflow-y: auto;
        height: 250px;
        width: 100%;
    }
    .fixed-header thead tr{
        display: block;
        position: relative;
    }
    td:nth-child(1), th:nth-child(1) {
        min-width: 250px
    }
    td:nth-child(2), th:nth-child(2) {
        min-width: 250px
    }
</style>