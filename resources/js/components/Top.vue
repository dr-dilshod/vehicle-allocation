<template>
    <div id="top">
        <div class="row p-4">
            <div class="col-4">
                <form action="#" role="form">
                    <div class="form-group row">
                        <label for="year" class="col-2 offset-2">Year</label>
                        <select class="form-control col-7" name="year" id="year" v-model="selectedYear">
                            <option v-for="year in years">{{year}}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="month" class="col-2 offset-2">Month</label>
                        <select class="form-control col-7" name="month" id="month" v-model="selectedMonth">
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-9 offset-2 pr-0">
                            <button type="submit" id="display" class="btn btn-lg btn-block btn-primary" @click.prevent="fetchByMonth">Display</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <table class="table fixed-header">
                    <thead>
                    <tr>
                        <th width="50%">Driver name</th>
                        <th width="50%">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in tableData">
                        <td width="50%">{{ item.driver_name }}</td>
                        <td width="50%">{{ item.amount }}</td>
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
                        console.error(error);
                    })
            },
            fetchByMonth(){
                let component = this;
                axios.get(this.monthUrl+'?year='+this.selectedYear+'&month='+this.selectedMonth)
                    .then(data => {
                        component.tableData = data.data;
                    })
                    .catch(error => {
                        console.error(error);
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