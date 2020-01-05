<template>
    <div>
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register">Register</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="edit">Edit</button>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline">
                <div class="form-group ml-3">
                    <label for="company_name">Company name</label>
                </div>
                <div class="form-group ml-3">
                    <input class="form-control" type="text" name="company_name" id="company_name"
                           v-model="company_name">
                </div>
                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary" @click.prevent="search">Search</button>
                </div>
                <div class="form-group ml-3">
                    <button type="reset" class="btn btn-primary">Clear</button>
                </div>
            </form>
        </div>
        <ejs-grid :dataSource="data" :allowSorting="true" :frozenColumns="3">
            <e-columns>
                <e-column field='vehicle_no' headerText='Vehicle No' width="100"></e-column>
                <e-column field='company_name' headerText='Company Name' width="150"></e-column>
                <e-column field='company_kana_name' headerText='Kana Name' width="150"></e-column>
                <e-column field='vehicle_company_abbreviation' headerText='Company Abbr' width="150"></e-column>
                <e-column field='vehicle_postal_code' textAlign="Center" headerText='Postal Code' width="150"></e-column>
                <e-column field='vehicle_address1' headerText='Address' width="200"></e-column>
                <e-column field='vehicle_address2' headerText='Address 2' width="200"></e-column>
                <e-column field='vehicle_phone_number' headerText='Phone' width="200"></e-column>
                <e-column field='vehicle_fax_number' headerText='Fax' width="200"></e-column>
                <e-column field='offset' headerText='Offset' textAlign="Center" width="100"></e-column>
                <e-column field='vehicle_remark' headerText='Remark' width="250"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>
<script type="text/ecmascript-6">
    import { GridPlugin, Sort, Freeze } from '@syncfusion/ej2-vue-grids';
    Vue.use(GridPlugin);

    export default {
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                company_name: '',
            }
        },
        created() {
//            return this.fetchData(this.fetchUrl)
        },
        methods: {
            fetchData(url) {
                axios.get(url)
                    .then(data => {
                        this.data = data.data.data
                    })
            },
            register(){
                alert('register action');
            },
            edit(){
                alert('edit action');
            },
            search(){
                return this.fetchData(this.fetchUrl+'?company_name='+this.company_name)
            },
            clear(){
                this.data = [];
                this.company_name = '';
            },
            /**
             * Get the serial number.
             * @param key
             * */
            serialNumber(key) {
                return key + 1;
            },
        },
        provide: {
            grid: [Sort,Freeze]
        },
        filters: {
            columnHead(value) {
                return value.split('_').join(' ').toUpperCase()
            }
        },
        name: 'VehicleTable'
    }
</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
</style>
