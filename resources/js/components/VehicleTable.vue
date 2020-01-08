<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" v-if="this.mode == 'editing'">Editing</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register" :disabled="this.mode != 'editing'">Register</button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="edit">Edit</button>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline" @submit.prevent="search">
                <div class="form-group ml-3">
                    <label for="company_name">Company name</label>
                </div>
                <div class="form-group ml-3">
                    <select name="company_name" id="company_name" v-model="company_name" class="form-control">
                        <option value=""></option>
                        <option v-for="company in companies" :value="company.company_name">
                            {{ company.company_name }}
                        </option>
                    </select>
                </div>
                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <div class="form-group ml-3">
                    <button type="reset" class="btn btn-primary">Clear</button>
                </div>
            </form>
        </div>
        <ejs-grid :dataSource="data" :allowSorting="true" :editSettings="editSettings" height='300' :frozenColumns="3" :toolbar="toolbarBtns">
            <e-columns>
                <e-column field='vehicle_no' headerText='Vehicle No' width="100" :isPrimaryKey="true"></e-column>
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
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';
    import { DataManager, ODataAdaptor } from "@syncfusion/ej2-data";
    Vue.use( GridPlugin );

    export default {
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            companyUrl: {type: String, required: true},
        },
        data() {
            return {
                data: new DataManager({
                    url: this.fetchUrl,
                    adaptor: new ODataAdaptor()
                }),
                editSettings: {allowEditing: true, allowDeleting: true},
                toolbarBtns: [],
                company_name: '',
                companies: [],
                mode: 'normal'
            }
        },
        created() {
            return this.fetchCompanies(this.companyUrl);
        },
        methods: {
            fetchData(url) {
                axios.get(url)
                    .then(data => {
                        this.data = data.data.data
                    })
            },
            fetchCompanies(url) {
                axios.get(url)
                    .then(companies => {
                        this.companies = companies.data
                    })
            },
            register(){
                alert('register action');
                console.log(this.companies);
            },
            edit(){
                this.toolbarBtns = ['Edit','Delete','Update','Cancel'];
                this.mode = 'editing';
                this.editSettings.allowEditing = true;
                this.editSettings.allowDeleting = true;
            },
            search(){
                return this.fetchData(this.fetchUrl+'?company_name='+this.company_name)
            },
            clear(){
                this.$refs.grid.ej2Instances.clear();
                this.company_name = '';
            },
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar]
        },
        name: 'VehicleTable'
    }
</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-base/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-popups/styles/bootstrap.css";

</style>
