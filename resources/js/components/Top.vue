<template>
    <div id="top">
        <div class="row p-4">
            <div class="col-4">
                <form action="#" role="form">
                    <div class="form-group row">
                        <label for="year" class="col-2 offset-2">Year</label>
                        <select class="form-control col-7" name="year" id="year">
                            <option v-for="year in years">{{year}}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="month" class="col-2 offset-2">Month</label>
                        <select class="form-control col-7" name="month" id="month">
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
                            <button type="submit" id="display" class="btn btn-lg btn-block btn-primary">Display</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <table class="table fixed-header">
                    <thead>
                    <tr>
                        <th>Driver name</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in tableData">
                        <td>{{ item.driver_name }}</td>
                        <td>{{ item.amount }}</td>
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
        },
        data(){
            return {
                tableData: [],
                years: [],
            };
        },
        methods: {
            fetchData(){
                let component = this;
                axios.get(this.fetchUrl)
                    .then(data => {
                        console.log(data);
                        component.tableData = data.data;
                    })
                    .catch(function (error) {
                        alert(error);
                    })
            }
        },
        mounted(){
            let currentYear = new Date().getFullYear();
            this.years = [currentYear,currentYear-1,currentYear-2];
            this.fetchData();
        },
        computed: {

        }
    }
</script>
<style scoped>
    .table {
        background: #fff;
    }
    .fixed-header tbody {
        display: block;
        overflow: auto;
        height: 230px;
        width: 100%;
    }
</style>