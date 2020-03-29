<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a  v-on:click="back" class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 :hidden="!editMode" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-3">
                <h2 class="text-center">{{__('shipper.shipper_list')}}</h2>
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
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="selectedShipper">{{__('shipper.shipper')}}</label>
                    </div>
                    <div class="form-group ml-3">
                        <select id="selectedShipper" v-model="filter.shipper" class="form-control"
                                style="width: 280px;">
                            <option value=""></option>
                            <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                {{ shipper.fullname }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="selectedCompany">{{__('shipper.bill_to')}}</label>
                    </div>
                    <div class="form-group ml-3">
                        <select name="selectedCompany" id="selectedCompany" v-model="filter.billTo" class="form-control"
                                style="width: 280px;">
                            <option value=""></option>
                            <option v-for="company in companies" :value="company">
                                {{ company }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary btn-fixed-width">{{__('common.search')}}</button>
                    </div>
                    <div class="form-group ml-3">
                        <button type="reset" @click="clear" class="btn btn-primary btn-fixed-width">
                            {{__('common.clear')}}
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <div id="table-scroll" class="table-scroll">
            <table class="table table-custom-inputs">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sticky-col first-sticky-col">Shipper No</th>
                    <th scope="col" class="sticky-col second-sticky-col">Shipper</th>
                    <th scope="col" class="sticky-col third-sticky-col last-sticky-col">Furigana</th>
                    <th scope="col">Company abbr</th>
                    <th scope="col">Postal code</th>
                    <th scope="col">Address1</th>
                    <th scope="col">Address2</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">Fax number</th>
                    <th scope="col">Closing date</th>
                    <th scope="col">Payment date</th>
                    <th scope="col" class="primary-key">Shipper Id</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(shipper, index) in data" :data-key="shipper.shipper_id" :index="index"
                    @click="clickRow($event, index)" :hidden="shipper.delete_flg == 1">
                    <td class="sticky-col first-sticky-col">
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model='shipper.shipper_no' :disabled='!editMode'/>
                    </td>
                    <td class="sticky-col second-sticky-col">
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.shipper_name1" :disabled="!editMode"/>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.shipper_name2" :disabled="!editMode"/>
                    </td>
                    <td class="sticky-col third-sticky-col last-sticky-col">
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.shipper_kana_name1"
                               :disabled="!editMode"/>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.shipper_kana_name2"
                               :disabled="!editMode"/>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.shipper_company_abbreviation"
                               :disabled="!editMode"/>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.postal_code" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.address1" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.address2" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.phone_number" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="shipper.fax_number" :disabled="!editMode"/>
                    </td>
                    <td>
                        <select v-on:change="addRowOnChange" class="form-control" v-model="shipper.closing_date" :disabled="!editMode">
                            <option v-for="option in closingDateOptions" v-bind:value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="date" :class="data.length-1 == index ? 'form-control last': 'form-control'"
                               v-model="shipper.payment_date" :disabled="!editMode"/>
                    </td>
                    <td class="primary-key">
                        <input  type="text" class="form-control" v-model="shipper.shipper_id" :disabled="!editMode"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>
<script>
    import Vue from "vue";
    import {en, ja} from 'vuejs-datepicker/dist/locale'
    import StickTableMixin from '../utils/StickyTableMixin'

    export default {
        props: {
            backUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        mixins : [
            StickTableMixin
        ],
        data() {
            return {
                data: [],
                companies: [],
                shippers: [],
                filter: {
                    shipper: '',
                    billTo: ''
                },
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy-MM-dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
                closingDateOptions: [
                    {value: "0", text: __("shipper.closing_date_combo.option1")},
                    {value: "1", text: __("shipper.closing_date_combo.option2")},
                    {value: "2", text: __("shipper.closing_date_combo.option3")},
                ],
                emptyRow : {
                    shipper_no : '',
                    shipper_name1 : '',
                    shipper_name2 : '',
                    shipper_kana_name1 : '',
                    shipper_kana_name2 : '',
                    shipper_company_abbreviation : '',
                    postal_code : '',
                    address1 : '',
                    address2 : '',
                    phone_number : '',
                    fax_number : '',
                    closing_date : null,
                    payment_date : null,
                    shipper_id : null,
                }
            }
        },
        mounted() {
            this.fetchShipperNames();
            this.fetchCompanies();
            this.search();
        },
        methods: {
            back() {
              if (this.isDataChanged()) {
                  this.confirmBack();
              } else {
                  window.location.href = this.backUrl;
              }
            },
            fetchShipperNames() {
                let url = this.resourceUrl + '/fullname';
                axios.get(url)
                    .then(response => {
                        this.shippers = response.data;
                    });
            },
            fetchCompanies() {
                let url = this.resourceUrl + '/distinct-company';
                axios.get(url)
                    .then(response => {
                        this.companies = response.data
                    });
            },
            search() {
                if (this.editMode) {
                    this.saveConfirmModal();
                } else {
                    axios.post(this.resourceUrl + '/filter', this.filter)
                        .then(response => {
                            this.data = response.data;
                            this.resetTable(response);
                        })
                }
            },
            clear() {
                this.filter = {
                    shipper: '',
                    billTo: '',
                };
            },
            refresh() {
                this.editMode = false;
                this.clear();
                this.fetchShipperNames();
                this.fetchCompanies();
                this.search();
            },
        },
        name: 'ShipperList'
    }

</script>
