<template>
    <div class="vehicle">
        <div class="row">
            <div class="col-2">
                <a v-on:click="back"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 :hidden="!editMode" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-3">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-5">
                <p class="text-right">
                    <button @click="saveConfirmModal" :disabled="!editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}
                    </button>
                    <button @click="toEditMode" :disabled="editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}
                    </button>
                    <button @click="deleteConfirmModal" :disabled="!editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.delete')}}</button>
                </p>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline" @submit.prevent="search">
                <div class="form-group ml-3">
                    <label for="company_name">{{__('vehicle.company_name')}}</label>
                </div>
                <div class="form-group ml-3">
                    <select name="company_name" id="company_name" v-model="company_name" class="form-control" style="min-width: 200px">
                        <option value=""></option>
                        <option v-for="company in companies" :value="company.company_name">
                            {{ company.company_name }}
                        </option>
                    </select>
                </div>
                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary btn-fixed-width" :disabled='editMode'>{{__('common.search')}}</button>
                </div>
                <div class="form-group ml-3">
                    <button type="reset" class="btn btn-primary btn-fixed-width" @click.prevent="clear" :disabled='editMode'>{{__('common.clear')}}</button>
                </div>
            </form>
        </div>
        <div id="table-scroll" class="table-scroll">
            <table class="table table-custom-inputs">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sticky-col first-sticky-col">{{__('vehicle.vehicle_no')}}</th>
                    <th scope="col" class="sticky-col second-sticky-col">{{__('vehicle.company_name')}}</th>
                    <th scope="col" class="sticky-col third-sticky-col last-sticky-col">{{__('vehicle.kana_name')}}</th>
                    <th scope="col">{{__('vehicle.company_abbr')}}</th>
                    <th scope="col" width="100">{{__('vehicle.postal_code')}}</th>
                    <th scope="col">{{__('vehicle.address')}}</th>
                    <th scope="col">{{__('vehicle.address2')}}</th>
                    <th scope="col" width="150">{{__('vehicle.phone')}}</th>
                    <th scope="col" width="150">{{__('vehicle.fax')}}</th>
                    <th scope="col">{{__('vehicle.offset')}}</th>
                    <th scope="col">{{__('vehicle.remark')}}</th>
                    <th scope="col" class="primary-key">Vehicle Id</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(vehicle, index) in data" :data-key="vehicle.vehicle_id" :index="index"
                    @click="clickRow($event, index)" :hidden="vehicle.delete_flg == 1">
                    <td class="sticky-col first-sticky-col">
                        <div v-if="!editMode">{{vehicle.vehicle_no}}</div>
                        <the-mask mask="XXXX" masked="true" v-on:change="addRowOnChange" type="text" class="form-control" v-model='vehicle.vehicle_no' v-if='editMode'/>
                    </td>
                    <td class="sticky-col second-sticky-col">
                        <div v-if="!editMode">{{vehicle.company_name}}</div>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.company_name" v-if="editMode"/>
                    </td>
                    <td class="sticky-col third-sticky-col last-sticky-col">
                        <div v-if="!editMode">{{vehicle.company_kana_name}}</div>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.company_kana_name"
                               v-if="editMode"/>
                    </td>
                    <td>
                        <div v-if="!editMode">{{vehicle.vehicle_company_abbreviation}}</div>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.vehicle_company_abbreviation"
                               v-if="editMode"/>
                    </td>
                    <td>
                        <div v-if="!editMode">{{vehicle.vehicle_postal_code}}</div>
                        <the-mask mask="XXXXXXXX" masked="true" v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.vehicle_postal_code" v-if="editMode"/>
                    </td>
                    <td>
                        <div v-if="!editMode">{{vehicle.vehicle_address1}}</div>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.vehicle_address1" v-if="editMode"/>
                    </td>
                    <td>
                        <div v-if="!editMode">{{vehicle.vehicle_address2}}</div>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.vehicle_address2" v-if="editMode"/>
                    </td>
                    <td>
                        <div v-if="!editMode">{{vehicle.vehicle_phone_number}}</div>
                        <the-mask mask="XXXXXXXXXXXXX" masked="true" v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.vehicle_phone_number" v-if="editMode"/>
                    </td>
                    <td>
                        <div v-if="!editMode">{{vehicle.vehicle_fax_number}}</div>
                        <the-mask mask="XXXXXXXXXXXX" masked="true" v-on:change="addRowOnChange" type="text" class="form-control" v-model="vehicle.vehicle_fax_number" v-if="editMode"/>
                    </td>
                    <td style="min-width: 70px;">
                        <div v-if="!editMode"><span v-if="!editMode && vehicle.offset==0">{{__('vehicle.no')}}</span><span v-if="!editMode && vehicle.offset==1">{{__('vehicle.yes')}}</span></div>
                        <input v-on:change="addRowOnChange" type="checkbox" class="" v-model="vehicle.offset" v-if="editMode"/>
                    </td>
                    <td>
                        <div v-if="!editMode">{{vehicle.vehicle_remark}}</div>
                        <input v-on:change="addRowOnChange" type="text" :class="data.length-1 == index ? 'form-control last': 'form-control'"
                               v-model="vehicle.vehicle_remark" v-if="editMode"/>
                    </td>
                    <td class="primary-key">
                        <input type="text" class="form-control" v-model="vehicle.vehicle_id" v-if="editMode"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import Vue from "vue";
    import {TableUtil} from '../utils/TableUtil.js';
    import StickTableMixin from '../utils/StickyTableMixin'
    import VueTheMask from 'vue-the-mask'

    Vue.use(VueTheMask);

    export default{
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            companyUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        mixins : [
            StickTableMixin
        ],
        data() {
            return {
                data: [],
                tableUtil : undefined,
                company_name: '',
                companies: [],
                emptyRow : {
                    vehicle_no : '',
                    company_name : '',
                    company_kana_name : '',
                    vehicle_company_abbreviation : '',
                    vehicle_postal_code : '',
                    vehicle_address1 : '',
                    vehicle_address2 : '',
                    vehicle_phone_number : '',
                    vehicle_fax_number : '',
                    offset : false,
                    vehicle_remark : '',
                    vehicle_id : null,
                }
            }
        },
        mounted() {
            this.fetchCompanies();
            this.fetchVehicleData();
        },
        methods: {
            back() {
                if (this.isDataChanged()) {
                    this.confirmBack();
                } else {
                    window.location.href = this.backUrl;
                }
            },
            fetchVehicleData() {
                axios.get(this.resourceUrl+'?company_name='+this.company_name)
                    .then(response => {
                        this.data = response.data;
                        this.resetTable({data: this.data});
                    })
            },
            fetchCompanies() {
                axios.get(this.companyUrl)
                    .then(companies => {
                        this.companies = companies.data
                    });
            },
            search(){
                if (this.editMode)
                    this.saveConfirmModal();
                else
                    this.fetchVehicleData();

            },
            clear(){
                this.company_name = '';
            },
            refresh() {
                this.editMode = false;
                this.clear();
                this.fetchCompanies();
                this.search();
            },
        },
        name: 'VehicleTable'
    }
</script>
<style scoped>
    .vehicle .table-scroll{
        min-height: 400px;
        background-color: #fff;
    }
    .vehicle .table .thead-light th{
        background-color: #fff;
    }
    .vehicle .table-scroll table td{
        padding: 5px;
    }
    .vehicle .table td > div{
        padding: 0.375rem 0.75rem
    }
</style>
