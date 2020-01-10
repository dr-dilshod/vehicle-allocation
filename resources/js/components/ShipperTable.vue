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
                <e-column field='shipper_no' headerText='Shipper No' width="100" :isPrimaryKey="true"></e-column>
                <e-column field='shipper_name' headerText='Shipper' width="150"></e-column>
                <e-column field='furigana' headerText='Furigana' width="150"></e-column>
                <e-column field='abbreviation' headerText='Abbreviation' width="150"></e-column>
                <e-column field='postal_code' textAlign="Postal code" headerText='Postal Code' width="150"></e-column>
                <e-column field='address1' headerText='Address 1' width="200"></e-column>
                <e-column field='address2' headerText='Address 2' width="200"></e-column>
                <e-column field='phone_number' headerText='Phone number' width="200"></e-column>
                <e-column field='fax_number' headerText='Fax number' width="200"></e-column>
                <e-column field='closing_date' headerText='Closing date' width="200"></e-column>
                <e-column field='payment_date' headerText='Payment date' width="200"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>
<script type="text/ecmascript-6">

    import Vue from "vue";
    import { GridPlugin, Freeze, Toolbar, Edit, DataStateChangeEventArgs, Sorts, Sort, Page, DataResult} from '@syncfusion/ej2-vue-grids';
    import { DataManager, RemoteSaveAdaptor } from "@syncfusion/ej2-data";
//    import { ShipperService } from "./order-service";

    Vue.use( GridPlugin );

    export default Vue.extend({
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            companyUrl: {type: String, required: true},
        },
        data() {
            return {
                dataSource: new DataManager({
                    json: this.fetchShippers(this.fetchUrl),
//                    url: this.fetchUrl,
                    adaptor: new RemoteSaveAdaptor(),
                    insertUrl: this.fetchUrl+'/Insert',
                    updateUrl: this.fetchUrl+'/Update',
                    removeUrl: this.fetchUrl+'/Delete'
                }),
                pageOptions: { pageSize: 10, pageCount: 4 },
                editSettings: {allowEditing: true, allowAdding: true, allowDeleting: true},
                toolbarBtns: [],
                company_name: '',
                companies: [],
                mode: 'normal',
            }
        },
        mounted() {
            let state = { skip: 0, take: 10 };
            this.dataStateChange(state);
        },
        created() {
            return this.fetchCompanies(this.companyUrl);
        },
        methods: {
            dataStateChange(state) {
                this.fetchShippers(this.fetchUrl);
                alert("DataStateChange");
                console.log(state);
            },
            dataSourceChanged(state) {
                alert("Data Source change");
                console.log(state);
                if (state.action === 'add') {
//                    this.orderService.addRecord(state).subscribe(() => state.endEdit());
                } else if (state.action === 'edit') {
//                    this.orderService.updateRecord(state).subscribe(() => state.endEdit());
                } else if (state.requestType === 'delete') {
//                    this.orderService.deleteRecord(state).subscribe(() => state.endEdit());
                }
            },
            fetchShippers(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data.data;
                        console.log(this.data);
                    });
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
        name: 'ShipperTable'
    });


</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-base/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-popups/styles/bootstrap.css";

</style>
